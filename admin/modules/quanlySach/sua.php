<?php include "../component_ad/header_admin.php";
$page = 'Sửa Sách'; ?>

<?php
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['status_warning'] = "Vui lòng đăng nhập";
    header('location: /../project/admin/login_admin.php');
} else {
    require '../../../config/connect.php';
}

if (isset($_POST['update'])) {
    $namebook = $_POST['nameBook'];
    $motabook = $_POST['motabook'];
    $typebook = $_POST['theloai'];
    $numbook = $_POST['numBook'];
    $pricebook = $_POST['priceBook'];
    $pricebook = filter_var($pricebook, FILTER_SANITIZE_NUMBER_INT);
    $id = $_POST['idb'];

    $new_img = $_FILES['imgBook_update']['name'];
    $old_img = $_POST['img_book_old'];

    if ($_FILES['imgBook_update']['name'] != '') {
        $newfilename = uniqid() . '-' . $new_img;
        $sql_update_1 = $conn->prepare("UPDATE `sach` SET tenSach='$namebook', motaSach='$motabook', imgSach='$newfilename', idTheLoai='$typebook', 
                    soLuong='$numbook', price='$pricebook' WHERE idSach='$id'");
        if ($sql_update_1->execute()) {
            move_uploaded_file($_FILES['imgBook_update']['tmp_name'], "upload/" . $newfilename);
            unlink("upload/" . $old_img);
            $_SESSION['status_success'] = "Cập nhập thành công";
            header('location: /../project/admin/modules/quanlySach/lietke.php');
        }
    } else {
        $sql_update = $conn->prepare("UPDATE `sach` SET tenSach='$namebook', motaSach='$motabook', imgSach='$old_img', idTheLoai='$typebook', 
            soLuong='$numbook', price='$pricebook' WHERE idSach='$id'");
        if ($sql_update->execute()) {
            $_SESSION['status_success'] = "Cập nhập thành công";
            header('location: /../project/admin/modules/quanlySach/lietke.php');
        }
    }
}
?>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <?php include '../component_ad/sidebar.php'; ?>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <?php include '../component_ad/main_side.php' ?>

        <div class="container-fluid">
            <?php
            if (isset($_GET['action']) && $_GET['action'] == 'sua') {
                $idbook = $_GET['idbook'];
                $sql_select = $conn->prepare("SELECT * FROM `sach` WHERE idSach=?");
                $sql_select->execute([$idbook]);
                $row = $sql_select->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <div class="my-5 mx-5">
                <form method="post" enctype="multipart/form-data" id="UpdateBookForm">
                    <input type="hidden" name="idb" value="<?= $idbook; ?>">

                    <div class="row">
                        <div class="col-4 ms-3">
                            <div class="row">
                                <img class="img-fluid" style="border: 2px solid #000;" src="upload/<?= $row['imgSach'] ?>" alt="">
                            </div>
                            <div class="row my-3">
                                <input type="file" class="form-control border border-dark rounded" name="imgBook_update" id="completTypeBook">
                                <input type="hidden" name="img_book_old" value="<?= $row['imgSach']  ?>">
                            </div>
                        </div>
                        <div class="col-6 ms-3">
                            <div class="form-group">
                                <label for="nameBook" class="form-label fw-bold">Tên Sách:</label>
                                <input type="text" class="form-control border border-dark rounded" value="<?= $row['tenSach'] ?>" name="nameBook" id="nameBook">
                            </div>
                            <div class="form-group">
                                <label for="theloai" class="form-label fw-bold">Chọn Thể Loại:</label>
                                <select class="form-select border border-dark rounded" aria-label="Default select example" name="theloai" id="theloai">
                                    <?php
                                    $sql_tl = $conn->prepare("SELECT * FROM `theloaisach`");
                                    $sql_tl->execute();
                                    while ($row_tl = $sql_tl->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option value="<?= $row_tl['idTheLoai'] ?>" <?php
                                                                                    if ($row_tl['idTheLoai'] == $row['idTheLoai']) {
                                                                                        echo "selected";
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                    ?>> <?= $row_tl['tenTheLoai'] ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="numBook" class="form-label fw-bold">Số Lượng:</label>
                                <input type="text" class="form-control border border-dark rounded" value="<?= $row['soLuong'] ?>" name="numBook" id="numBook">
                            </div>
                            <div class="form-group">
                                <label for="priceBook" class="form-label fw-bold">Giá:</label>
                                <input type="text" class="form-control border border-dark rounded" value="<?= $row['price'] ?>" name="priceBook" id="priceBook">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mx-2">
                        <label for="completMotaBook" class="form-label fw-bold">Mô Tả:</label>
                        <textarea class="mytextarea form-control" name="motabook" id="completMotaBook" rows="3" value="">
                            <?= $row['motaSach'] ?>
                    </textarea>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-5">
                        <button type="submit" class="btn btn-primary" name="update" id="update">Cập Nhập</button>
                        <a class="ms-3 btn btn-danger" href="../quanlySach/lietke.php">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../component_ad/footer_admin.php"; ?>