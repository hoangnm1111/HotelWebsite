<?php

    require('../inc/essentials.php');
    require('../inc/db_config.php');
    adminLogin();

    if (isset($_POST['booking_analytics'])) 
    {
        $frm_data = filteration($_POST);

    

    if($frm_data['period'==1]){
      $condition="WHERE datentime BETWEEN (NOW() - INTERVAL 30 DAY) AND NOW()";
    }
    else if($frm_data['period'==2]){
      $condition="WHERE datentime BETWEEN (NOW() - INTERVAL 90 DAY) AND NOW()";
    }
    else if($frm_data['period'==3]){
      $condition="WHERE datentime BETWEEN (NOW() - INTERVAL 1 YEAR) AND NOW()";
    }

       

    $result = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
      COUNT(booking_id) AS `total_bookings`,
      SUM(CASE WHEN booking_status='thành công' AND arrival=1 THEN `trans_amt` END) AS `active_amt`,
      COUNT(CASE WHEN booking_status='thành công' AND arrival=1 THEN booking_id END) AS `active_bookings`,
      COUNT(CASE WHEN booking_status='cancelled' AND refund=1 THEN booking_id END) AS `cancelled_bookings`,
      SUM(CASE WHEN booking_status='cancelled' AND refund=1 THEN `trans_amt` END) AS `cancelled_amt`
    FROM `booking_order` $condition"));

    
    }

?>