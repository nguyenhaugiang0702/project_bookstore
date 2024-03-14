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
                        <div onload="return loadListMess()"></div>
                        <div id="chat_load_list"></div>
                        <div id="search_chat"></div>
                    </div>
                </div>
                <?php
                $receiver_id = $_GET['receiver_id'];
                $sender_id = $_GET['sender_id'];
                $select_user = $conn->prepare("SELECT * FROM users u, avatar a WHERE u.idUser=a.idUser AND a.idUser='$receiver_id'");
                $select_user->execute();
                if ($select_user->rowCount() > 0) {
                    $row = $select_user->fetch(PDO::FETCH_ASSOC);
                ?>
                    <div class="col-9 border border-3">
                        <div class="row bg-primary bg-gradient pb-2 mb-3">
                            <div class="col-1 mt-3 ms-2">
                                <img src="/../project/uploads/<?= $row['tenHinh'] ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="col-6 my-auto text-white">
                                <div class="row"><?= $row['nameUser'] ?></div>
                                <div class="row"><?= $row['sdtUser'] ?></div>
                            </div>
                        </div>
                        <div class="chat-box" style="height: 600px; width: 100%; overflow: auto;">
                            <div id="chat_load"></div>
                            <div onload="return mess()"></div>
                        </div>
                        <form method="post" class="row bg-light py-3 border border-3" id="typing-sending">
                            <input type="hidden" name="sender_id" id="sender_id" value="1">
                            <input type="hidden" name="receiver_id" id="receiver_id" value="<?= $row['idUser'] ?>">
                            <div class="col-11">
                                <input type="text" class="form-control pb-4" id="typing" name="message" placeholder="Nhập để chat">
                            </div>
                            <div class="col-1 my-auto">
                                <button type="submit" onclick="return chat_validation()" class="btn btn-primary" id="sending">
                                    <i class="fa fa-paper-plane px-2 py-2" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                        <div id="msg"></div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php include "../component_ad/footer_admin.php"; ?>