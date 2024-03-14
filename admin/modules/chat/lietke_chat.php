<?php
include "../component_ad/header_admin.php";
$page = 'Chat'
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['status_warning'] = "Vui lòng đăng nhập";
    header('location: /../project/admin/login_admin.php');
} else {
    require "../../../config/connect.php";
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
            <div class="row">
                <div class="col-3 border border-3">
                    <div class="form-group">
                        <label for="getName">Search</label>
                        <input type="text" id="getName" class="form-control">
                        <hr>
                    </div>
                    <div class="list" style="height: 680px;overflow: auto;">
                        <div id="search_chat"></div>
                        <div id="chat_load_list"></div>
                    </div>
                </div>

                <div class="col-9 border border-3">
                    <div class="row bg-primary bg-gradient mb-4">
                        <div class="col-1 py-3 ms-2 text-white">
                            BOOKSTORE
                        </div>
                    </div>
                    <div class="chat-box ">
                        <div class="h1 text-center">Bắt đầu chat</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "../component_ad/footer_admin.php"; ?>