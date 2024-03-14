<?php
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];
$message = htmlspecialchars($message);
include '../../../config/connect.php';
$insert = $conn->prepare("INSERT INTO mess(incoming_msg_id, outgoing_msg_id, msg, status_mess)
                                        VALUES('$receiver_id', '$sender_id', '$message', 1)");
$insert->execute();
$update = $conn->prepare("UPDATE mess SET status_mess=1 WHERE outgoing_msg_id='$receiver_id'");
$update->execute();