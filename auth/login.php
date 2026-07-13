<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Perpustakaan Digital</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/login.css">

</head>

<body>

    <div class="container">

        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-lg-4 col-md-6">

                <div class="card shadow-lg border-0 rounded-4 login-card">

                    <div class="card-body p-4 px-4">

                        <!-- Logo -->

                        <div class="text-center mb-3">

                            <img src="../assets/image/login.png"
                                class="logo mb-3">

                            <h3 class="fw-bold text-primary">

                                Perpustakaan Digital Sekolah

                            </h3>

                            <p class="text-secondary small mb-4">

                                Silakan masuk untuk mengakses layanan perpustakaan

                            </p>

                        </div>

                        <!-- FORM -->

                        <form action="proses_login.php" method="POST">

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    NIS

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-person"></i>

                                    </span>

                                    <input
                                        type="text"
                                        name="username"
                                        class="form-control"
                                        placeholder="Masukkan NIS atau Username"
                                        required>

                                </div>

                            </div>

                            <div class="mb-2">

                                <label class="form-label fw-semibold">

                                    Password

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-lock"></i>

                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control"
                                        placeholder="Masukkan Password"
                                        required>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword()">

                                        <i
                                            id="eyeIcon"
                                            class="bi bi-eye">

                                        </i>

                                    </button>

                                </div>

                            </div>

                            <div class="text-end mb-4">

                                <a
                                    href="#"
                                    class="small text-decoration-none">

                                    Lupa Password?

                                </a>

                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary w-100 py-2 rounded-3">

                                Masuk

                                <i class="bi bi-box-arrow-in-right ms-1"></i>

                            </button>

                        </form>

                        <hr>

                        <p class="text-center text-muted small mb-0">

                            © 2026 Sistem Informasi Perpustakaan Sekolah

                        </p>

                    </div>

                </div>

                <p class="text-center footer-text mt-4">

                    Butuh bantuan teknis? Hubungi Administrator Perpustakaan

                </p>

            </div>

        </div>

    </div>

    <script>

        function togglePassword() {

            let password = document.getElementById("password");

            let icon = document.getElementById("eyeIcon");

            if (password.type === "password") {

                password.type = "text";

                icon.classList.remove("bi-eye");

                icon.classList.add("bi-eye-slash");

            }

            else {

                password.type = "password";

                icon.classList.remove("bi-eye-slash");

                icon.classList.add("bi-eye");

            }

        }

    </script>

</body>

</html>