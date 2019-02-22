<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 23:20
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\DB;
use App\Services\BillService;

class DashboardController extends Controller
{
    private $_billService;

    public function __construct(BillService $billService)
    {
        $this->_billService = $billService;
    }

    public function index() {
        $totalCategoryProduct = DB::table('categories_product')->where('id','<>', 0)->where('status', 'active')->count();
        $totalProduct = DB::table('products')->where('status', 'active')->count();
        $totalUser = DB::table('users')->where('status', 'active')
                                            ->where('group_id', 2)->count();
        $totalMail = DB::table('mailboxes')->where('status', 0)->where('trash', 0)->count();

        // Get Bill Today
        $billToday = $this->_billService->getBillToday();

        // Chart Bill
        $billSuccess = $this->_billService->chartBillSuccess();
        $dataLabelChart = array();
        $dataValueChart = array();
        foreach($billSuccess as $bill) {
            $dataLabelChart[] = $bill->new_date;
            $dataValueChart[] = $bill->amount;
        }

        $chart = Charts::create('line', 'highcharts')
                        ->title('Doanh thu của cửa hàng')
                        ->elementLabel('Doanh thu theo tháng - năm')
                        ->labels($dataLabelChart)
                        ->values($dataValueChart)
                        ->dimensions(1170,500)
                        ->responsive(false);

        $data = array(
            'totalProduct'      => $totalProduct,
            'totalUser'         => $totalUser,
            'totalCategoryProduct' => $totalCategoryProduct,
            'totalMailbox'      => $totalMail,
            'billToday'         => $billToday,
            'chart'             => $chart
        );

        return view('admin.pages.dashboard.index', [
            'data'  => $data
        ]);
    }
}