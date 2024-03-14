<?php
require '../../../config/connect.php';
$getName = $_POST['getName'];
$getName = trim($getName);
$search_chat = $conn->prepare("SELECT * FROM users u, avatar a WHERE a.idUser=u.idUser AND u.nameUser LIKE '%$getName%'");
$search_chat->execute();
$data='';
if ($search_chat->rowCount() > 0) {
    while ($row = $search_chat->fetch(PDO::FETCH_ASSOC)) {
$data.= '
        <div class="row">
            <a class="text-decoration-none" href="chat.php?receiver_id= '.$row['idUser'].' &sender_id=1">
                <div class="mb-3 mx-auto row">
                    <div class="col-3">
                        <img src="/../project/uploads/'.$row['tenHinh'].'" class="img-fluid rounded-circle" alt="">
                    </div>
                    <div class="col">
                        <div class="row text-dark"> '.$row['nameUser'].' </div>
                        <div class="row text-dark"> '.$row['sdtUser'].' </div>
                    </div>'
                    ?>
                        <?php
                        $select_status_mess = $conn->prepare("SELECT * FROM mess WHERE outgoing_msg_id=? AND status_mess=0");
                        $select_status_mess->execute([$row['idUser']]);
                        if ($select_status_mess->rowCount() > 0) {
                        $data.='
                        
                            <div class="col-2">
                                <span class="translate-middle bg-danger border border-light rounded-circle" style="position: relative; padding: 0px 10px; top: 15px">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </div>';
                        
                        }
                        ?>
                    <?php
                    $data.='
                </div>
            </a>
            <hr>
        </div>';
    }
}
echo $data;

?>