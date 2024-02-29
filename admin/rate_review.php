<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen'])) {
        $frm_data = filteration($_GET);

        if ($frm_data['seen']=='all') {
            $q = "UPDATE `rating_review` SET `seen` = ?";
            $values = [1];
            if (update($q,$values,'i')) {
                alert('success','Đã đánh dấu tất cả!');
            }
            else {
                alert('error','Lỗi! Vui lòng thử lại sau!');
            }
        }
        else {
            $q = "UPDATE `rating_review` SET `seen` = ? WHERE `sr_no` = ?";
            $values = [1,$frm_data['seen']];
            if (update($q,$values,'ii')) {
                alert('success','Đã đánh dấu!');
            }
            else {
                alert('error','Lỗi! Vui lòng thử lại sau!');
            }
        }
    }

    if(isset($_GET['del'])) {
        $frm_data = filteration($_GET);

        if ($frm_data['del']=='all') {
            $q = "DELETE FROM `rating_review`";
            if (mysqli_query($con,$q)) {
                alert('success','Đã xóa tất cả!');
            }
            else {
                alert('error','Lỗi! Vui lòng thử lại sau');
            }
        }
        else {
            $q = "DELETE FROM `rating_review` WHERE `sr_no` = ?";
            $values = [$frm_data['del']];
            if (delete($q,$values,'i')) {
                alert('success','Đã xóa!');
            }
            else {
                alert('error','Lỗi! Vui lòng thử lại sau');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý - Đánh giá & phản hồi</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>


    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4"> Đánh giá & phản hồi</h3>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    
                    <div class="text-end mb-4">
                        <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                            <i class="bi bi-check-all"></i>Đánh dấu tất cả là đã đọc
                        </a>
                        <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                            <i class="bi bi-trash"></i>Xóa tất cả
                        </a>
                    </div>

                    <div class="table-responsive-md">
                        <table class="table table-hover border">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Tên phòng</th>
                                    <th scope="col">Tên người dùng</th>
                                    <th scope="col">Đánh giá</th>
                                    <th scope="col" width="30%">Phản hồi</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col" width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $q = "SELECT rr.*,u.full_name AS uname, r.name AS rname FROM `rating_review` rr
                                     INNER JOIN `users` u ON rr.user_id = u.id
                                     INNER JOIN `rooms` r ON rr.room_id = r.id
                                     ORDER BY `sr_no` DESC";

                                    $data = mysqli_query($con, $q);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $date = date('d-m-Y',strtotime($row['datetime']));



                                        $seen = '';
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary mb-2' style='font-size: 15px'>Đánh dấu là đã đọc</a>";
                                        }
                                        $seen.= "<a> </a>";
                                        $seen.= "<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger mb-2' style='font-size: 15px'>Xóa</a>";

                                        echo <<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[rname]</td>
                                                <td>$row[uname]</td>
                                                <td>$row[rating]</td>
                                                <td>$row[review]</td>
                                                <td>$date</td>
                                                <td>$seen</td>
                                            </tr>
                                        query;
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            

            </div>
        </div>
    <div>
    
    <?php require('inc/scripts.php'); ?>
</body>
</html>