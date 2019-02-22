<?php
return [
    'VALIDATE_MESSAGE' => array(
        'MESSAGE_REQUIRED'          => 'Nội dung không được bỏ trống.',

        'NAME_REQUIRED'             => 'Tên không được bỏ trống.',
        'NAME_UNIQUE'               => 'Tên không được trùng.',
        'NAME_PRODUCT_MAX'          => 'Tên không được dài quá 65 kí tự.',

        'PRICE_REQUIRED'            => 'Giá tiền không được bỏ trống.',
        'PRICE_NUMERIC'             => 'Giá tiền phải là số.',

        'EMAIL_REQUIRED'            => 'Email không được bỏ trống',
        'EMAIL_UNIQUE'              => 'Email không được trùng.',
        'EMAIL_INVALID'             => 'Email không đúng định dạng.',
        'EMAIL_REGISTER_INVALID'    => 'Email Register có phần tử không đúng định dạng.',
        'EMAIL_CONTACT_INVALID'     => 'Email Contact có phần tử không đúng định dạng.',

        'PASSWORD_REQUIRED'         => 'Mật khẩu không được bỏ trống.',
        'PASSWORD_MIN'              => 'Mật khẩu tối thiểu 6 kí tự.',
        'PASSWORD_MAX'              => 'Mật khẩu tối đa 25 kí tự.',
        'RE_PASSWORD_REQUIRED'         => 'Mật khẩu không được bỏ trống.',
        'RE_PASSWORD_MIN'              => 'Mật khẩu tối thiểu 6 kí tự.',
        'RE_PASSWORD_MAX'              => 'Mật khẩu tối đa 25 kí tự.',
        'RE_PASSWORD_SAME'              => 'Mật khẩu không giống.',

        'PHONE_REQUIRED'            => 'Điện thoại không được bỏ trống.',
        'PHONE_INVALID'             => 'Điện thoại không đúng định dạng.',
        'PHONE_NUMERIC'             => 'Điện thoại phải là số.',
        'PHONE_MIN'                 => 'Số điện thoại không hợp lệ',
        'PHONE_MAX'                 => 'Số điện thoại không hợp lệ',
        'PHONE_UNIQUE'              => 'Số điện thoại đã có người đăng ký.',

        'IMAGE_REQUIRED'            => 'Chưa chọn hình ',
        'IMAGE_MIMES'               => 'Chỉ chấp nhận định dạng hình: jpeg,bmp,png,jpg',

        'FULLNAME_REQUIRED'         => 'Họ tên không được để trống.',
        'FULLNAME_MAX'              => 'Họ tên dài tối đa 255 kí tự.',
        'FULLNAME_REGEX'              => 'Họ tên chỉ bao gồm chữ.',

        'SUBJECT_REQUIRED'          => 'Tiêu đề không được để trống.',
        'SUBJECT_MAX'               => 'Tiêu đề dài tối đa 255 kí tự.',
        'SUBJECT_REGEX'               => 'Tiêu đề chỉ bao gồm chữ.',

        'ADDRESS_REQUIRED'          => 'Địa chỉ không được bỏ trống.',

        'DESCRIPTION_REQUIRED'      => 'Mô tả không được bỏ trống.',

        'CONTENT_REQUIRED'          => 'Nội dung không được bỏ trống.',

        'CATEGORY_REQUIRED'         => 'Danh mục không được bỏ trống.',

        'MAP_REQUIRED'              => 'Bản đồ không được bỏ trống.',

        // SEO
        'META_TILE_REQUIRED'        => 'Meta title không được để trống',
        'META_KEYWORDS_REQUIRED'    => 'Meta keywords không được để trống.',
        'META_DESCRIPTION_REQUIRED' => 'Meta description không được để trống.',

        // SOCIAL
        'FACEBOOK_URL_INVALID'      => 'URL Facebook không hợp lệ',
        'GOOGLE_URL_INVALID'        => 'URL Google không hợp lệ',
        'YOUTUBE_URL_INVALID'       => 'URL Youtube không hợp lệ',
        'TWITTER_URL_INVALID'       => 'URL Twitter không hợp lệ',

        'URL_REQUIRED'              => 'URL không hợp lệ',

        'TYPE_REQUIRED'             => 'Loại không hợp lệ',

        'COUPON_REQUIRED'           => 'Mã giảm giá không được bỏ trống.',
        'COUPON_UNIQUE'             => 'Mã giảm giá không được trùng.',

        'START_DATE_REQUIRED'       => 'Ngày bắt đầu không được để trống',
        'START_DATE_IS_DATE'        => 'Ngày bắt đầu phải là kiểu ngày',
        'START_DATE_AFTER'          => 'Ngày bắt đầu phải bắt đầu là ngày hiện tại',

        'END_DATE_REQUIRED'         => 'Ngày kết thúc không được để trống',
        'END_DATE_IS_DATE'          => 'Ngày kết thúc phải là kiểu ngày',
        'END_DATE_AFTER_OR_EQUAL'   => 'Ngày kết thúc phải sau ngày bắt đầu',

        'AMOUNT_TYPE_REQUIRED'      => 'Loại giá trị không được bỏ trống',

        'AMOUNT_REQUIRED'           => 'Giá trị không được bỏ trống',
        'STATUS_REQUIRED'           => 'Trạng thái không được bỏ trống',

        'SIZE_REQUIRED'             => 'Size không được bỏ trống',
        'COLOR_REQUIRED'            => 'Màu không được bỏ trống',

        // Hotel
        // Room
        'ROOM_NUMBER_REQUIRED'      => 'Số phòng không được bỏ trống',
        'ROOM_NUMBER_UNIQUE'        => 'Số phòng không được trùng',
        'ROOM_TYPE_REQUIRED'        => 'Loại phòng không được bỏ trống',
    ),

    'SUCCESSFUL_MESSAGE' => array(
        'ADD'                       => 'Thêm thành công',
        'EDIT'                      => 'Chỉnh sứa thành công',
        'CHANGE_STATUS'             => 'Trạng thái cập nhật thành công.',
        'DELETE'                    => 'Xoá phần tử thành công',
        'SAVE'                      => 'Cập nhật thành công.'
    ),

    'ERROR_MESSAGE' => array(
        'ERROR'                     => 'Đã có lỗi xảy ra. Vui lòng thử lại sau.'
    )
];