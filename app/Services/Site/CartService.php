<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/5/2018
 * Time: 9:52 AM
 */

namespace App\Services\Site;

use Illuminate\Support\Facades\Mail;
use App\Repositories\InterfaceRepository\BillDetailRepositoryInterface;
use App\Repositories\InterfaceRepository\BillRepositoryInterface;
use App\Repositories\InterfaceRepository\CouponRepositoryInterface;
use App\Repositories\InterfaceRepository\MailboxRepositoryInterface;
use App\Repositories\InterfaceRepository\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use App\Models\Setting;

class CartService
{
    private $productRepository;
    private $couponRepository;
    private $billRepository;
    private $billDetailRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CouponRepositoryInterface $couponRepository,
                                BillRepositoryInterface $billRepository, BillDetailRepositoryInterface $billDetailRepository)
    {
        $this->productRepository = $productRepository;
        $this->couponRepository = $couponRepository;
        $this->billRepository = $billRepository;
        $this->billDetailRepository = $billDetailRepository;
    }

    public function add($request)
    {
        $data = $this->getDataProduct($request);
        if (2 !== count($data)) {
            return "ERR";
        } else {
            // cart is empty
            if (Session::get("product_in_cart") == null) {
                $dataProduct[$data["id"]] = (int)$data['qty'];
                $product = $this->productRepository->getProductByIdOnSite($data["id"]);
                Session::put("product_in_cart", $dataProduct);
                return array('type' => 'empty', 'id' => $data['id'], 'qty' => (int)$data['qty'], 'name' => $product->name, 'price' => $product->price, 'image' => $product->image);
            } else {
                $dataProduct = Session::get("product_in_cart");
                $product = $this->productRepository->getProductByIdOnSite($data["id"]);

                //cart is have not yet
                if (!array_key_exists($data["id"], $dataProduct)) {
                    $dataProduct[$data["id"]] = (int)$data['qty'];
                    Session::put("product_in_cart", $dataProduct);
                    return array('type' => 'new', 'id' => $data['id'], 'qty' => (int)$data['qty'], 'name' => $product->name, 'price' => $product->price, 'image' => $product->image);
                } else {
                    $dataProduct[$data["id"]] += $data['qty'];
                    Session::put("product_in_cart", $dataProduct);
                    return array('type' => 'old', 'id' => $data['id'], 'qty' => (int)$data['qty'], 'name' => $product->name, 'price' => $product->price);
                }
            }
        }
    }

    public function getDataProduct($request)
    {
        $data = [];
        if ($request->ajax()) {
            if ($request->has('id')) {
                $data["id"] = $request->id;
            }
            if ($request->has('size')) {
                $data["size"] = $request->size;
            }
            if ($request->has('color')) {
                $data["color"] = $request->color;
            }
            if ($request->has('qty')) {
                $data["qty"] = $request->qty;
            }
            return $data;
        } else {
            return $data[""];
        }
    }

    public function checkout()
    {
        $products = '';
        $coupon = Session::get("coupon");
        $coupon_fail = Session::get("coupon-fail");
        if (Session::get("product_in_cart") == null) {
            $data = "";
        } else {
            $data = Session::get("product_in_cart");
            $listId = array_keys($data);
            $products = $this->productRepository->getProductByListIdOnSite($listId);
        }
//        dd(Session::all());
        return [
            'dataCart' => $data,
            'products' => $products,
            'coupon' => $coupon,
            'coupon_fail' => $coupon_fail,
        ];
    }

    public function updateCart($request)
    {
        $dataCoupon = "";
        $qtyChange = $request->qty;
        $data = Session::get("product_in_cart");
        $dataRemove = Session::get("stt_remove_product");
        if ($request->coupon !== NULL) {
            $coupon = $request->coupon;
            $dataCoupon = $this->couponRepository->getCouponByCodeOnSite($coupon);
        }

        $this->updateCartInSession($data, $qtyChange, $dataRemove);

        if ($dataCoupon != "") {
            if ($dataCoupon->start_date <= date('Y-m-d') && $dataCoupon->end_date >= date('Y-m-d')) {
                Session::put("coupon", $dataCoupon);
            } else {
                Session::flash("coupon-fail", "true");
            }
        }
        return redirect()->back();

    }

    private function updateCartInSession($arrProductInCart, $qtyChange, $dataRemove)
    {
        $dataProduct = [];
        if ($dataRemove == NULL) {
            $dataRemove = [];
        }

        if (count($qtyChange) > 0) {
            foreach ($qtyChange as $key => $value) {
                if ($value == 0) {
                    unset($arrProductInCart[$key]);
                } else {
                    $arrProductInCart[$key] = $value;
                }
            }
        }

        foreach ($dataRemove as $key => $value) {
            unset($arrProductInCart[$value]);
        }
        Session::put("product_in_cart", $arrProductInCart);
    }

    public function remove($request)
    {
        $dataRemove = [];
        if (Session::get("stt_remove_product") != null) {
            $dataRemove = Session::get("stt_remove_product");
        }

        if ($request->ajax()) {
            if ($request->has('id')) {
                $dataRemove[] = $request->id;
            }
            array_unique($dataRemove);
            sort($dataRemove);
            Session::flash("stt_remove_product", $dataRemove);
        } else {
            return "ERR";
        }
    }

    public function paying()
    {
        $data = Session::get("product_in_cart");
        $coupon = Session::get("coupon");
        $listId = array_keys($data);
        $products = $this->productRepository->getProductByListIdOnSite($listId);

        return [
            'dataCart' => $data,
            'products' => $products,
            'coupon' => $coupon,
        ];
    }

    public function confirm($request)
    {
        $xhtml = '';
        $contactConfigItem = Setting::where('option_name', 'setting_contact')->first();
        $configSetting = json_decode($contactConfigItem->option_value);
        $generalConfig['fe_name_shop'] = 'KBOX Shop';
        $generalConfig['fe_email_cskh'] = $configSetting->email;
        $generalConfig['fe_phone_top'] = $configSetting->phone;
        $logo = $_SERVER['HTTP_HOST'] . '/public/frontend/img/logo.png';
        $data = [
            'full_name' => checkInputString($request->full_name),
            'phone' => checkInputString($request->phone),
            'email' => checkInputString($request->email),
            'address' => checkInputString($request->address),
            'note' => checkInputString($request->note),
        ];
        $newBill = $this->billRepository->store($data);
        if ($newBill) {
            $dataCart = Session::get("product_in_cart");
            $coupon = Session::get("coupon");
            $listId = array_keys($dataCart);
            $products = $this->productRepository->getProductByListIdOnSite($listId);
            $totalBill = 0;

            // Info Order
            $xhtml_order = '<h2 style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:#22A7F0">CHI TIẾT ĐƠN HÀNG</h2>';
            $xhtml_order .= '<table cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f5f5f5;max-width: 730px">';
            $xhtml_order .= '<thead>';
            $xhtml_order .= '<tr>';
            $xhtml_order .= '<th align="left" bgcolor="#22A7F0" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tên sản phẩm</th>';
            $xhtml_order .= '<th align="center" bgcolor="#22A7F0" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px;width:120px">Giá tiền</th>';
            $xhtml_order .= '<th align="left" bgcolor="#22A7F0" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Số lượng</th>';
            $xhtml_order .= '<th align="right" bgcolor="#22A7F0" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px;width:120px">Thành tiền</th></tr></thead>';

            foreach ($dataCart as $key => $value) {

                $billId = $newBill->id;
                $productId = $key;
                $qty = $value;
                $price = $products[$productId]->price;

                $totalBill += ($qty * $price);
                $dataDetail = [
                    'bill_id' => $billId,
                    'product_id' => $productId,
                    'price' => $price,
                    'qty' => $qty
                ];

                $xhtml_order .= '<tbody bgcolor="#eee" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">';
                $xhtml_order .= '<tr>';
                $xhtml_order .= "<td align='left' valign='top' style='padding:3px 9px'>" . $products[$productId]->name . "</td>";
                $xhtml_order .= "<td align='center' valign='top' style='padding:3px 9px'>" . number_format($price) . " đ</td>";
                $xhtml_order .= "<td align='center' valign='top' style='padding:3px 9px'>" . $dataDetail['qty'] . "</td>";
                $xhtml_order .= "<td align='right' valign='top' style='padding:3px 9px'>" . number_format($price * $dataDetail['qty']) . " đ</td></tr></tbody>";

                $this->billDetailRepository->store($dataDetail);
            }

            $priceSale = 0;
            if ($coupon != null) {
                if ($coupon->amount_type == "amount") {
                    $priceSale = $coupon->amount;
                } else {
                    $priceSale = $totalBill * $coupon->amount / 100;
                }
            }
            $totalBill -= $priceSale;
            $dataBillUpdate = [
                'price_sale' => $priceSale,
                'amount' => $totalBill,
            ];
            $this->billRepository->update($dataBillUpdate, $newBill->id);

            $xhtml_order .= '<tfoot style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">';
            $xhtml_order .= '<tr>';
            $xhtml_order .= "<td colspan='3' align='right' style='padding:5px 9px'>Tổng tạm tính</td>";
            $xhtml_order .= "<td align='right' style='padding:5px 9px'>" . number_format($dataBillUpdate['price_sale'] + $dataBillUpdate['amount']) . " Đ</td></tr>";
            $xhtml_order .= '<tr>';
            if ($dataBillUpdate['price_sale'] > 0) {
                $xhtml_order .= "<tr><td colspan='3' align='right' style='padding:5px 9px'>Giảm giá</td>";
                $xhtml_order .= "<td align='right' style='padding:5px 9px'>" . number_format($dataBillUpdate['price_sale']) . " Đ</td></tr>";
            }
            $xhtml_order .= "<tr bgcolor='#eee'><td colspan='3' align='right' style='padding:5px 9px'><strong>Tổng trị giá đơn hàng</strong></td>";
            $xhtml_order .= "<td align='right' style='padding:5px 9px'><strong>" . number_format($dataBillUpdate['amount']) . " Đ</strong></td></tr>";
            $xhtml_order .= "</tfoot></table>";

            // Info Customer

            $xhtml .= '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#dcf0f8" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">';
            $xhtml .= '<tbody>';
            $xhtml .= '<tr>';
            $xhtml .= '<td align="center" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">';
            $xhtml .= '<table border="0" cellpadding="0" cellspacing="0" width="730" style="margin-top:15px">';
            $xhtml .= '<tbody>';

            // Name company
            $xhtml .= '<tr>';
            $xhtml .= '<td align="center" valign="bottom" id="m_-1280436372562772285m_-2715138282138443481headerImage">
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:3px solid #22A7F0;padding-bottom:10px;background-color:#fff">
                            <tbody>
                                <tr>
                                    <td valign="top" bgcolor="#FFFFFF" width="100%" style="padding:0">
                                        <a style="border:medium none;text-decoration:none;color:#22A7F0;margin:0px 120px 0px 20px" href="#" target="_blank" >
                                        </a>
                                        <a style="border:medium none;text-decoration:none;color:#22A7F0" href="#" target="_blank">
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>';
            $xhtml .= '</tr>';

            $xhtml .= '<tr style="background:#fff">
                    <td align="left" width="900" height="auto" style="padding:15px;max-width: 900px">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">
                                            Cảm ơn quý khách ' . $data['full_name'] . ' đã đặt hàng tại ' . $generalConfig['fe_name_shop'] . ',
                                        </h1>
                                        <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                            ' . $generalConfig['fe_name_shop'] . ' rất vui thông báo đơn hàng #' . $billId . ' của quý khách đã được tiếp nhận và đang trong quá trình xử lý! ' . $generalConfig['fe_name_shop'] . ' sẽ thông
                                            báo đến quý khách ngay khi hàng chuẩn bị được giao.
                                        </p>
                                        <h3 style="font-size:13px;font-weight:bold;color:#22A7F0;text-transform:uppercase;margin:20px 0 0 0;border-bottom:1px solid #ddd">
                                            Thông tin đơn hàng #' . $billId . '
                                            <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">' . date("d/m/Y h:i:s a", time()) . '</span>
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align="left" width="50%" style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold">
                                                        Thông tin thanh toán
                                                    </th>
                                                    <th align="left" width="50%" style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold">
                                                        Địa chỉ giao hàng
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding:3px 9px 9px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                        <span style="text-transform:capitalize">' . $data['full_name'] . '</span>
                                                        <br> <a href="mailto:' . $data['email'] . '" target="_blank">' . $data['email'] . '</a>
                                                        <br> ' . $data['phone'] . '
                                                    </td>
                                                    <td valign="top" style="padding:3px 9px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">

                                                        ' . $data['address'] . '

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding:7px 9px 0px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" colspan="2">
                                                        <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                            <strong>Phương thức thanh toán: </strong>
                                                            Thanh toán tiền mặt khi nhận hàng

                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                            <i>Lưu ý: Đối với đơn hàng đã được thanh toán trước, nhân viên giao nhận
                                            có thể yêu cầu người nhận hàng cung cấp CMND / giấy phép lái xe để
                                            chụp ảnh hoặc ghi lại thông tin.</i>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ' . $xhtml_order . '
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br>
                                        <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                            Trường hợp quý khách có những băn khoăn về đơn hàng, có thể xem thêm mục
                                            <a href="" title="Các câu hỏi thường gặp" target="_blank">
                                            <strong>các câu hỏi thường gặp</strong>.</a>
                                        </p>
                                        <p style="margin:10px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                            Bạn cần được hỗ trợ ngay? Chỉ cần email
                                            <a href="mailto:' . $generalConfig['fe_email_cskh'] . '" style="color:#22A7F0;text-decoration:none" target="_blank">
                                            <strong>' . $generalConfig['fe_email_cskh'] . '</strong>
                                            </a>, hoặc gọi số điện thoại
                                            <strong style="color:#22A7F0">' . $generalConfig['fe_phone_top'] . '</strong> (8-21h cả T7,CN). Đội ngũ ' . $generalConfig['fe_name_shop'] . ' luôn sẵn sàng
                                            hỗ trợ bạn bất kì lúc nào.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br>
                                        <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">
                                            Một lần nữa ' . $generalConfig['fe_name_shop'] . ' cảm ơn quý khách.
                                            <br>
                                        </p>
                                        <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;text-align:right">
                                            <strong>
                                            <a style="color:#22A7F0;text-decoration:none;font-size:14px" href="#">' . $generalConfig['fe_name_shop'] . '</a>
                                            </strong>
                                            <br>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>';

            $xhtml .= '</tbody>';
            $xhtml .= '</table>';
            $xhtml .= '</td>';
            $xhtml .= '</tr>';
            $xhtml .= '</tbody>';
            $xhtml .= '</table>';

            $email = $data['email'];

            $object = [
                'xhtml' => $xhtml,
                'email' => $generalConfig['fe_email_cskh']
            ];

            Mail::send([], [], function ($message) use ($email, $object) {
                $message->from('cskhk-box@gmail.com', 'KBOX Shop');
                $message->to($email);
                $message->cc($object['email']);
                $message->subject("Đặt hàng thành công");
                $message->setBody($object['xhtml'], 'text/html');
            });
        }

        Session::forget('product_in_cart');
        Session::forget('coupon');
    }
}