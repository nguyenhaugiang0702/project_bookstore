<?php
$page = 'Quên Mật Khẩu';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";
?>
<div id="main" class="py-3">
    <div class="form-container">
        <div class="title">
            Quên Mật Khẩu
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
        <form action="xuly.php" id="ForgotForm" method="post">
            <div class="form-group">
                <label for="email" class="fw-bold">Email:</label>
                <input type="text" class="form-control border border-dark" id="email" name="email" placeholder="Nhập Email">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Gửi" name="gui">
            </div>
        </form>
    </div>
</div>
<?php include "./component_u/footer_user.php"; ?>