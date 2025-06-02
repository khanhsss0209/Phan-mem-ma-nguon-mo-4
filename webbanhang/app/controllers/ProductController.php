<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Check file size
        if ($file["size"] > 10 * 1024 * 1024) { // 10MB
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        // Check if file already exists - Optional: you might want to rename or overwrite
        // if (file_exists($target_file)) {
        //     throw new Exception("Tên file đã tồn tại.");
        // }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        header('Location: /webbanhang/Product/cart');
    }

    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = 0;
        
        // Calculate total
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        include 'app/views/product/cart.php';
    }

    public function checkout()
    {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /webbanhang/Product/cart');
            exit();
        }

        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get form data with proper field names and validation
            $name = $_POST['customer_name'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $address = $_POST['address'] ?? null;

            // Validate required fields
            if (empty($name) || empty($phone) || empty($address)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin";
                header('Location: /webbanhang/Product/checkout');
                exit();
            }

            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Bắt đầu giao dịch
            $this->db->beginTransaction();
            try {
                // Lưu thông tin đơn hàng với dữ liệu đã validate
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();

                $order_id = $this->db->lastInsertId();

                // Lưu chi tiết đơn hàng
                foreach ($_SESSION['cart'] as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                             VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                unset($_SESSION['cart']);
                $this->db->commit();
                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                $this->db->rollBack();
                $_SESSION['error'] = "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
                header('Location: /webbanhang/Product/checkout');
                exit();
            }
        }
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

    public function removeFromCart($id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $response = ['success' => false];
        
        try {
            if (isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
                
                // Calculate new total
                $total = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
                
                $response = [
                    'success' => true,
                    'newTotal' => number_format($total, 0, ',', '.'),
                    'message' => 'Sản phẩm đã được xóa'
                ];
            } else {
                $response['message'] = 'Không tìm thấy sản phẩm trong giỏ hàng';
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        header('Location: /webbanhang/Product/cart');
        exit;
    }

    public function updateCart($id, $quantity)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $quantity = max(1, intval($quantity));
            
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] = $quantity;
                
                // Calculate new totals
                $itemTotal = $_SESSION['cart'][$id]['price'] * $quantity;
                $total = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                $response = [
                    'success' => true,
                    'newQuantity' => $quantity,
                    'itemTotal' => number_format($itemTotal, 0, ',', '.'),
                    'newTotal' => number_format($total, 0, ',', '.')
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>