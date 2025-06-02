<?php

/**
 * Controller xử lý các chức năng liên quan đến Danh mục sản phẩm
 * Tuân theo mô hình MVC (Model-View-Controller)
 * - Điều khiển luồng xử lý giữa Model và View
 * - Xử lý các request từ người dùng
 * - Gọi các phương thức tương ứng từ Model
 * - Trả dữ liệu về View để hiển thị
 */

// Import các file cần thiết
require_once('app/config/database.php');  // Class kết nối database
require_once('app/models/CategoryModel.php');  // Model xử lý dữ liệu danh mục

/**
 * Class CategoryController
 * Xử lý các thao tác CRUD cho danh mục sản phẩm
 */
class CategoryController
{
    /**
     * @var CategoryModel Đối tượng model để tương tác với database
     * Được khởi tạo trong constructor
     */
    private $categoryModel;

    /**
     * @var PDO Đối tượng kết nối database
     * Được truyền vào CategoryModel để thực hiện các truy vấn
     */
    private $db;

    /**
     * Constructor - Khởi tạo controller
     * - Thiết lập kết nối database
     * - Khởi tạo model với kết nối database
     */
    public function __construct()
    {
        // Tạo kết nối database mới
        $this->db = (new Database())->getConnection();
        // Khởi tạo model với kết nối vừa tạo
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Phương thức mặc định, được gọi khi truy cập /Category
    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    /**
     * Phương thức hiển thị danh sách danh mục
     * - Lấy dữ liệu từ model thông qua getCategories()
     * - Load view tương ứng để hiển thị dữ liệu
     */
    public function list()
    {
        // Lấy danh sách danh mục từ model
        $categories = $this->categoryModel->getCategories();
        // Load view hiển thị danh sách, truyền dữ liệu $categories vào view
        include 'app/views/category/list.php';
    }

    public function add()
    {
        include 'app/views/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            if (empty($name)) {
                $error = "Tên danh mục không được để trống";
                include 'app/views/category/add.php';
                return;
            }

            if ($this->categoryModel->addCategory($name, $description)) {
                header('Location: /webbanhang/Category');
                exit();
            } else {
                $error = "Có lỗi xảy ra khi thêm danh mục.";
                include 'app/views/category/add.php';
            }
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            echo "Không tìm thấy danh mục.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            if (empty($name) || empty($id)) {
                $error = "Thông tin không đầy đủ";
                $category = $this->categoryModel->getCategoryById($id);
                include 'app/views/category/edit.php';
                return;
            }

            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header('Location: /webbanhang/Category');
                exit();
            } else {
                $error = "Có lỗi xảy ra khi cập nhật danh mục.";
                $category = $this->categoryModel->getCategoryById($id);
                include 'app/views/category/edit.php';
            }
        }
    }

    public function delete($id)
    {
        if (empty($id)) {
            header('Location: /webbanhang/Category');
            exit();
        }

        try {
            if ($this->categoryModel->deleteCategory($id)) {
                header('Location: /webbanhang/Category');
            } else {
                throw new Exception("Không thể xóa danh mục.");
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $categories = $this->categoryModel->getCategories();
            include 'app/views/category/list.php';
        }
    }
}
?>