<?php

/**
 * Class Database
 * Lớp này xử lý kết nối và tương tác với cơ sở dữ liệu MySQL sử dụng PDO
 * PDO (PHP Data Objects) là một lớp trừu tượng để truy cập database
 * Ưu điểm của PDO:
 * - Hỗ trợ nhiều loại database khác nhau
 * - Bảo mật với Prepared Statements
 * - Xử lý lỗi tốt hơn với try-catch
 */
class Database {
    /**
     * @var string $host Địa chỉ máy chủ database
     * Thường là localhost cho môi trường phát triển local
     * Có thể thay đổi thành IP hoặc domain name trong môi trường production
     */
    private $host = "localhost";

    /**
     * @var string $db_name Tên của database sẽ kết nối
     * Đảm bảo database này đã được tạo trước trong MySQL
     */
    private $db_name = "my_store";

    /**
     * @var string $username Tên người dùng MySQL
     * Cần có quyền truy cập đến database được chỉ định
     */
    private $username = "root";

    /**
     * @var string $password Mật khẩu của người dùng MySQL
     * Nên được mã hóa hoặc lấy từ biến môi trường trong production
     */
    private $password = "";

    /**
     * @var PDO $conn Biến lưu trữ kết nối PDO
     * Public để có thể truy cập từ bên ngoài class
     * Được khởi tạo trong getConnection()
     */
    public $conn;

    /**
     * Phương thức thiết lập và trả về kết nối PDO đến MySQL database
     * 
     * @return PDO|null Trả về đối tượng PDO nếu kết nối thành công, null nếu thất bại
     * @throws PDOException Ném ra ngoại lệ nếu kết nối thất bại
     */
    public function getConnection() {
        // Khởi tạo giá trị null cho connection
        $this->conn = null;

        try {
            // Tạo kết nối PDO mới với các thông số:
            // - DSN (Data Source Name): chuỗi kết nối chứa host và tên database
            // - Username và password để xác thực
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );

            // Thiết lập charset UTF8 cho kết nối
            // exec() thực thi trực tiếp câu lệnh SQL
            // set names utf8 đảm bảo hiển thị đúng ký tự tiếng Việt
            $this->conn->exec("set names utf8");
        } 
        // Bắt và xử lý ngoại lệ PDO nếu có lỗi kết nối
        catch(PDOException $exception) {
            // In thông báo lỗi để debug
            // Trong môi trường production nên log lỗi thay vì hiển thị
            echo "Connection error: " . $exception->getMessage();
        }

        // Trả về đối tượng connection để sử dụng
        // Có thể là null nếu kết nối thất bại
        return $this->conn;
    }
}