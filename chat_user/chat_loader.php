<?php
include '../config/connect.php';
$sender_id = $_GET['sender_id'];
$receiver_id = $_GET['receiver_id'];
$select_chat = $conn->prepare("SELECT DISTINCT msg_id,outgoing_msg_id,msg,incoming_msg_id FROM mess WHERE outgoing_msg_id ='$sender_id' AND incoming_msg_id='$receiver_id'
                                                        || outgoing_msg_id ='$receiver_id' AND incoming_msg_id='$sender_id'");
$select_chat->execute();
while ($row_chat = $select_chat->fetch(PDO::FETCH_ASSOC)) {
    if ($sender_id == $row_chat['outgoing_msg_id']) {
?>
        <div class="row ">
            <div class="col-3"></div>
            <div class="col-9">
                <p class="border bg-primary text-white border-secondary text-break py-2 px-2 float-end" style="border-radius: 5px;">
                    <?= $row_chat['msg'] ?>
                </p>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="row">
            <div class="col-9">
                <p class="border bg-light border-secondary text-break py-2 px-2 float-start" style="border-radius: 5px;">
                    <?= $row_chat['msg'] ?>
                </p>
            </div>
            <div class="col-3"></div>
        </div>
    <?php
    }
    ?>
<?php
}
?>