<?php 
$page="Đăng Ký";
include "./component_u/header_user.php";
include "./component_u/nav_user.php";
?>
<div id="main" class="py-3">
    <div class="form-container">
        <div class="title">
            Đăng Ký
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

        <form action="xuly.php" method="post" id="signupForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fullname" class="fw-bold">Tên đầy đủ:</label>
                <input type="text" class="form-control border border-dark" id="fullname" name="fullname" placeholder="Tên đầy đủ:">
            </div>
            <div class="form-group">
                <label for="sdt" class="fw-bold">Số điện thoại:</label>
                <input type="text" class="form-control border border-dark" id="sdt" name="sdt" placeholder="Nhập số điện thoại:">
            </div>
            <div class="form-group">
                <label for="email" class="fw-bold">Email:</label>
                <input type="text" class="form-control border border-dark" id="email" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <label for="password" class="fw-bold">Mật khẩu:</label>
                <input type="password" class="form-control border border-dark" id="password" name="password" placeholder="Mật khẩu:">
            </div>
            <div class="form-group">
                <label for="cf_password" class="fw-bold">Nhập lại mật khẩu:</label>
                <input type="password" class="form-control border border-dark" id="cf_password" name="cf_password" placeholder="Nhập lại mật khẩu:">
            </div>
            <div class="form-group">
                <label for="avatar" class="fw-bold">Chọn hình:</label>
                <input type="file" class="form-control border border-dark" id="avatar" name="avatar" placeholder="Nhập lại mật khẩu:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" id="dangky" value="Đăng ký" name="dangky">
            </div>
        </form>
    </div>
</div>
<?php include "./component_u/footer_user.php"; ?>