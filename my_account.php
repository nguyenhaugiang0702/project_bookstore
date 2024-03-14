<?php 
$page = 'Tài Khoản Của Tôi';
include "./component_u/header_user.php";
include './component_u/nav_user.php';

?>

<div class="container-fluid px-5 py-4">
  <div class="row my-4">
    <div class="col-4 border">
      <?php include './component_u/sidebar_user.php'; ?>
    </div>
    <div class="col-8 border">
      <div class="row fw-bold fs-4 mx-auto">Hồ sơ của tôi</div>
      <div class="row mx-auto mb-3">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
      <div class="row mx-auto ">
        <hr>
      </div>
      <div class="row">
        <?php
        if (isset($_SESSION['status_success'])) {
          echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
          unset($_SESSION['status_success']);
        }
        ?>
        <div class="col-4 my-auto">
          <div class="row">
            <img src="/../project/uploads/<?= $row['tenHinh'] ?>" class="img-fluid" style="border-radius: 50%;" alt="">
          </div>
          <div class="row">
            <form action="xuly.php" method="post" enctype="multipart/form-data" id="myAccountForm">
              <input type="hidden" name="avatar_old" value="<?= $row['tenHinh'] ?>">
              <label for="avatar" class="fw-bold">Chọn hình:</label>
              <input type="file" name="avatar" id="avatar">
          </div>
        </div>
        <div class="col-6 ms-4">
          <div class="my-4 form-group">
            <label for="fullname_detail" class="fw-bold">Tên đầy đủ:</label>
            <input type="text" id="fullname_detail" readonly name="fullname_detail" class="form-control" value="<?= $row['nameUser'] ?>">
          </div>
          <div class="my-4 form-group">
            <label for="email_detail" class="fw-bold">Email:</label>
            <input type="text" class="form-control" readonly id="email_detail" name="email_detail" value="<?= $row['emailUser'] ?>">
          </div>
          <div class="my-4 form-group">
            <label for="sdt_detail" class="fw-bold">Số điện thoại:</label>
            <input type="text" class="form-control" readonly id="sdt_detail" name="sdt_detail" value="<?= $row['sdtUser'] ?>">
          </div>
          <div class="my-4 form-group">
            <button type="submit" class="btn btn-success" name="updateAvatar">Lưu</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "./component_u/footer_user.php"; ?>