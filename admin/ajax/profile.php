<?php 
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    if (isset($_POST['info_form'])) {
        $frm_data = filteration($_POST);
        session_start();

        $u_exist = select("SELECT * FROM `users` WHERE `phonenum` = ? AND `id` != ? LIMIT 1",
            [$frm_data['phonenum'], $_SESSION['uId']], "ss");
        
        if (mysqli_num_rows($u_exist)!=0) {
            echo 'phone_already';
            exit;
        }

        $query = "UPDATE `users` SET `full_name`=?, `phonenum`=?, `idencard`=?, `email`=? WHERE `id`=?";
        $values = [$frm_data['name'],$frm_data['phonenum'],$frm_data['idencard'],$frm_data['email'],$_SESSION['uId']];
        if (update($query,$values,'sssss')) {
            $_SESSION['uName'] = $frm_data['name'];
            echo 1;
        }
        else {
            echo 0;
        }
    }

    if (isset($_POST['pass_form'])) {
        $frm_data = filteration($_POST);
        session_start();

        if ($frm_data['new_pass'] != $frm_data['confirm_pass']) {
            echo 'mismatch';
            exit;
        }

        $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);

        $query = "UPDATE `users` SET `password`=? WHERE `id`=? LIMIT 1";
        $values = [$enc_pass,$_SESSION['uId']];
        if (update($query,$values,'ss')) {
            echo 1;
        }
        else {
            echo 0;
        }
    }
?>