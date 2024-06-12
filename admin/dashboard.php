<?php 
    require('inc/essentials.php');
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php 
    require('inc/header.php');
    require('inc/db_config.php');

    

    $current_bookings = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
      COUNT(booking_id) AS `total_bookings`,
      SUM(CASE WHEN booking_status='thành công' AND arrival=1 THEN `trans_amt` END) AS `active_amt`,
      COUNT(CASE WHEN booking_status='thành công' AND arrival=1 THEN booking_id END) AS `active_bookings`,
      COUNT(CASE WHEN booking_status='cancelled' AND refund=1 THEN booking_id END) AS `cancelled_bookings`,
      SUM(CASE WHEN booking_status='cancelled' AND refund=1 THEN `trans_amt` END) AS `cancelled_amt`
    FROM `booking_order`
  "));
        $total_amt = $current_bookings['active_amt'] + $current_bookings['cancelled_amt'];

    // Lấy tổng số phản ánh
    $total_queries = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
    COUNT(sr_no) AS `count` 
    FROM `user_queries`
    "));

    // Lấy tổng số đánh giá
    $total_review = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
    COUNT(sr_no) AS `count`
    FROM `rating_review`  
    "));

    // Lấy tổng số người dùng mới
    $total_new_reg = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
    COUNT(id) AS `count`
    FROM `users`
    "));

    $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT
        COUNT(id) AS `total`
        FROM `users`"));

    ?>




    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">


            <div class="d-flex align-items-center justify-content-between mb-4"> 
                <h3>Thống kê</h3>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3"></div>
                <h5>Thống kê đặt phòng & doanh thu</h5>
                <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                    <option value="1">30 ngày vừa qua</option>
                    <option value="2">90 ngày vừa qua</option>
                    <option value="3">1 năm vừa qua</option>
                    <option value="4">Từ trước tới nay</option>
                </select>
            <div>

            <div class="row mb-3">
                <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Tổng đặt phòng</h6>
                            <h1 class="mt-2 mb-0"  id="total_bookings"><?php echo $current_bookings['total_bookings']; ?> </h1>
                            <h4 class="mt-2 mb-0" id="total_amt"><?php echo $total_amt; ?> VND</h4>                        </div>
                </div>
                <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Số phòng đang được đặt thành công</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings"><?php echo $current_bookings['active_bookings']; ?></h1>
                            <h4 class="mt-2 mb-0" id="active_amt"><?php echo $current_bookings['active_amt']; ?> VND</h4>
                        </div>
                </div>
                <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Số lượng phòng đã bị hủy</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings"><?php echo $current_bookings['cancelled_bookings']; ?></h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt"><?php echo $current_bookings['cancelled_amt']; ?> VND</h4>
                        </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3"></div>
                <h5>Thống kê số lượng</h5>
                <select class="form-select shadow-none bg-light w-auto">
                    <option value="1">30 ngày vừa qua</option>
                    <option value="2">90 ngày vừa qua</option>
                    <option value="3">1 năm vừa qua</option>
                    <option value="4">Từ trước tới nay</option>
                </select>
            <div>

            <div class="row mb-3">
                <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Khách hàng mới đăng ký</h6>
                            <h1 class="mt-2 mb-0 id="total_new_reg"><?php echo $total_new_reg['count']; ?></h1>
                        </div>
                </div>
                <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Phản ánh tới quản lý</h6>
                            <h1 class="mt-2 mb-0"id="total_queries"><?php echo $total_queries['count'] ?></h1>
                        </div>
                </div>
                <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Đánh giá & phản hồi</h6>
                            <h1 class="mt-2 mb-0 id="$total_review"><?php echo $total_review['count']; ?></h1>
                        </div>
                </div>
            </div>

            <h5>Số lượng khách hàng</h5>
            <div class="row mb-3">
                <div class="col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>Tài khoản</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total']?></h1>
                        </div>
                </div>
            <div>

            

            </div>
        </div>
    </div>
    
    <?php require('inc/scripts.php'); ?>
    <script> src="scripts/dashboard.js"</script>
</body>
</html>