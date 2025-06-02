<?php

/**
 * CategoryModel - Model xử lý dữ liệu danh mục sản phẩm
 * Thực hiện các thao tác CRUD với bảng category trong database
 */
class CategoryModel
{
    /**
     * @var PDO $conn Đối tượng PDO để kết nối và tương tác với database
     * Được truyền vào thông qua constructor
     */
    private $conn;

    /**
     * @var string $table_name Tên bảng trong database
     * Được sử dụng trong các câu truy vấn SQL
     */
    private $table_name = "category";

    /**
     * Constructor - Khởi tạo model với kết nối database
     * @param PDO $db Đối tượng PDO đã được khởi tạo
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy danh sách tất cả danh mục từ database
     * 
     * @return array Mảng các đối tượng danh mục
     * 
     * Các bước thực hiện:
     * 1. Tạo câu truy vấn SQL
     * 2. Chuẩn bị câu truy vấn với prepare() để tránh SQL injection
     * 3. Thực thi câu truy vấn với execute()
     * 4. Lấy kết quả dưới dạng mảng các đối tượng với fetchAll()
     */
    public function getCategories()
    {
        // Tạo câu truy vấn SQL để lấy dữ liệu từ bảng category
        $query = "SELECT id, name, description FROM " . $this->table_name;

        // Chuẩn bị câu truy vấn an toàn với prepare()
        // prepare() giúp tránh SQL injection bằng cách tách biệt câu lệnh SQL và dữ liệu
        $stmt = $this->conn->prepare($query);

        // Thực thi câu truy vấn đã chuẩn bị
        // execute() chạy câu truy vấn và trả về true/false
        $stmt->execute();

        // Lấy tất cả kết quả dưới dạng mảng các đối tượng
        // PDO::FETCH_OBJ: Mỗi record sẽ được chuyển thành một object
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Trả về mảng các đối tượng danh mục
        return $result;
    }

    public function getCategoryById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addCategory($name, $description)
    {
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }

    public function updateCategory($id, $name, $description)
    {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $id = htmlspecialchars(strip_tags($id));

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>