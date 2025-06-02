<?php include 'app/views/shares/header.php'; ?>

<style>
  /* Dark mode styles */
  .dark-mode {
    background: linear-gradient(120deg, #1e1e2f 0%, #2a2a40 100%) !important;
    color: #ddd !important;
    transition: background 0.3s, color 0.3s;
  }

  .dark-mode .card {
    background-color: #2b2b3a !important;
    color: #ddd !important;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
    transition: background-color 0.3s, color 0.3s;
  }

  .dark-mode .form-control {
    background-color: #3a3a4d !important;
    color: #eee !important;
    border: 1px solid #555 !important;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
  }

  .dark-mode .form-control:focus {
    background-color: #3a3a4d !important;
    color: #fff !important;
    border-color: #66a6ff !important;
    box-shadow: 0 0 0 0.25rem rgba(102, 166, 255, 0.5);
  }

  .dark-mode .form-label,
  .dark-mode .form-text,
  .dark-mode p,
  .dark-mode a {
    color: #bbb !important;
  }

  .dark-mode a.text-primary {
    color: #66a6ff !important;
  }

  .dark-mode .btn-primary {
    background-color: #4a90e2;
    border-color: #4a90e2;
  }

  .dark-mode .btn-primary:hover {
    background-color: #357abd;
    border-color: #357abd;
  }

  .dark-mode .alert-danger {
    background-color: #721c24;
    color: #f8d7da;
    border-color: #f5c6cb;
  }

  .dark-mode .btn-outline-primary {
    color: #66a6ff !important;
    border-color: #66a6ff !important;
  }

  .dark-mode .btn-outline-primary:hover {
    background-color: #66a6ff;
    color: #fff !important;
  }

  .dark-mode .btn-outline-info {
    color: #4ac0e8 !important;
    border-color: #4ac0e8 !important;
  }

  .dark-mode .btn-outline-info:hover {
    background-color: #4ac0e8;
    color: #fff !important;
  }

  .dark-mode .btn-outline-danger {
    color: #e44a4a !important;
    border-color: #e44a4a !important;
  }

  .dark-mode .btn-outline-danger:hover {
    background-color: #e44a4a;
    color: #fff !important;
  }

  /* Custom styling */
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  #login-section {
    background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
    transition: background 0.3s;
  }

  .card {
    border-radius: 1.5rem;
    background: #fff;
    transition: background-color 0.3s, color 0.3s;
    box-shadow: 0 8px 24px rgba(102, 166, 255, 0.2);
  }

  .card-body {
    padding: 3rem 2.5rem;
  }

  h2 {
    font-weight: 700;
    font-size: 2.2rem;
  }

  p.lead {
    font-size: 1.1rem;
    margin-bottom: 2rem;
  }

  .form-control.rounded-pill {
    padding: 1rem 1.5rem;
  }

  .btn-primary {
    padding: 0.75rem;
    font-size: 1.2rem;
    font-weight: 600;
  }

  .form-check-label {
    user-select: none;
  }

  .text-muted {
    font-size: 0.9rem;
  }

  .form-check.form-switch {
    justify-content: center;
    margin-top: 2rem;
  }
</style>

<section id="login-section" class="vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-7 col-lg-5 col-xl-4">
        <div class="card shadow-lg border-0">
          <div class="card-body">
            <h2 class="text-center text-primary mb-3">Đăng nhập</h2>
            <p class="lead text-center text-muted">
              Vui lòng nhập tài khoản và mật khẩu để tiếp tục
            </p>

            <?php if (isset($error)) : ?>
              <div class="alert alert-danger shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo htmlspecialchars($error); ?>
              </div>
            <?php endif; ?>

            <form action="/webbanhang/account/checklogin" method="post" autocomplete="off" novalidate>
              <div class="form-floating mb-4">
                <input
                  type="text"
                  name="username"
                  id="username"
                  class="form-control rounded-pill"
                  placeholder="Tên đăng nhập"
                  required
                  autocomplete="username"
                  aria-describedby="usernameHelp"
                />
                <label for="username">Tên đăng nhập</label>
                <div id="usernameHelp" class="form-text">Nhập tên đăng nhập của bạn.</div>
              </div>

              <div class="form-floating mb-4">
                <input
                  type="password"
                  name="password"
                  id="password"
                  class="form-control rounded-pill"
                  placeholder="Mật khẩu"
                  required
                  autocomplete="current-password"
                  aria-describedby="passwordHelp"
                />
                <label for="password">Mật khẩu</label>
                <div id="passwordHelp" class="form-text">Nhập mật khẩu bảo mật của bạn.</div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    id="rememberMe"
                    value="1"
                  />
                  <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                </div>
                <a href="#" class="text-decoration-none text-primary small">Quên mật khẩu?</a>
              </div>

              <button class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm" type="submit">
                Đăng nhập
              </button>

              <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="#" class="btn btn-outline-primary btn-floating rounded-circle" aria-label="Facebook">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="btn btn-outline-info btn-floating rounded-circle" aria-label="Twitter">
                  <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="btn btn-outline-danger btn-floating rounded-circle" aria-label="Google">
                  <i class="fab fa-google"></i>
                </a>
              </div>

              <p class="mt-4 mb-0 text-center text-muted">
                Chưa có tài khoản?
                <a href="/webbanhang/account/register" class="fw-bold text-primary text-decoration-none">Đăng ký ngay</a>
              </p>

              <!-- Dark mode toggle -->
              <div class="form-check form-switch mt-4 text-center">
                <input class="form-check-input" type="checkbox" id="toggleDarkMode" />
                <label class="form-check-label" for="toggleDarkMode">Chế độ tối</label>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  const toggle = document.getElementById('toggleDarkMode');
  const section = document.getElementById('login-section');

  // Bật/tắt dark mode khi thay đổi switch
  toggle.addEventListener('change', () => {
    if (toggle.checked) {
      section.classList.add('dark-mode');
      localStorage.setItem('darkModeEnabled', 'true');
    } else {
      section.classList.remove('dark-mode');
      localStorage.setItem('darkModeEnabled', 'false');
    }
  });

  // Giữ trạng thái dark mode khi reload trang
  window.addEventListener('load', () => {
    if (localStorage.getItem('darkModeEnabled') === 'true') {
      toggle.checked = true;
      section.classList.add('dark-mode');
    }
  });
</script>

<?php include 'app/views/shares/footer.php'; ?>
