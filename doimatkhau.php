<?php
$page = 'Đổi Mật Khẩu';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";

?>

<div class="container-fluid px-5 py-4">
    <div class="row my-4">
        <div class="col-4 border">
            <?php include './component_u/sidebar_user.php'; ?>
        </div>
        <div class="col-8 border">
            <div class="row fw-bold fs-4 mx-auto">Đổi mật khẩu</div>
            <div class="row mx-auto mb-3">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
            <div class="row mx-auto ">
                <hr>
            </div>
            <div class="row">
                <div class="form-container">
                    <div class="title">
                        Đổi Mật Khẩu
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
                    <form action="xuly.php" id="ChangePassForm" method="post">
                        <div class="form-group">
                            <label for="email" class="fw-bold">Email:</label>
                            <input type="email" class="form-control border border-dark" name="email" id="email" placeholder="Nhập Email:">
                        </div>
                        <div class="form-group">
                            <label for="oldpass" class="fw-bold">Mật khẩu cũ:</label>
                            <input type="password" class="form-control border border-dark" name="oldpass" id="oldpass" placeholder="Nhập mật khẩu cũ:">
                        </div>
                        <div class="form-group">
                            <label for="newpass" class="fw-bold">Mật khẩu mới:</label>
                            <input type="password" class="form-control border border-dark" name="newpass" id="newpass" placeholder="Nhập mật khẩu mới:">
                        </div>
                        <div class="form-group">
                            <label for="cfnewpass" class="fw-bold">Nhập lại mật khẩu mới:</label>
                            <input type="password" class="form-control border border-dark" name="cfnewpass" id="cfnewpass" placeholder="Nhập lại mật khẩu mới:">
                        </div>
                        <div class="form-btn">
                            <input type="submit" class="btn btn-primary" value="Đổi mật khẩu" name="doimatkhau">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./component_u/footer_user.php"; ?>