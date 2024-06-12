<?php

    require('../inc/db_config.php');
    require('../inc/essentials.php');

    date_default_timezone_set("Asia/Ho_Chi_Minh");
    session_start();


    if(!(isset($_SESSION['user']) && $_SESSION['user'] == true)){
        redirect('index.php');
    }

    if(isset($_POST['cancel_booking']))
    {
        $frm_data = filteration($_POST);
        
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=?
            WHERE `booking_id`=? AND `user_id`=?";

        $values = ['hủy bỏ',0,$frm_data['id'],$_SESSION['uId']];

        $result = update($query,$values,'siii');

        echo $result;
    }


?>