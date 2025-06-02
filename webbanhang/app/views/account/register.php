<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background: linear-gradient(120deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }
    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .register-container {
        width: 100%;
        max-width: 430px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 2rem 0;
    }
    .register-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .register-header img {
        height: 56px;
        margin-bottom: 1rem;
    }
    .register-header h2 {
        font-weight: 700;
        color: #1976d2;
        margin-bottom: 0.5rem;
    }
    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.3rem;
    }
    .form-control {
        border-radius: 12px;
        padding: 0.9rem 1.1rem;
        font-size: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e0e0e0;
        background: #f8fafc;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: #1976d2;
        background: #fff;
        box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.08);
    }
    .btn-register {
        width: 100%;
        padding: 0.9rem;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        background: #1976d2;
        border: none;
        color: #fff;
        margin-top: 0.5rem;
        margin-bottom: 1.2rem;
        transition: background 0.2s;
    }
    .btn-register:hover {
        background: #125ea8;
    }
    .error-list {
        background: #fff5f5;
        border-radius: 10px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.2rem;
    }
    .error-list li {
        color: #e53e3e;
        font-size: 0.97rem;
        margin-bottom: 0.3rem;
    }
    .social-login {
        text-align: center;
        margin-bottom: 1.2rem;
    }
    .social-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.3rem;
        font-size: 1.1rem;
        border: 1px solid #e0e0e0;
        background: #f8fafc;
        color: #1976d2;
        transition: all 0.2s;
    }
    .social-btn:hover {
        background: #1976d2;
        color: #fff;
        border-color: #1976d2;
    }
    .login-link {
        text-align: center;
        margin-top: 1.2rem;
        font-size: 1rem;
    }
    .login-link a {
        color: #1976d2;
        font-weight: 600;
        text-decoration: none;
    }
    .login-link a:hover {
        text-decoration: underline;
    }
    @media (max-width: 500px) {
        .register-container {
            padding: 1.2rem 0.5rem;
        }
    }
</style>

<div class="register-wrapper">
    <div class="register-container">
        <div class="register-header">
            <img src="/webbanhang/public/images/logo.png" alt="Logo">
            <h2>Đăng ký tài khoản</h2>
            <p class="text-muted mb-0">Vui lòng điền đầy đủ thông tin bên dưới</p>
        </div>

        <?php if (!empty($errors)) : ?>
            <ul class="error-list list-unstyled">
                <?php foreach ($errors as $err): ?>
                    <li><i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="/webbanhang/account/save" method="post" autocomplete="off" novalidate>
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" id="username" name="username" class="form-control"
                   placeholder="Nhập tên đăng nhập"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

            <label for="fullname" class="form-label">Họ và tên</label>
            <input type="text" id="fullname" name="fullname" class="form-control"
                   placeholder="Nhập họ và tên"
                   value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>" required>

            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="Nhập mật khẩu" required>

            <label for="confirmpassword" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" id="confirmpassword" name="confirmpassword" class="form-control"
                   placeholder="Nhập lại mật khẩu" required>

            <button type="submit" class="btn btn-register">
                <i class="fas fa-user-plus me-2"></i>Đăng ký
            </button>

            <div class="social-login">
                <span class="text-muted">Hoặc đăng ký với</span><br>
                <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-google"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
            </div>

            <div class="login-link">
                Đã có tài khoản?
                <a href="/webbanhang/account/login">Đăng nhập ngay</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>