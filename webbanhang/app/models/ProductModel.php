<?php

/**
 * ProductModel - Model xử lý dữ liệu sản phẩm
 * Thực hiện các thao tác CRUD với bảng product trong database
 * Sử dụng PDO để tương tác an toàn với database
 */
class ProductModel
{
    /**
     * @var PDO Đối tượng PDO để kết nối database
     */
    private $conn;

    /**
     * @var string Tên bảng trong database
     */
    private $table_name = "product";

    /**
     * Khởi tạo model với kết nối database
     * @param PDO $db Đối tượng PDO đã được khởi tạo
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy danh sách tất cả sản phẩm kèm tên danh mục
     * Sử dụng LEFT JOIN để lấy thêm thông tin từ bảng category
     * @return array Mảng các đối tượng sản phẩm
     */
    public function getProducts()
    {
        // Câu truy vấn SQL với JOIN để lấy thêm tên danh mục
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id;";

        // prepare(): Chuẩn bị câu truy vấn, giúp tránh SQL injection
        $stmt = $this->conn->prepare($query);
        
        // execute(): Thực thi câu truy vấn đã chuẩn bị
        $stmt->execute();
        
        // fetchAll(): Lấy tất cả kết quả trả về
        // PDO::FETCH_OBJ: Chuyển mỗi record thành một object
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Lấy thông tin chi tiết một sản phẩm theo ID
     * @param int $id ID của sản phẩm cần lấy
     * @return object|false Đối tượng sản phẩm hoặc false nếu không tìm thấy
     */
    public function getProductById($id)
    {
        $query = "SELECT p.*, c.name as category_name FROM " . $this->table_name . " p LEFT JOIN category c ON p.category_id = c.id WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        
        // bindParam(): Gắn giá trị cho tham số trong câu truy vấn
        // Giúp tránh SQL injection bằng cách tự động escape các ký tự đặc biệt
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Thêm sản phẩm mới vào database
     * @param string $name Tên sản phẩm
     * @param string $description Mô tả sản phẩm
     * @param float $price Giá sản phẩm
     * @param int $category_id ID danh mục
     * @param string $image Đường dẫn hình ảnh
     * @return bool|array True nếu thành công, mảng lỗi nếu thất bại
     */
    public function addProduct($name, $description, $price, $category_id, $image)
    {
        // Kiểm tra và validate dữ liệu đầu vào
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }

        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }

        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        // Assume image validation logic would be here

        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        // htmlspecialchars(): Chuyển đổi các ký tự đặc biệt thành HTML entities
        // strip_tags(): Loại bỏ các thẻ HTML, PHP từ chuỗi
        //  là một phần xử lý dữ liệu đầu vào trong PHP, dùng để làm sạch dữ liệu trước khi lưu vào cơ sở dữ liệu hoặc hiển thị ra giao diện.
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image)); // Assuming image is stored as a string (e.g., path)

        // bindParam(): Gắn giá trị cho các tham số trong câu truy vấn
        // Giúp tránh SQL injection bằng cách tự động escape các ký tự đặc biệt
        // sử dụng PDO để gắn giá trị các biến PHP vào các tham số trong câu SQL chuẩn bị trước 
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        // execute(): Thực thi câu truy vấn đã chuẩn bị
        // Nếu thực thi thành công, trả về true
        // Nếu không thành công, trả về false
        // PDO::errorInfo(): Lấy thông tin lỗi nếu có
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Cập nhật thông tin sản phẩm
     * @param int $id ID sản phẩm cần cập nhật
     * @param string $name Tên mới
     * @param string $description Mô tả mới
     * @param float $price Giá mới
     * @param int $category_id ID danh mục mới
     * @param string $image Đường dẫn hình ảnh mới
     * @return bool True nếu thành công, False nếu thất bại
     */
    public function updateProduct($id, $name, $description, $price, $category_id, $image)
    {
        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description, price=:price, category_id=:category_id, image=:image WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image)); // Assuming image is stored as a string (e.g., path)


        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);


        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Xóa sản phẩm khỏi database
     * @param int $id ID sản phẩm cần xóa
     * @return bool True nếu thành công, False nếu thất bại
     */
    public function deleteProduct($id)
    {
        /* $this: đại diện cho đối tượng hiện tại trong lập trình hướng đối tượng.

            conn: là thuộc tính của đối tượng, chứa một kết nối đến cơ sở dữ liệu, thường là một đối tượng của lớp PDO.

            prepare: là phương thức của đối tượng PDO, dùng để chuẩn bị một câu lệnh SQL (thường có chứa tham số) trước khi thực thi.

            bindParam : được dùng để gắn một biến PHP vào một tham số trong câu SQL đã được chuẩn bị (prepared statement).

            execute() : thực thi câu lệnh SQL (đã được chuẩn bị trước)
        */
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}