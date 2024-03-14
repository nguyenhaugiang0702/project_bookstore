<?php include "../component_ad/header_admin.php";
$page = 'Đơn Hàng'; ?>

<?php
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['status_warning'] = "Vui lòng đăng nhập";
    header('location: /../project/admin/login_admin.php');
} else {
    require '../../../config/connect.php';
}
?>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <?php include '../component_ad/sidebar.php'; ?>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <?php include '../component_ad/main_side.php' ?>

        <div class="container-fluid px-4 py-4">
            <?php
            if (isset($_SESSION['status_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                unset($_SESSION['status_success']);
            }
            ?>
            <table id="orders" class="table">
                <thead class="table-primary">
                    <tr>
                        <th>IdOrder</th>
                        <th>Tên Người Dùng</th>
                        <th>Địa Chỉ Giao Hàng</th>
                        <th>Số Lượng</th>
                        <th>Tổng Giá</th>
                        <th>Thanh Toán</th>
                        <th>Thời Gian Đặt Hàng</th>
                        <th>Thời Gian Cập Nhập</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                        <th>Xem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conn->prepare("SELECT * FROM orders o, users u, diachigh d, tinh t, xa x, quan_huyen q
                                                WHERE d.idDiachiGH=o.idDiachiGH AND d.idUser=u.idUser AND d.idTinh=t.idTinh  
                                                                    AND d.idXa=x.idXa AND d.idQH=q.idQH ORDER BY o.idOrder DESC");
                    $sql->execute();
                    if ($sql->rowCount() > 0) {
                        while ($row = $sql->Fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <tr>
                                <td><?= $row['idOrder'] ?> </td>
                                <td>
                                    <?= $row['nameUser'] ?>
                                    <br>
                                    <?php echo '(' . $row['sdtUser'] . ')' ?>
                                </td>
                                <td class="text-break"><?php echo $row['diachi'] . ', ';
                                                        echo $row['tenXa'] . ', ';
                                                        echo $row['tenQH'], ', ';
                                                        echo $row['tenTinh'] ?></td>
                                <td><?= $row['tongSL'] ?></td>
                                <td>
                                    <span class="price"><?= $row['totalPrice'] ?></span>
                                    <span><?= $row['DVT'] ?></span>
                                </td>
                                <td> <?= $row['method'] ?> </td>
                                <td><?= $row['timeOrder'] ?></td>
                                <td><?= $row['timeOrderUpdate'] ?></td>
                                <td>
                                    <?php
                                    if ($row['status_order'] == 1) {
                                        echo '<div>Đang chờ xác nhận...</div>';
                                    } else if ($row['status_order'] == 2) {
                                        echo '<div>Đã xác nhận</div>';
                                    } else if ($row['status_order'] == 3) {
                                        echo '<div>Đang vận chuyển</div>';
                                    } else if ($row['status_order'] == 4) {
                                        echo '<div>Đã giao hàng</div>';
                                    } else if ($row['status_order'] == 5) {
                                    ?>
                                        <li class="dropdown" style="list-style: none;">
                                            <a class="dropdown-toggle text-danger fw-bold" role="button" data-bs-toggle="dropdown">Yêu cầu hủy</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="text-decoration-none" href="xuly.php?idhuydon=<?= $row['idOrder'] ?>">
                                                        Xác nhận
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a class="text-decoration-none" href="xuly.php?idhuyyeucau=<?= $row['idOrder'] ?>">
                                                        Hủy
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php
                                    } else if ($row['status_order'] == 6) {
                                        echo '<div>Đã hủy đơn</div>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    ?>
                                    <li class="dropdown" style="list-style: none;">
                                        <a class="dropdown-toggle text-dark fw-bold" role="button" data-bs-toggle="dropdown">Trạng thái</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <?php
                                                if ($row['status_order'] == 1) {
                                                ?>
                                                    <a class="text-decoration-none" href="xuly.php?idxn=<?= $row['idOrder'] ?>">
                                                        Xác nhận
                                                    </a>
                                                <?php
                                                } else if ($row['status_order'] == 2) {
                                                ?>
                                                    <a class="text-decoration-none" href="xuly.php?idvc=<?= $row['idOrder'] ?>">
                                                        Đang vận chuyển
                                                    </a>
                                                <?php
                                                } else if ($row['status_order'] == 3) {
                                                ?>
                                                    <a class="text-decoration-none" href="xuly.php?iddgh=<?= $row['idOrder'] ?>">
                                                        Đã giao hàng
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </li>
                                    <form action="xuly.php" method="post">
                                        <input type="hidden" name="idorder" value="<?php echo $row['idOrder'] ?>">
                                        <button class="btn btn-danger" onclick="return confirm('Bạn có muốn xóa ?')" type="submit" name="xoaOrder">Xóa</button>
                                    </form>
                                    <?php
                                    ?>
                                </td>
                                <td>
                                    <!-- Xem don hang -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#xemchitiet<?= $row['idOrder'] ?>">
                                        Xem
                                    </button>
                                    <div class="modal fade" id="xemchitiet<?= $row['idOrder'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Chi Tiết Đơn hàng</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">Thông tin khách hàng</label>
                                                        <input type="text" readonly class="form-control" value="<?php echo $row['nameUser'] . '  -  ';
                                                                                                                echo $row['sdtUser'] ?>">
                                                    </div>
                                                    <?php
                                                    $select_sach_chitiet = $conn->prepare("SELECT * FROM sach s, chitietorder c WHERE c.idSach=s.idSach AND c.idOrder=?");
                                                    $select_sach_chitiet->execute([$row['idOrder']]);
                                                    if ($select_sach_chitiet->rowCount() > 0) {
                                                        while ($row_chitiet = $select_sach_chitiet->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                            <div class="row my-3">
                                                                <div class="col-3">
                                                                    <img class="img-fluid" src="../../modules/quanlySach/upload/<?= $row_chitiet['imgSach'] ?>" alt="">
                                                                </div>
                                                                <div class="col-9">
                                                                    <div class="col-12 fw-bold"><?= $row_chitiet['tenSach'] ?></div>
                                                                    <div class="col-12 ">
                                                                        <span class="fw-bold">Đơn Giá:</span>
                                                                        <span class="price text-danger fw-bold"><?= $row_chitiet['price'] ?></span>
                                                                        <span class="text-danger fw-bold">VNĐ</span>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="fw-bold">Số Lượng:</span>
                                                                        <input type="text" readonly class="col-2 text-center" value="<?= $row_chitiet['slmua'] ?>"> =
                                                                        <span class="price text-danger fw-bold"><?php echo $row_chitiet['price'] * $row_chitiet['slmua'] ?></span>
                                                                        <span class="text-danger fw-bold">VNĐ</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Xem don hang -->
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<?php include "../component_ad/footer_admin.php"; ?>