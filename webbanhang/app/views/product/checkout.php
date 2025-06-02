<?php include 'app/views/shares/header.php'; ?>

<style>
.checkout-section {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
    background: #f8f9fa;
}
.checkout-container {
    margin-top: 2rem;
    margin-bottom: 2rem;
}
</style>

<div class="checkout-section">
    <div class="container checkout-container">
        <h2 class="mb-4">Thanh toán</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4>Thông tin đơn hàng</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th class="text-right">Giá</th>
                                    <th class="text-right">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td class="text-right"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                        <td class="text-right"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                                    <td class="text-right"><strong><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Thông tin thanh toán</h4>
                        <form method="POST" action="/webbanhang/Product/processCheckout">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <textarea name="address" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Xác nhận đặt hàng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>