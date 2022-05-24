<?php
    if(!isset($_SESSION)){ob_start();session_start();}
    spl_autoload_register(function ($TenLop) {
        $file = 'classes/' . $TenLop. '.php';
        if (is_readable($file))
        {
            require_once($file);
        }
        else
            trigger_error("The class '" . $TenLop . "' or the file '" . $TenLop . "' failed to spl_autoload ");
    });

    //Khởi tạo đường dẫn tĩnh
    $site_path = realpath(dirname(__FILE__));
    define('__SITE_PATH', $site_path);

    //Khởi tạo thông số chung
    include_once __SITE_PATH . '/helper/functions.php';
    
    //Nhúng file đầu - css và js
    include_once __SITE_PATH . '/component/head.php';

    //Nhúng file menu - phân hệ, quyền truy cập, màn hình thiết bị (nếu mở rộng)
    include_once __SITE_PATH . '/component/menu.php';

    //Nhúng file nội dung - file động
    $action = isset($_GET['action']) ? $_GET['action'] : 'frontend/home/index';
    include_once $action . '.php';

    //Nhúng file cuối - các thẻ đóng
    include_once __SITE_PATH . '/component/foot.php';
?>