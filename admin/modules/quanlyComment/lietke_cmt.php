<?php include "../component_ad/header_admin.php";
$page = 'Bình Luận'; ?>

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
            <table id="datatable" class="table">
                <thead class="table-primary">
                    <tr>
                        <th>IDCmt</th>
                        <th>Tên Sách</th>
                        <th>Tên Người Dùng</th>
                        <th>Nội dung</th>
                        <th>Rate</th>
                        <th>Thời gian tạo</th>
                        <th>Thời gian cập nhập</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conn->prepare("SELECT * FROM comment c, users u, sach s WHERE c.idUser=u.idUser AND c.idSach=s.idSach");
                    $sql->execute();
                    if ($sql->rowCount() > 0) {
                        while ($row = $sql->Fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <tr>
                                <td><?= $row['idCmt'] ?> </td>
                                <td class="text-break"><?= $row['tenSach'] ?> </td>
                                <td><?= $row['nameUser'] ?> </td>
                                <td class="text-break"><?= $row['content'] ?> </td>
                                <td><?= $row['rate'] ?> </td>
                                <td> <?= $row['timeCreateCmt'] ?> </td>
                                <td> <?= $row['timeUpdateCmt'] ?></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#suaCMT<?= $row['idCmt'] ?>">
                                        Sửa
                                    </button>
                                    <a onclick="return confirm('Bạn có muốn xóa ?')" class="text-decoration-none" href="xuly.php?idcmt=<?php echo $row['idCmt'] ?>"><button type="button" class="btn btn-danger">Xóa</button></a>
                                </td>
                            </tr>
                            <?php
                            ?>
                            <!-- Modal -->
                            <div class="modal fade" id="suaCMT<?= $row['idCmt'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhập Bình Luận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="xuly.php" method="post">
                                                <input type="hidden" value="<?= $row['idCmt'] ?>" name="id">
                                                <div class="form-group">
                                                    <label for="cmt" class="fw-bold mb-2">Nội dung comment:</label>
                                                    <textarea class="mytextarea" name="contentCmt" id="cmt" cols="30" rows="10">
                                                        <?= $row['content'] ?>
                                                    </textarea>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                            <button type="submit" name="update_cmt" class="btn btn-primary">Cập Nhập</button>
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
        </div>
    </div>
</div>



<?php include "../component_ad/footer_admin.php"; ?>