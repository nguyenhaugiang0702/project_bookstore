<?php include "../component_ad/header_admin.php";
$page = 'Thể Loại'; ?>

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
                    <!-- Model thêm thể thoại -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTheLoai">
                        <i class="fa-solid fa-plus"></i> Thêm thể loại
                    </button>
                    <!-- Model thêm thể thoại -->
                </div>
            </div>

            <?php
            if (isset($_SESSION['status_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                unset($_SESSION['status_success']);
            } elseif (isset($_SESSION['status_warning'])) {
                echo '<div class="alert alert-warning">' . $_SESSION['status_warning'] . '</div>';
                unset($_SESSION['status_warning']);
            }
            ?>
            <table id="datatable" class="table">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Tên Thể Loại</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conn->prepare("SELECT * FROM `theloaiSach`");
                    $sql->execute();
                    if ($sql->rowCount() > 0) {
                        while ($row = $sql->Fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <tr>
                                <td><?php echo $row['idTheLoai'] ?> </td>
                                <td> <?php echo $row['tenTheLoai'] ?> </td>
                                <td class="row">
                                    <!-- Modal sửa thể loại -->
                                    <div class="col-1">
                                        <a data-bs-toggle="modal" data-bs-target="#modalsua<?= $row['idTheLoai'] ?>" class="text-decoration-none" href="sua.php?id_tl= <?php echo $row['idTheLoai'] ?> "><button type="button" class="btn btn-primary">Sửa</button></a>
                                    </div>
                                    <!-- Modal sửa thể loại -->
                                    <form action="xuly.php" method="post" class="col-1 ms-3">
                                        <input type="hidden" name="id_tl" value="<?= $row['idTheLoai'] ?>">
                                        <button onclick="return confirm('Bạn có muốn xóa ?')" class="btn btn-danger" type="submit" name="xoaTL">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Modal sửa thể loại -->
                            <div class="modal fade" id="modalsua<?= $row['idTheLoai'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">CẬP NHẬP THỂ LOẠI</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="xuly.php" method="post" id="updateTLForm">
                                                <input type="hidden" name="idtype" value="<?= $row['idTheLoai'] ?>">
                                                <div class="mb-3">
                                                    <label for="nametl" class="form-label">Tên thể loại</label>
                                                    <input type="text" class="form-control" name="nametl" id="nametl" value="<?= $row['tenTheLoai'] ?>">
                                                </div>
                                                <input type="submit" class="btn btn-primary" name="updatetheloai" value="Câp Nhập">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal sửa thể loại -->
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

            <!-- Modal thêm thể loại -->
            <div class="modal fade" id="addTheLoai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">THÊM THỂ LOẠI</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="xuly.php" method="post" id="AddTLForm">
                                <div class="mb-3">
                                    <label for="nameTheLoai" class="form-label">Tên thể loại</label>
                                    <input type="text" class="form-control" name="nameTheLoai" id="nameTheLoai" placeholder="Nhập Tên Thể Loại:">
                                </div>
                                <input type="submit" class="btn btn-primary" name="addtheloai" value="Thêm Thể Loại">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal thêm thể loại -->
        </div>
    </div>
</div>

<?php include "../component_ad/footer_admin.php"; ?>