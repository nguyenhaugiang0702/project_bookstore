<?php
require './config/connect.php';
session_start();
if (isset($_POST['sdt'])) {
    $sdt = $_POST['sdt'];
    $checkSdt = $conn->prepare("SELECT * FROM `users` WHERE sdtUser='$sdt'");
    $checkSdt->execute();
    if ($checkSdt->rowCount() > 0) {
        echo "false";
    } else {
        echo "true";
    }
} else if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $checkEmail = $conn->prepare("SELECT * FROM `users` WHERE emailUser='$email'");
    $checkEmail->execute();
    if ($checkEmail->rowCount() > 0) {
        echo "false";
    } else {
        echo "true";
    }
} else if (isset($_POST['fullname'])) {
    $fullname = $_POST['fullname'];
    $fullname = trim($fullname);
    $checkName = $conn->prepare("SELECT * FROM `users` WHERE nameUser = '$fullname'");
    $checkName->execute();
    if ($checkName->rowCount() > 0) {
        echo "false";
    } else {
        echo "true";
    }
} else if (isset($_GET['tinh'])) {
    $tinh = $_GET['tinh'];

    $select_quanhuyen = $conn->prepare("SELECT * FROM `quan_huyen` WHERE `idTinh` = '$tinh'");
    $select_quanhuyen->execute();

    $data[0] = [
        'id' => '',
        'name' => 'Chọn một Quận/huyện'
    ];
    while ($row = $select_quanhuyen->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'id' => $row['idQH'],
            'name' => $row['tenQH']
        ];
    }
    echo json_encode($data);
} else if (isset($_GET['quan_huyen'])) {
    $quan_huyen = $_GET['quan_huyen'];
    $select_xa = $conn->prepare("SELECT * FROM `xa` WHERE `idQH` = '$quan_huyen' ");
    $select_xa->execute();

    $data[0] = [
        'id' => '',
        'name' => 'Chọn một Xã/phường'
    ];

    while ($row = $select_xa->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'id' => $row['idXa'],
            'name' => $row['tenXa']
        ];
    }
    echo json_encode($data);
}
