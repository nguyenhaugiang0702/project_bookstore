<?php
if (isset($_SESSION['customer_id'])) {
    require './config/connect.php';
    $select_user = $conn->prepare("SELECT * FROM users u, avatar a WHERE u.idUser=a.idUser AND u.idUser=?");
    $select_user->execute([$_SESSION['customer_id']]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="row">
    <div class="col-3"><img class="img-fluid rounded" src="/../project/uploads/<?php if(isset($row['tenHinh'])) echo $row['tenHinh']; ?>" alt=""></div>
    <div class="col-9 my-auto">
        <div class="row fw-bold fs-4 text-break"><?php if(isset($row['nameUser'])) echo $row['nameUser']; ?></div>
        <div class="row">Thay đổi</div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-1 fs-3"><i class="fa-solid fa-user"></i></div>
    <div class="col my-auto">Tài khoản của tôi</div>
</div>
<div class="row mt-auto">
    <div class="col-1"></i></div>
    <div class="col"><a href="my_account.php" class="text-decoration-none text-dark <?php if ($page == 'Tài Khoản Của Tôi') echo 'actived' ?>">Hồ sơ</a> </div>
</div>
<div class="row mt-2">
    <div class="col-1"></i></div>
    <div class="col"><a href="doimatkhau.php" class="text-decoration-none text-dark <?php if ($page == 'Đổi Mật Khẩu') echo 'actived' ?>">Đổi mật khẩu</a></div>
</div>
<div class="row mt-2">
    <div class="col-1"></i></div>
    <div class="col"><a href="thaydoithongtin.php" class="text-decoration-none text-dark <?php if ($page == 'Thông Tin Của Tôi') echo 'actived' ?>">Đổi thông tin</a></div>
</div>
<div class="row mt-2">
    <div class="col-1"></i></div>
    <div class="col"><a href="diachigh.php" class="text-decoration-none text-dark <?php if ($page == 'Địa Chỉ Giao Hàng') echo 'actived' ?>">Địa chỉ giao hàng</a></div>
</div>
<div class="row my-4">
    <div class="col-1 fs-3"><i class="fa-solid fa-list"></i></div>
    <div class="col my-auto"><a href="donhang.php" class="text-decoration-none text-dark <?php if ($page == 'Đơn Hàng') echo 'actived' ?>">Đơn mua</a></div>
</div>
<div class="row my-4">
    <div class="col-1 fs-3"><i class="fa-solid fa-heart"></i></div>
    <div class="col my-auto"><a href="yeuthich.php" class="text-decoration-none text-dark <?php if ($page == 'Yêu Thích') echo 'actived' ?>">Yêu thích</a></div>
</div>