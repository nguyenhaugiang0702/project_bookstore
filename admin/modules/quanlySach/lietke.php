<?php include "../component_ad/header_admin.php";
$page = 'Sách'; ?>

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
                    <a href="/../project/admin/modules/quanlySach/them.php">
                        <button type="button" class="btn btn-primary">
                            Thêm Sách
                        </button>
                    </a>
                </div>
            </div>
            <?php
            if (isset($_SESSION['status_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                unset($_SESSION['status_success']);
            }
            ?>

            <table id="datatable" style="width:100%;" class="table display table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Tên Sách</th>
                        <th>Hình</th>
                        <th>Thể Loại</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conn->prepare("SELECT * FROM sach s, theloaisach t WHERE s.idTheLoai=t.idTheLoai ORDER BY `idSach` ASC ");
                    $sql->execute();
                    if ($sql->execute()) {
                        while ($row = $sql->Fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <tr>
                                <td> <?php echo $row['idSach'] ?> </td>
                                <td style="width: 190px;"> <?php echo $row['tenSach'] ?> </td>
                                <td style="width: 280px;">
                                    <img class="img-fluid" src="upload/<?php echo $row['imgSach'] ?>" alt="">
                                </td>

                                <td>
                                    <?php echo $row['tenTheLoai'] ?>
                                </td>

                                <td>
                                    <?php
                                    if ($row['soLuong'] == 0) {
                                        echo '
                                            <span class="text-danger fw-bold">' . $row['soLuong'] . '</span>
                                            <div class="text-danger fw-bold">Cảnh báo</div>
                                            ';
                                    } else {
                                        echo $row['soLuong'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <span class="price"><?php echo $row['price'] ?></span>
                                    <span>VNĐ</span>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <a class="text-decoration-none" href="sua.php?idbook=<?php echo $row['idSach'] ?>&action=sua"><button type="button" class="btn btn-primary">Sửa</button></a>
                                        </div>
                                        <div class="col-4">
                                            <form action="xuly.php" method="post">
                                                <input type="hidden" value="<?php echo $row['idSach'] ?>" name="idsach">
                                                <input type="hidden" value="<?php echo $row['imgSach'] ?>" name="delete_img">
                                                <button onclick="return confirm('Bạn có muốn xóa ?')" name="delete_book" type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
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