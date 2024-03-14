<?php
$page = 'Đăng Nhập';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";
?>
<div id="main" class="py-3">
    <div class="form-container">
        <div class="title">
            Đăng Nhập
        </div>
        <?php
        if (isset($_SESSION['status_success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
            unset($_SESSION['status_success']);
        } else if (isset($_SESSION['status_warning'])) {
            echo '<div class="alert alert-warning">' . $_SESSION['status_warning'] . '</div>';
            unset($_SESSION['status_warning']);
        } else if (isset($_SESSION['status_danger'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['status_danger'] . '</div>';
            unset($_SESSION['status_danger']);
        }
        ?>
        <form action="xuly.php" method="post" id="LoginForm">
            <div class="form-group">
                <label for="email" class="fw-bold">Email:</label>
                <input type="email" class="form-control border border-dark" name="email" id="email" placeholder="Nhập Email">
            </div>
            <div class="form-group">
                <label for="password" class="fw-bold">Mật khẩu:</label>
                <input type="password" class="form-control border border-dark" name="password" id="password" placeholder="Nhập Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Đăng nhập" name="dangnhap">
            </div>
            <div class="text_forgotpass_signup">
                <div class="text_change_to_php">
                    <i>Bạn đã có tài khoản ?</i> <b><a href="register.php" style="text-decoration: none;">Đăng ký</a></b>
                </div>
                <div class="text_change_to_php">
                    <b><a href="forgot.php" style="text-decoration: none;">Quên mật khẩu ?</a></b>
                </div>
            </div>

        </form>
    </div>
</div>
<?php include "./component_u/footer_user.php"; ?>