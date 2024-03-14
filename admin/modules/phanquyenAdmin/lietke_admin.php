<?php include "../component_ad/header_admin.php";
$page = 'Phân Quyền' ?>

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
            <div class="row">
                <div class="my-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdmin">
                        Thêm Admin
                    </button>
                </div>
            </div>
            <?php
            if (isset($_SESSION['status_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                unset($_SESSION['status_success']);
            }else if (isset($_SESSION['status_warning'])) {
                echo '<div class="alert alert-warning">' . $_SESSION['status_warning'] . '</div>';
                unset($_SESSION['status_warning']);
            }
            ?>
            <table id="datatable" class="table">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Tên Admin</th>
                        <th>Mật Khẩu</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conn->prepare("SELECT * FROM `admin`");
                    $sql->execute();
                    if ($sql->rowCount() > 0) {
                        while ($row = $sql->Fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <tr>
                                <td><?= $row['idAdmin'] ?> </td>
                                <td><?= $row['nameAdmin'] ?> </td>
                                <td><?= $row['passAdmin'] ?> </td>
                                <td>
                                    <a data-bs-toggle="modal" data-bs-target="#updateAdmin<?=$row['idAdmin']?>" class="btn btn-primary">Sửa</a>
                                    <a onclick="return confirm('Bạn có muốn xóa ?')" class="text-decoration-none" href="xuly.php?idadmin=<?php echo $row['idAdmin'] ?>"><button type="button" class="btn btn-danger">Xóa</button></a>
                                </td>
                            </tr>
                            <!-- Modal sua-->
                            <div class="modal fade" id="updateAdmin<?=$row['idAdmin']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">CẬP NHẬP ADMIN</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="xuly.php" method="post">
                                                <input type="hidden" value="<?=$row['idAdmin']?> " name="idadmin">
                                                <div class="my-2">
                                                    <label for="nameadmin_up" class="form-label fw-bold">Tên Admin:</label>
                                                    <input type="text" value="<?=$row['nameAdmin']?>" class="form-control" name="nameadmin_up" id="nameadmin_up" >
                                                </div>
                                                <div class="my-2">
                                                    <label for="pass_up" class="form-label fw-bold">Mật Khẩu:</label>
                                                    <input type="text" value="<?=$row['passAdmin']?>" class="form-control" name="pass_up" id="pass_up" >
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Thoát</button>
                                            <button type="submit" name="UpdateAdmin" class="btn btn-primary">Lưu</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php

                        }
                    }
                    ?>
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">THÊM ADMIN</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addAdminForm" action="xuly.php" method="post">
                                <div class="my-2">
                                    <label for="nameadmin" class="form-label fw-bold">Tên Admin:</label>
                                    <input type="text" class="form-control" name="nameadmin" id="nameadmin" placeholder="Nhập tên admin:">
                                </div>
                                <div class="my-2">
                                    <label for="pass" class="form-label fw-bold">Mật Khẩu:</label>
                                    <input type="text" class="form-control" name="pass" id="pass" placeholder="Nhập mật khẩu:">
                                </div>
                                <div class="my-2">
                                    <label for="cfpass" class="form-label fw-bold">Nhập lại mật khẩu:</label>
                                    <input type="text" class="form-control" name="cfpass" id="cfpass" placeholder="Nhập lại mật khẩu:">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Thoát</button>
                            <button type="submit" name="addAdmin" class="btn btn-primary">Thêm Admin</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../component_ad/footer_admin.php"; ?>