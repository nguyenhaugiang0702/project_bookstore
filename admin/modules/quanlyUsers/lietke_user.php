<?php include "../component_ad/header_admin.php";
$page = 'Người Dùng'; ?>

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

        <div class="container-fluid px-4 py-5">
            <?php
            if (isset($_SESSION['status_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                unset($_SESSION['status_success']);
            }
            ?>
            <table id="datatable" class="table">
                <thead class="table-primary">
                    <tr>
                        <th>idAccount</th>
                        <th>Tên Người Dùng</th>
                        <th>Email</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conn->prepare("SELECT * FROM users u, account a WHERE u.idUser=a.idUser");
                    $sql->execute();
                    if ($sql->rowCount() > 0) {
                        while ($row = $sql->Fetch(PDO::FETCH_ASSOC)) {
                            $get_idorder = $conn->prepare("SELECT * FROM orders o, users u WHERE u.idUser=o.idUser");
                            $get_idorder->execute();
                            $row_getIdorder = $get_idorder->fetch(PDO::FETCH_ASSOC);
                            $get_iddcgh = $conn->prepare("SELECT * FROM diachigh d, users u WHERE u.idUser=d.idUser");
                            $get_iddcgh->execute();
                            $row_getIddcgh = $get_iddcgh->fetch(PDO::FETCH_ASSOC);
                    ?>
                            <tr>
                                <td><?php echo $row['idAccount'] ?></td>
                                <td><?php echo $row['nameUser'] ?></td>
                                <td><?php echo $row['emailUser'] ?></td>
                                <td>
                                    <?php
                                    if ($row['status_account'] == 1) {
                                        echo '<p class="text-success fw-bold">Active</p>';
                                    } else {
                                        echo '<p class="text-danger fw-bold" >Inactive</p>';
                                    }
                                    ?>
                                </td>
                                <td class="row">
                                    <?php
                                    if ($row['status_account'] == 1) {
                                    ?><div class="col-4">
                                            <a class="text-decoration-none" href="xuly.php?id_inac=<?php echo $row['idAccount'] ?>">
                                                <button type="button" class="btn btn-warning">Inactive</button>
                                            </a>
                                        </div>
                                    <?php
                                    } else {
                                    ?><div class="col-4">
                                            <a class="text-decoration-none" href="xuly.php?id_ac=<?php echo $row['idAccount'] ?>">
                                                <button type="button" class="btn btn-success">Active</button>
                                            </a>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <form action="xuly.php" method="post" class="col-1">
                                        <input type="hidden" name="idaccount" value="<?= $row['idAccount'] ?>">
                                        <input type="hidden" name="iduser" value="<?= $row['idUser'] ?>">
                                        <button onclick="return confirm('Bạn có muốn xóa ?')" name="XoaUser" type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
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