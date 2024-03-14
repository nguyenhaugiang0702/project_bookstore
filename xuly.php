<?php
require './config/connect.php';
session_start();
if (isset($_POST['updateUser'])) { // cập nhập thông tin người dùng

    $fullname = $_POST['fullname'];
    $fullname = htmlspecialchars($fullname);
    $sdt = $_POST['sdt'];
    $sdt = htmlspecialchars($sdt);
    $email = $_POST['email'];
    $email = htmlspecialchars($email);
    $dem = 0;

    if ($_SESSION['customer_name'] != $fullname) {
        $checkNameExist = $conn->prepare("SELECT * FROM users WHERE nameUser='$fullname'");
        $checkNameExist->execute();
        if ($checkNameExist->rowCount()) {
            $_SESSION['status_warning'] = 'Tên này đã tồn tại';
            $dem++;
        }
    } else if ($_SESSION['customer_email'] != $email) {
        $checkEmailExist = $conn->prepare("SELECT * FROM users WHERE emailUser='$email'");
        $checkEmailExist->execute();
        if ($checkEmailExist->rowCount()) {
            $_SESSION['status_warning'] = 'Email này đã tồn tại';
            $dem++;
        }
    } else if ($_SESSION['customer_sdt'] != $sdt) {
        $checkSdtExist = $conn->prepare("SELECT * FROM users WHERE sdtUser='$sdt'");
        $checkSdtExist->execute();
        if ($checkSdtExist->rowCount()) {
            $_SESSION['status_warning'] = 'Số điện thoại này đã tồn tại';
            $dem++;
        }
    }


    if ($dem == 0) {
        $update_user = $conn->prepare("UPDATE users SET nameUser='$fullname', 
        emailUser='$email', sdtUser='$sdt' WHERE idUser = '$_SESSION[customer_id]'");

        if ($update_user->execute()) {
            $infor_user = $conn->prepare("SELECT * FROM users WHERE idUser='$_SESSION[customer_id]'");
            $infor_user->execute();
            $row_user = $infor_user->fetch(PDO::FETCH_ASSOC);
            unset($_SESSION['customer_name']);
            $_SESSION['customer_name'] = $row_user['nameUser'];
            $_SESSION['status_success'] = "Cập nhập thành công";
            header('location: thaydoithongtin.php');
        }
    } else {
        header('location: thaydoithongtin.php');
    }
    exit();
}
if (isset($_POST['updateAvatar']) && isset($_FILES['avatar'])) { // Cập nhập avatar
    $new_img = $_FILES['avatar']['name'];
    $tmp_img = $_FILES['avatar']['tmp_name'];
    $avatar_old = $_POST['avatar_old'];
    if ($new_img != '') {
        $newfilename = uniqid() . '-' . $new_img;
        $update_user = $conn->prepare("UPDATE avatar SET tenHinh='$newfilename' WHERE idUser='$_SESSION[customer_id]'");
        if ($update_user->execute()) {
            move_uploaded_file($tmp_img, "uploads/" . $newfilename);
            unlink("uploads/" . $avatar_old);
            $_SESSION['status_success'] = 'Cập nhập thành công';
            header('location: my_account.php');
        }
    }
    exit();
}
if (isset($_POST['gui_danhgia'])) { // comment
    $cmt = $_POST['cmt'];
    $cmt = htmlspecialchars($cmt);
    $rating = $_POST['rating'];
    $id_sanpham = $_POST['idsp'];

    if (!isset($_SESSION['customer_id']) && empty($_SESSION['customer_id'])) {
        $_SESSION['status_danger'] = "Vui lòng đăng nhập để bình luận";
        header('location: ../project/login_users.php');
    } else {
        $iduser = $_SESSION['customer_id'];
        if (empty($cmt)) {
            echo '<script>alert("Vui lòng nhập để đánh giá");</script>';
        } else {
            $sql_cmt = $conn->prepare("INSERT INTO `comment` (idUser, idSach, content, rate, timeCreateCmt, timeUpdateCmt) VALUES('$iduser', '$id_sanpham', '$cmt', '$rating', NOW(), NOW())");
            $sql_cmt->execute();
            header('location: single.php?idsanpham=' . $id_sanpham . '');
        }
    }
    exit();
}
if (isset($_GET['token'])) { // check token đăng ký tài khoản
    $token = $_GET['token'];
    $sql_verify = $conn->prepare("SELECT * FROM `account` WHERE verify = '$token' LIMIT 1");
    $sql_verify->execute();
    if ($sql_verify->rowCount() > 0) {
        $row = $sql_verify->fetch(PDO::FETCH_ASSOC);
        if ($row['status_account'] == 0) {
            $click_token = $row['verify'];
            $sql_updateToken = $conn->prepare("UPDATE `account` SET status_account = 1 WHERE verify='$click_token'");
            if ($sql_updateToken->execute()) {
                $_SESSION['status_success'] = 'Tài khoản của bạn đã được xác thực';
                header('location: ../project/login_users.php');
            } else {
                $_SESSION['status_danger'] = 'Tài khoản của bạn chưa được xác thực';
                header('location: ../project/login_users.php');
            }
        } else {
            $_SESSION['status_warning'] = 'Email này đã được xác thực';
            header('location: ../project/login_users.php');
        }
    } else {
        $_SESSION['status_danger'] = "Token này không tồn tại";
        header('location: ../project/login_users.php');
    }
    exit();
}
if (isset($_POST['dangnhap'])) { // đăng nhập  users
    $email = $_POST['email'];
    $email = htmlspecialchars($email);
    $password = $_POST['password'];
    $password = htmlspecialchars($password);
    $select_user = $conn->prepare("SELECT * FROM `users` INNER JOIN `account` ON users.idUser=account.idUser WHERE emailUser=?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
    if ($select_user->rowCount() > 0) {
        if (password_verify($password, $row['password'])) {
            if ($row['status_account'] == 1) {
                $_SESSION['customer_email'] = $email;
                $_SESSION['customer_name'] = $row['nameUser'];
                $_SESSION['customer_id'] = $row['idUser'];
                $_SESSION['customer_sdt'] = $row['sdtUser'];
                if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                    header('location: home.php');
                } else {
                    header('location: cart.php');
                }
            } else {
                $_SESSION['status_warning'] = 'Tài khoản của bạn đã bị vô hiệu hóa, hoặc chưa được xác thực';
                header('location: login_users.php');
            }
        } else {
            $_SESSION['status_danger'] = 'Mật khẩu sai !';
            header('location: login_users.php');
        }
    } else {
        $_SESSION['status_danger'] = 'Vui lòng kiểm tra lại email';
        header('location: login_users.php');
    }
    exit();
}
if (isset($_POST['doimatkhau'])) { // đổi mật khẩu
    $email = $_POST['email'];
    $email = htmlspecialchars($email);
    $oldpass = $_POST['oldpass'];
    $oldpass = htmlspecialchars($oldpass);
    $newpass = $_POST['newpass'];
    $newpass = htmlspecialchars($newpass);
    $newpass = password_hash($newpass, PASSWORD_DEFAULT);
    $cfnewpass = $_POST['cfnewpass'];

    $sql1 = $conn->prepare("SELECT * FROM `users` INNER JOIN `account` ON users.idUser=account.idUser WHERE emailUser=? LIMIT 1");
    $sql1->execute([$email]);
    $row1 = $sql1->fetch(PDO::FETCH_ASSOC);
    if (password_verify($oldpass, $row1['password'])) {
        if (password_verify($newpass, $row1['password'])) {
            $_SESSION['status_warning'] = "Mật khẩu mới đã được sử dụng gần đây";
            header('location: doimatkhau.php');
        } else {
            $sql_update = $conn->prepare("UPDATE `users` INNER JOIN `account` ON users.idUser=account.idUser SET password=?, timeUpdate= current_timestamp WHERE emailUser=?");
            $sql_update->execute([$newpass, $email]);
            $_SESSION['status_success'] = "Đổi mật khẩu thành công, vui lòng đăng nhập lại để tiếp tục";
            unset($_SESSION['customer_id']);
            unset($_SESSION['customer_name']);
            unset($_SESSION['customer_sdt']);
            unset($_SESSION['customer_email']);
            header('location: login_users.php');
        }
    } else {
        $_SESSION['status_danger'] = "Mật khẩu cũ sai";
        header('location: doimatkhau.php');
    }
    exit();
}
if (isset($_POST['update_sl_cart'])) { // cập nhập số lượng giỏ hàng
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            $_SESSION['cart'][$key] = array('slmua' => $_POST['slmua_cart' . $key]);
        }
    }
    header('location: cart.php');
    exit();
}
if (isset($_POST['gui'])) { // quên mật khẩu
    require_once './vendor/PHPMailer/sendmail.php';
    $email = $_POST['email'];
    $email = htmlspecialchars($email);

    $sql = $conn->prepare("SELECT * FROM  `users` INNER JOIN `account` ON users.idUser=account.idUser WHERE emailUser=?");
    $sql->execute([$email]);
    $row =  $sql->fetch(PDO::FETCH_ASSOC);
    if ($sql->rowCount() > 0) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomPass = '';
        for ($i = 0; $i < 8; $i++) {
            $randomPass .= $characters[rand(0, strlen($characters) - 1)];
        }

        $title = "Cập nhập mật khẩu";
        $content = '<h3>Xin chào, ' . $row['nameUser'] . '</h3>';
        $content .= '<p>Chúng tôi đã nhận được yêu cầu cấp lại mật khẩu của bạn.</p>';
        $content .= '<p>Đây là mật khẩu mới của bạn.</p>';
        $content .= '<p>Vui lòng không chia sẻ cho bất kỳ ai.</p>';
        $content .= "<p>Mật khẩu mới của bạn là : <b>$randomPass</b></p>";
        $sendemail = send($title, $content, $row['nameUser'], $row['emailUser'], '');

        if ($sendemail) {
            $sql_update = $conn->prepare("UPDATE `account` SET password=?, timeUpdate=current_timestamp WHERE idAccount=?");
            $sql_update->execute([password_hash($randomPass, PASSWORD_DEFAULT), $row['idAccount']]);
            $_SESSION['status_success'] = "Đề nghị đã được gửi đi, vui lòng kiểm tra Email";
            header('location: login_users.php');
        } else {
            $_SESSION['status_danger'] = "Đề nghị chưa được gửi đi";
            header('location: forgot.php');
        }
    } else {
        $_SESSION['status_danger'] = "Kiểm tra lại địa chỉ Email";
        header('location: forgot.php');
    }
    exit();
}
if (isset($_POST['dangky']) && isset($_FILES['avatar'])) { // đăng ký tài khoản
    require './vendor/PHPMailer/sendmail.php';
    $fullname = $_POST['fullname'];
    $fullname = htmlspecialchars(trim($fullname));
    $email = $_POST['email'];
    $email = htmlspecialchars($email);
    $sdt = $_POST['sdt'];
    $sdt = htmlspecialchars($sdt);
    $password = $_POST['password'];
    $cf_password = $_POST['cf_password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $verify = md5(rand());

    // Thêm người dùng vào bảng users
    $insert_user = $conn->prepare("INSERT INTO `users` (nameUser, sdtUser, emailUser) VALUES ('$fullname','$sdt','$email')");
    $insert_user->execute();
    $id = $conn->lastInsertId();
    // Thêm pass và username vào bảng account
    $insert_account = $conn->prepare("INSERT INTO `account` (idUser, password, verify, status_account, timeCreate) VALUES ('$id','$password_hash', '$verify', 0, NOW()) ");
    $insert_account->execute();
    // Thêm avatar
    $img_name = $_FILES['avatar']['name'];
    $tmp_name = $_FILES['avatar']['tmp_name'];
    $newfilename = uniqid() . '-' . $img_name;
    $insert_avatar = $conn->prepare("INSERT INTO `avatar`(idUser, tenHinh) VALUES('$id', '$newfilename')");
    if ($insert_avatar->execute()) {
        move_uploaded_file($tmp_name, 'uploads/' . $newfilename);
    }

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE emailUser='$email'");
    $select_user->execute();
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
    if ($select_user->rowCount() > 0) {
        $title = "Xác thực tài khoản";
        $content = '<h3>Xin chào, ' . $row['nameUser'] . '</h3>';
        $content .= '<p>Bạn cần xác thực tài khoản trước khi đăng nhập.</p>';
        $content .= '<a href="http://localhost/project/xuly.php?token=' . $verify . '">Click here</a>';
        $sendemail = send($title, $content, $row['nameUser'], $row['emailUser'], '');
        if ($sendemail) {
            $sql_update = $conn->prepare("UPDATE `account` SET verify=? WHERE idUser=?");
            $sql_update->execute([$verify, $id]);
            $_SESSION['status_success'] = "Bạn đã đăng ký thành công, vui lòng xác thực tài khoản";
            header('location: register_user.php');
        }
    }
    exit();
}
if (isset($_GET['del_id'])) { // xóa sách khỏi giỏ hàng
    $id = $_GET['del_id'];
    unset($_SESSION['cart'][$id]);
    header('location: cart.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'xoahet') { // xóa hết sách khỏi giỏ hàng
    unset($_SESSION['cart']);
    header('location: cart.php');
    exit();
}
if (isset($_GET['id'])) { //giỏ hàng
    $id = $_GET['id'];
    $checkSLSach = $conn->prepare("SELECT * FROM `sach` WHERE idSach='$id'");
    $checkSLSach->execute();
    if ($checkSLSach->rowCount() > 0) {
        $row_checkSLSach = $checkSLSach->fetch(PDO::FETCH_ASSOC);
        if ($row_checkSLSach['soLuong'] <= 0) {
            $_SESSION['status_warning'] = "Thật đáng tiếc, sách này đã bán hết, chúng tối sẽ sớm nhập hàng về sớm nhất và xin cảm ơn quý khách đã tin tưởng và ủng hộ";
            header('location: sanpham.php');
        } else {
            if (isset($_GET['slmua'])) {
                $slmua = $_GET['slmua'];
                foreach ($_SESSION['cart'] as $key => $value) {
                    if ($id == $key) {
                        $value['slmua'] += $slmua;
                        $slmua = $value['slmua'];
                        break;
                    }
                }
            } else {
                $slmua = 1;
                foreach ($_SESSION['cart'] as $key => $value) {
                    if ($id == $key) {
                        $value['slmua'] += $slmua;
                        $slmua = $value['slmua'];
                        break;
                    }
                }
            }
            $_SESSION['cart'][$id] = array('slmua' => $slmua);
            if (isset($_GET['muangay']) || $_GET['action'] == 'muangay') {
                header('location: cart.php');
            } else if (isset($_GET['themvaogio'])) {
                header('location: single.php?idsanpham=' . $id . '');
            } else {
                header('location: sanpham.php');
            }
        }
    }
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'huydon') { // hủy đơn
    $idorder = $_GET['idorder'];
    $iduser = $_GET['iduser'];
    $huydon = $conn->prepare("UPDATE orders o, diachigh d SET status_order=5 WHERE o.idDiaChiGH=d.idDiaChiGH AND o.idOrder='$idorder' AND d.idUser='$iduser'");
    if ($huydon->execute()) {
        $_SESSION['status_success'] = 'Đề nghị của bạn đã được gửi đi';
        header('location: donhang.php');
    }
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'yeuthich' || $_GET['action'] == 'yeuthich_single' || $_GET['action'] == 'yeuthich_search') { // yêu thích
    if (isset($_SESSION['customer_id'])) {
        $idsach = $_GET['idsach'];
        $iduser = $_GET['iduser'];
        $checkYeuthich = $conn->prepare("SELECT * FROM `yeuthich` WHERE idSach='$idsach' AND idUser='$iduser'");
        $checkYeuthich->execute();
        if ($checkYeuthich->rowCount() > 0) {
            $_SESSION['status_warning'] = 'Sách này đã được bạn yêu thích';
            header('location: sanpham.php');
        } else {
            $yeuthich = $conn->prepare("INSERT INTO yeuthich(idSach, idUser) VALUES('$idsach','$iduser') ");
            $yeuthich->execute();
            if ($_GET['action'] == 'yeuthich') {
                header('location: sanpham.php');
            } else if ($_GET['action'] == 'yeuthich_single' && isset($_SESSION['idSach_single'])) {
                header('location: single.php?idsanpham=' . $_SESSION['idSach_single'] . '');
            } else if (isset($_SESSION['search_key']) && $_GET['action'] == 'yeuthich') {
                header('location: addtoCart.php?search_key=' . $_SESSION['search_key'] . '');
            }
        }
    } else {
        $_SESSION['status_warning'] = 'Vui lòng đăng nhập để yêu thích';
        header('location: login_users.php');
    }
    exit();
}
if ( // bỏ yêu thích
    isset($_GET['action']) && $_GET['action'] == 'unlove'
    || $_GET['action'] == 'unlove_account' || $_GET['action'] == 'unlove_single' || $_GET['action'] == 'unlove_search'
) {
    $idsach = $_GET['idsach'];
    $iduser = $_GET['iduser'];

    $unlove = $conn->prepare("DELETE FROM `yeuthich` WHERE idSach='$idsach' AND idUser='$iduser' ");
    $unlove->execute();
    if ($_GET['action'] == 'unlove_account') {
        header('location: yeuthich.php');
    } else if ($_GET['action'] == 'unlove') {
        header('location: sanpham.php');
    } else if ($_GET['action'] == 'unlove_single' && isset($_SESSION['idSach_single'])) {
        header('location: single.php?idsanpham=' . $_SESSION['idSach_single'] . '');
    } else if ($_GET['action'] == 'unlove' && isset($_SESSION['search_key'])) {
        header('location: addtoCart.php?search_key=' . $_SESSION['search_key'] . '');
    }
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'defaultAddress') { // chọn làm địa chỉ giao mặc định
    $idDiachiGH = $_GET['idAddress'];
    $iduser = $_GET['iduser'];
    $update_status = $conn->prepare("UPDATE `diachigh` SET status=0 WHERE idDiachiGH != '$idDiachiGH' AND idUser='$iduser'");
    $update_status->execute();
    $update_status_macdinh = $conn->prepare("UPDATE `diachigh` SET status=1 WHERE idDiachiGH = '$idDiachiGH' AND idUser='$iduser'");
    $update_status_macdinh->execute();
    header('location: diachigh.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'xoa_diachi') { // xóa địa chỉ 
    $idDiachiGH = $_GET['idDiachiXoa'];
    $iduser = $_GET['iduser'];
    $status = $_GET['status'];
    if ($status == 1) {
        $_SESSION['status_warning'] = "Không thể xóa địa chỉ mặc định";
        header('location: diachigh.php');
    } else {
        $check_diachiGH = $conn->prepare("SELECT * FROM orders WHERE idDiachiGH = ? AND idUser=?");
        $check_diachiGH->execute([$idDiachiGH, $iduser]);
        if ($check_diachiGH->rowCount() > 0) {
            $_SESSION['status_warning'] = "Địa chỉ này đã được dùng để mua sách";
            header('location: diachigh.php');
        } else {
            $delete_diachi = $conn->prepare("DELETE FROM diachigh WHERE idDiachiGH = '$idDiachiGH'");
            $delete_diachi->execute();
            $_SESSION['status_success'] = "Xóa địa chỉ thành công";
            header('location: diachigh.php');
        }
    }
    exit();
}
if (isset($_POST['themdiachi'])) { // thêm địa chỉ
    $iduser = $_SESSION['customer_id'];
    $address = $_POST['address'];
    $tinh = $_POST['tinh'];
    $quan_huyen = $_POST['quan_huyen'];
    $xa = $_POST['xa'];
    if (empty($tinh) || empty($quan_huyen) || empty($xa) || $xa == '' || empty($address)) {
        $_SESSION['status_warning'] = "Vui lòng chọn địa chỉ để mua hàng";
        header('location: diachigh.php');
    } else {
        $update_status_dcgh = $conn->prepare("UPDATE `diachigh` SET status=0 WHERE idUser='$iduser'");
        $update_status_dcgh->execute();
        $insert_diachiGH = $conn->prepare("INSERT INTO `diachigh`(idUser, idXa, idQH , idTinh, diachi, status ,timeCreateAdd, timeUpdateAdd)
        VALUES('$iduser' , '$xa', '$quan_huyen', '$tinh' ,'$address', 1 , NOW(), NOW())");
        if ($insert_diachiGH->execute()) {
            $_SESSION['status_success'] = "Thêm địa chỉ thành công";
            header('location: diachigh.php');
        }
    }
    exit();
}
if (isset($_GET['idtl'])) {
    $id = $_GET['idtl'];
    $_SESSION['tl_id'] = $id;
    if (isset($_SESSION['tl_id']) && !empty($_SESSION['tl_id'])) { //Tìm theo thể loại
        unset($_SESSION['tl_id']);
        unset($_SESSION['allsp']);
        unset($_SESSION['asc']);
        unset($_SESSION['desc']);
        unset($_SESSION['locgia']);
        unset($_SESSION['search_key']);
        $_SESSION['tl_id'] = $id;
        header('location: sanpham.php');
    }
} else if (isset($_GET['action']) && $_GET['action'] == 'allsp') { // tát cả sản phẩm
    $_SESSION['allsp'] = $_GET['action'];
    if (isset($_SESSION['allsp']) && !empty($_SESSION['allsp'])) {
        unset($_SESSION['tl_id']);
        unset($_SESSION['asc']);
        unset($_SESSION['desc']);
        unset($_SESSION['locgia']);
        unset($_SESSION['allsp']);
        unset($_SESSION['search_key']);
        $_SESSION['allsp'] = $_GET['action'];
        header('location: sanpham.php');
    }
} else if (isset($_GET['search_key'])) { // tìm kiếm sản phẩm
    if (empty($_GET['search_key'])) {
        $_SESSION['status_warning'] = "Vui lòng nhập để tìm kiếm";
        header('location: sanpham.php');
    } else {
        $search_key = $_GET['search_key'];
        $search_key = htmlspecialchars($search_key);
        $_SESSION['search_key'] = $search_key;
        unset($_SESSION['tl_id']);
        unset($_SESSION['asc']);
        unset($_SESSION['desc']);
        unset($_SESSION['locgia']);
        unset($_SESSION['allsp']);
    }
    if (isset($_SESSION['search_key']) && !empty($_SESSION['search_key'])) {
        unset($_SESSION['search_key']);
        $_SESSION['search_key'] = $search_key;
        header('location: sanpham.php');
    }
} else if (isset($_GET['action']) && $_GET['action'] == 'asc') { //lọc theo giá tăng dần
    $_SESSION['asc'] = $_GET['action'];
    unset($_SESSION['desc']);
    unset($_SESSION['locgia']);
    header('location: sanpham.php');
} else if (isset($_GET['action']) && $_GET['action'] == 'desc') { // lọc theo giá giảm dần
    $_SESSION['desc'] = $_GET['action'];
    unset($_SESSION['asc']);
    unset($_SESSION['locgia']);
    header('location: sanpham.php');
} else if (isset($_POST['locgia'])) { //lọc theo thanh trượt
    $_SESSION['locgia'] = $_POST['loc'];
    if ($_POST['startprice'] == '' && $_POST['endprice'] == '') {
        header('location: ?action=allsp');
    } else {
        $_SESSION['minprice'] = $_POST['startprice'];
        $_SESSION['maxprice'] = $_POST['endprice'];
        if (isset($_SESSION['maxprice']) && isset($_SESSION['minprice'])) {
            unset($_SESSION['maxprice']);
            unset($_SESSION['minprice']);
            //unset($_SESSION['allsp']);
            unset($_SESSION['asc']);
            unset($_SESSION['desc']);
            //unset($_SESSION['tl_id']);
            $_SESSION['minprice'] = $_POST['startprice'];
            $_SESSION['maxprice'] = $_POST['endprice'];
            header('location: sanpham.php');
        }
    }
}
