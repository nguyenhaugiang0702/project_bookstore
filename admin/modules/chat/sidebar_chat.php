<?php
require '../../../config/connect.php';
$select_user = $conn->prepare("SELECT * FROM users u, avatar a WHERE u.idUser=a.idUser");
$select_user->execute();
if ($select_user->rowCount() > 0) {
    while ($row = $select_user->fetch(PDO::FETCH_ASSOC)) {
?>
        <div class="row">
            <a class="text-decoration-none" href="chat.php?receiver_id=<?= $row['idUser'] ?>&sender_id=1">
                <div class="mb-3 mx-auto row">
                    <div class="col-3">
                        <img src="/../project/uploads/<?= $row['tenHinh'] ?>" class="img-fluid rounded-circle" alt="">
                    </div>
                    <div class="col">
                        <div class="row text-dark"><?= $row['nameUser'] ?></div>
                        <div class="row text-dark"><?= $row['sdtUser'] ?></div>
                    </div>
                    <?php
                    $select_status_mess = $conn->prepare("SELECT * FROM mess WHERE outgoing_msg_id=? AND status_mess=0");
                    $select_status_mess->execute([$row['idUser']]);
                    if ($select_status_mess->rowCount() > 0) {
                    ?>

                        <div class="col-2">
                            <span class="translate-middle bg-danger border border-light rounded-circle" 
                            style="position: relative; padding: 0px 10px; top: 15px">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </a>
            <hr>

        </div>
<?php
    }
}
?>