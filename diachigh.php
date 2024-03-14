<?php 
$page = 'Địa Chỉ Giao Hàng';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";

?>
<?php

if (isset($_SESSION['customer_id'])) {
    require './config/connect.php';
    $select_user = $conn->prepare("SELECT * FROM users u, avatar a WHERE u.idUser=a.idUser AND u.idUser=?");
    $select_user->execute([$_SESSION['customer_id']]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
} else {
    header('location: login_users.php');
}

?>


<div class="container-fluid px-5 py-4">
    <div class="row my-4">
        <div class="col-4 border">
            <?php include './component_u/sidebar_user.php'; ?>
        </div>
        <div class="col-8 border">
            <div class="row fw-bold fs-4 mx-auto">Địa chỉ giao hàng</div>
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
            <div class="row mx-auto mb-3">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
            <div class="row mx-auto ">
                <hr>
            </div>
            <div class="row mx-5 my-3">
                <?php
                if (isset($_SESSION['status_success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                    unset($_SESSION['status_success']);
                } else if (isset($_SESSION['status_warning'])) {
                    echo '<div class="alert alert-warning">' . $_SESSION['status_warning'] . '</div>';
                    unset($_SESSION['status_warning']);
                }
                ?>
                <div class="row">
                    <table id="datatable" class="table">
                        <thead class="table-primary">
                            <tr>
                                <th>ĐỊA CHỈ</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require './config/connect.php';
                            $select_dcgh = $conn->prepare("SELECT * FROM diachigh d, tinh t, quan_huyen q, xa x WHERE d.idTinh=t.idTinh 
                    AND d.idQH=q.idQH AND d.idXa=x.idXa AND idUser='$_SESSION[customer_id]'");
                            $select_dcgh->execute();
                            if ($select_dcgh->rowCount() > 0) {
                                while ($row_dcgh = $select_dcgh->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td><?php
                                            if ($row_dcgh['status'] == 1) {
                                            ?>
                                                <span class="text-success fw-bold">
                                                    <?php
                                                    echo $row_dcgh['diachi'] . ', ';
                                                    echo $row_dcgh['tenXa'] . ', ';
                                                    echo $row_dcgh['tenQH'] . ', ';
                                                    echo $row_dcgh['tenTinh'];
                                                    ?>
                                                </span>
                                            <?php
                                            } else {
                                                echo $row_dcgh['diachi'] . ', ';
                                                echo $row_dcgh['tenXa'] . ', ';
                                                echo $row_dcgh['tenQH'] . ', ';
                                                echo $row_dcgh['tenTinh'];
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row_dcgh['status'] == 1) {
                                            ?>                                                
                                                <a onclick="return confirm('Bạn có muốn xóa ?')" class="text-decoration-none btn btn-danger" href="xuly.php?idDiachiXoa=<?= $row_dcgh['idDiachiGH'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&status=<?= $row_dcgh['status'] ?>&action=xoa_diachi">Xóa</a>
                                            <?php
                                            } else {
                                            ?>
                                                <a onclick="return confirm('Bạn có muốn xóa ?')" class="text-decoration-none btn btn-danger" href="xuly.php?idDiachiXoa=<?= $row_dcgh['idDiachiGH'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&status=<?= $row_dcgh['status'] ?>&action=xoa_diachi">Xóa</a>
                                                <a href="xuly.php?idAddress=<?= $row_dcgh['idDiachiGH'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=defaultAddress" class="btn btn-warning">
                                                    Chọn làm mặc định
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="col-10 fs-5 my-auto text-danger">Bạn chưa có địa chỉ giao hàng, vui lòng thêm địa chỉ</div>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary col-2 my-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Thêm địa chỉ
                    </button>
                </div>


            </div>

        </div>
    </div>
</div>
</div>


<!-- Modal thêm địa chỉ -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm địa chỉ giao hàng</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 form-group">
                        <form action="xuly.php" method="post" id="themDiachiForm">
                            <label for="tinh" class="form-label">Tỉnh</label>
                            <select name="tinh" id="tinh" class="form-control">
                                <option value="">Chọn Tỉnh</option>
                                <?php
                                $select_tinh = $conn->prepare("SELECT * FROM `tinh`");
                                $select_tinh->execute();
                                if ($select_tinh->rowCount() > 0) {
                                    while ($row_tinh = $select_tinh->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <option value="<?= $row_tinh['idTinh'] ?>"><?= $row_tinh['tenTinh'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                    </div>
                    <div class="col-3 form-group">
                        <label for="quan_huyen" class="form-label">Quận/Huyện</label>
                        <select id="quan_huyen" name="quan_huyen" class="form-control">
                            <option value="">Chọn một Quận/huyện</option>
                        </select>
                    </div>
                    <div class="col-3 form-group">
                        <label for="xa" class="form-label">Phường/Xã</label>
                        <select id="xa" name="xa" class="form-control">
                            <option value="">Chọn một Xã/phường</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Địa chỉ cụ thể:</label>
                        <textarea class="form-control" name="address" id="address" cols="40" rows="5" placeholder="Ví dụ: số nhà 112, tổ 3, ấp tân hòa b"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="submit" name="themdiachi" class="btn btn-primary">Thêm</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal thêm địa chỉ -->


<?php include "./component_u/footer_user.php"; ?>