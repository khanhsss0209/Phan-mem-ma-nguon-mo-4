<?php

/**
 * Class DefaultController
 * Controller mặc định xử lý các request đến trang chủ
 * Được gọi khi không có controller cụ thể nào được chỉ định trong URL
 * Ví dụ: Khi truy cập /webbanhang/ hoặc /webbanhang/index
 */
class DefaultController {
    /**
     * Phương thức mặc định của controller
     * Được gọi tự động khi không có action cụ thể nào được chỉ định
     * Nhiệm vụ: Chuyển hướng người dùng đến trang danh sách sản phẩm
     */
    public function index() {
        // Sử dụng hàm header() của PHP để chuyển hướng (redirect)
        // Tham số là đường dẫn đến trang đích
        // /webbanhang/Product/list: Chuyển đến action list của ProductController
        header('Location: /webbanhang/Product/list');
        
        // Dừng thực thi code sau khi chuyển hướng
        // Tránh việc tiếp tục thực thi các đoạn code không cần thiết
        exit();
    }
}

?>
