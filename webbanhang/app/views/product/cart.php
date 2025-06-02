<?php include 'app/views/shares/header.php'; ?>

<style>
.delete-btn {
    min-width: 80px;
    height: 35px;
    padding: 0 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
    box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2);
    border-radius: 4px;
    color: white;
    font-weight: 500;
    font-size: 14px;
}

.delete-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    background: linear-gradient(45deg, #c82333, #bd2130);
}

.quantity-input {
    width: 80px;
    text-align: center;
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.quantity-input:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.loading {
    opacity: 0.5;
    pointer-events: none;
}

.cart-section {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
    background: #f8f9fa;
}

.cart-container {
    margin-top: 2rem;
    margin-bottom: 2rem;
}
</style>

<div class="cart-section">
    <div class="container cart-container">
        <h2 class="mb-4">Giỏ hàng của bạn</h2>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <div class="alert alert-info">
                Giỏ hàng trống. <a href="/webbanhang/Product">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                    <tr id="cart-item-<?php echo $id; ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="/webbanhang/<?php echo htmlspecialchars($item['image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                         class="img-thumbnail mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php endif; ?>
                                                <span><?php echo htmlspecialchars($item['name']); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                        <td>
                                            <input type="number" min="1" value="<?php echo $item['quantity']; ?>" 
                                                   class="form-control quantity-input" style="width: 80px;"
                                                   data-id="<?php echo $id; ?>">
                                        </td>
                                        <td class="item-total">
                                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND
                                        </td>
                                        <td>
                                            <button class="btn delete-btn remove-item" data-id="<?php echo $id; ?>" 
                                                    title="Xóa sản phẩm này">
                                                Xóa
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><strong>Tổng cộng:</strong></td>
                                    <td class="text-right"><strong class="cart-total"><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="text-right mt-3">
                        <a href="/webbanhang/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
                        <a href="/webbanhang/Product/checkout" class="btn btn-primary">Thanh toán</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cập nhật số lượng với debounce
    let updateTimeout;
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const row = this.closest('tr');
            row.classList.add('loading');
            
            clearTimeout(updateTimeout);
            updateTimeout = setTimeout(() => {
                updateCartItem(this, row);
            }, 300);
        });
    });

    // Cập nhật xử lý xóa sản phẩm
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                const id = this.dataset.id;
                const row = this.closest('tr');
                row.classList.add('loading');

                try {
                    const response = await fetch(`/webbanhang/Product/removeFromCart/${id}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();
                    
                    if (data.success) {
                        row.remove();
                        const cartTotal = document.querySelector('.cart-total');
                        if (cartTotal) {
                            cartTotal.textContent = data.newTotal + ' VND';
                        }
                        
                        // Kiểm tra xem giỏ hàng có rỗng không
                        if (data.newTotal === '0') {
                            window.location.reload();
                        }
                    } else {
                        throw new Error(data.message || 'Có lỗi khi xóa sản phẩm');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi xóa sản phẩm');
                } finally {
                    row.classList.remove('loading');
                }
            }
        });
    });
});

function updateCartItem(input, row) {
    const id = input.dataset.id;
    const quantity = parseInt(input.value);
    
    if (quantity < 1) {
        input.value = 1;
        row.classList.remove('loading');
        return;
    }

    fetch(`/webbanhang/Product/updateCart/${id}/${quantity}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            row.querySelector('.item-total').textContent = data.itemTotal + ' VND';
            document.querySelector('.cart-total').textContent = data.newTotal + ' VND';
        } else {
            throw new Error(data.message || 'Có lỗi khi cập nhật giỏ hàng');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
        input.value = input.defaultValue; // Reset to previous value
    })
    .finally(() => {
        row.classList.remove('loading');
    });
}
</script>

<?php include 'app/views/shares/footer.php'; ?>