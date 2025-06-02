<?php include 'app/views/shares/header.php'; ?>

<style>
  /* Container and card */
  .register-container {
    max-width: 480px;
    margin: 3rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 8px 24px rgba(102, 166, 255, 0.2);
  }

  /* Header */
  .register-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  .register-header h2 {
    font-weight: 700;
    color: #4a90e2;
  }

  /* Form inputs */
  .form-control {
    border-radius: 50px;
    padding: 1rem 1.5rem;
    font-size: 1rem;
  }

  /* Error list */
  .error-list {
    margin-bottom: 1rem;
    padding-left: 1.25rem;
  }
  .error-list li {
    color: #dc3545;
    font-weight: 600;
  }

  /* Button */
  .btn-register {
    width: 100%;
    padding: 1rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
  }

  /* Responsive small cols */
  @media (max-width: 576px) {
    .row > [class*='col-'] {
      margin-bottom: 1rem;
    }
  }
</style>

<div class="register-container shadow-sm">
  <div class="register-header">
    <h2>Đăng ký tài khoản mới</h2>
    <p class="text-muted">Vui lòng điền đầy đủ thông tin bên dưới</p>
  </div>

  <?php if (!empty($errors)) : ?>
    <ul class="error-list">
      <?php foreach ($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="/webbanhang/account/save" method="post" autocomplete="off" novalidate>
    <div class="row">
      <div class="col-sm-6">
        <label for="username" class="form-label">Tên đăng nhập</label>
        <input 
          type="text" 
          id="username" 
          name="username" 
          class="form-control" 
          placeholder="Nhập tên đăng nhập" 
          value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" 
          required
        >
      </div>
      <div class="col-sm-6">
        <label for="fullname" class="form-label">Họ và tên</label>
        <input 
          type="text" 
          id="fullname" 
          name="fullname" 
          class="form-control" 
          placeholder="Nhập họ và tên" 
          value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>" 
          required
        >
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-sm-6">
        <label for="password" class="form-label">Mật khẩu</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          class="form-control" 
          placeholder="Nhập mật khẩu" 
          required
        >
      </div>
      <div class="col-sm-6">
        <label for="confirmpassword" class="form-label">Xác nhận mật khẩu</label>
        <input 
          type="password" 
          id="confirmpassword" 
          name="confirmpassword" 
          class="form-control" 
          placeholder="Nhập lại mật khẩu" 
          required
        >
      </div>
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary btn-register">Đăng ký</button>
    </div>
  </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
