<?php include "../component_ad/header_admin.php";
$page = 'Thêm Sách' ?>

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
            if (isset($_GET['action']) && $_GET['action'] == 'sua') {
                $idbook = $_GET['idbook'];
                $sql_select = $conn->prepare("SELECT * FROM `sach` WHERE idSach=?");
                $sql_select->execute([$idbook]);
                $row = $sql_select->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <form action="xuly.php" method="post" enctype="multipart/form-data" id="AddBookForm">
                <div class="form-group">
                    <label for="nameBook" class="form-label fw-bold">Tên Sách</label>
                    <input type="text" class="form-control" name="nameBook" id="nameBook" placeholder="Nhập Tên Sách:">
                </div>
                <div class="form-group">
                    <label for="motaBook" class="form-label fw-bold">Mô Tả</label>
                    <textarea type="text" rows="3" class="form-control mytextarea" name="motaBook" id="motaBook" placeholder="Mổ tả sách:"></textarea>
                </div>
                <div class="form-group">
                    <label for="imgBook" class="form-label fw-bold">Hình</label>
                    <input type="file" class="form-control" name="imgBook" id="imgBook">
                </div>
                <div class="form-group">
                    <label for="theloai" class="form-label fw-bold">Chọn Thể Loại</label>
                    <select class="form-select" aria-label="Default select example" id="theloai" name="theloai">
                        <option value=""> Chọn thể loại </option>
                        <?php
                        $sql_tl = $conn->prepare("SELECT * FROM `theloaisach`");
                        $sql_tl->execute();
                        while ($row_tl = $sql_tl->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?php echo $row_tl['idTheLoai'] ?>"> <?php echo $row_tl['tenTheLoai'] ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="numBook" class="form-label fw-bold">Số Lượng</label>
                    <input type="text" class="form-control" name="numBook" id="numBook" placeholder="Nhập Số Lượng Sách:">
                </div>
                <div class="mb-3">
                    <label for="priceBook" class="form-label fw-bold">Giá</label>
                    <input type="text" class="form-control" name="priceBook" id="priceBook" placeholder="Nhập Giá Sách:">
                </div>
                <div class="d-flex justify-content-center mt-3 mb-5">
                    <button type="submit" class="btn btn-primary" id="addBook" name="themsach">Thêm</button>
                    <a class="ms-3 btn btn-danger" href="../quanlySach/lietke.php">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../component_ad/footer_admin.php"; ?>