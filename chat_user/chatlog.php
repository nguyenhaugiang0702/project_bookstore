<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    echo '<script>alert("Vui lòng đăng nhập để bắt đầu cuộc trò chuyện")</script>';
} else {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];
    $message = htmlspecialchars($message);
    include '../config/connect.php';
    $insert = $conn->prepare("INSERT INTO mess(incoming_msg_id, outgoing_msg_id, msg, status_mess)
                                        VALUES('$receiver_id', '$sender_id', '$message', 0)");
    $insert->execute();
}
