<?php
function stripUnicode($text) {
    if (!$text) {
        return false;
    }
    $unicode = [
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ',
        'D' => 'Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    ];
    foreach ($unicode as $nonUnicode => $uni) {
        $array = explode("|", $uni);
        $text  = str_replace($array, $nonUnicode, $text);
    }

    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    $text = preg_replace('~[^-\w]+~', '', $text);

    $text = trim($text, '-');

    $text = preg_replace('~-+~', '-', $text);

    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}
function AliasString($str) {
    $str = trim($str);
    if ($str == "") {
        return "";
    }
    $str = str_replace('"', ' ', $str);
    $str = str_replace("'", ' ', $str);
    $str = str_replace(".", ' ', $str);
    $str = stripUnicode($str);
    $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
    $str = str_replace(' ', '-', $str);

    return $str;
}

function checkInputSoKhongAm($number){
    return ($number < 0 ? 0 : $number);
}
function checkInputString($string){
    return (null == $string ? '' : $string);
}

function checkStatusCheckBox($status){
    return (true == $status ? 1:0);
}

function showButtonMove($id, $type = 'up', $valChild, $valParent, $route) {
    $icon = 'fa-arrow-up';
    if($type != 'up'){
        $type = 'down';
        $icon = 'fa-arrow-down';
    }
    if($valChild == $valParent)
        return "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";

    return sprintf('<button type="button" onclick="javascript:moveNode(\'%s\', \'%s\', \'%s\')" class="btn btn-success"><i class="fa %s"></i></button>',
        $id, $type, $route, $icon);
}
