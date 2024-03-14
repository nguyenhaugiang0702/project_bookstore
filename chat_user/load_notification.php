<?php
session_start();
require '../config/connect.php';
if (isset($_SESSION['customer_id'])) {
    $select_status_mess = $conn->prepare("SELECT * FROM mess WHERE incoming_msg_id='$_SESSION[customer_id]' AND status_mess=1");
    $select_status_mess->execute();
    if ($select_status_mess->rowCount() > 0) {
        // $check = $conn->prepare("SELECT * FROM mess  WHERE incoming_msg_id=1 AND outgoing_msg_id='$_SESSION[customer_id]' AND status_mess=0 ");
        // $check->execute();
        // if($check->rowCount()<=0){
        echo '
            <span class="position-absolute top-20 start-100 translate-middle bg-danger border border-light rounded-circle" style="padding: 10px;">
            </span>';
    }
}
