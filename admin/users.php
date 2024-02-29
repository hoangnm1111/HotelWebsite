<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen']))
    {
        $frm_data = filteration($_GET);

        if ($frm_data['seen']=='all') {
            $q = "UPDATE `user_queries` SET `seen` = ?";
            $values = [1];
            if (update($q,$values,'i')) {
                alert('success','Đã đánh dấu tất cả!');
            }
            else {
                alert('error','Lỗi! Vui lòng thử lại sau!');
            }
        }
        else {
            $q = "UPDATE `user_queries` SET `seen` = ? WHERE `sr_no` = ?";
            $values = [1,$frm_data['seen']];
            if (update($q,$values,'ii')) {
                alert('success','Đã đánh dấu!');
            }
            else {
                alert('error','Lỗi! Vui lòng thử lại sau!');
            }
        }
    }


    if(isset($_GET['del'])) 
    {
        $frm_data = filteration($_GET);

        if ($frm_data['del']=='all') {
            $q = "DELETE FROM `user_queries`";
            if (mysqli_query($con,$q)) {
                alert('success','Đã xóa tất cả!');
            }
            else {
                alert('error','Lỗi! Vui lòng thử lại sau');
            }
        }
        else {
            $q = "DELETE FROM `user_queries` WHERE `sr_no` = ?";
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
    <title>Trang quản lý - Khách hàng</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>


    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4"> Khách hàng</h3>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">
                        <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Tìm kiếm...">
                    </div> 
            
                    <div class="table-responsive">
                        <table class="table table-hover border text-center" style="min-width: 1300px;">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Phone number</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="users-data">
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            

            </div>
        </div>
    </div>




    <?php require('inc/scripts.php'); ?>
    <script src="scripts/users.js">
    </script>
</body>
</html>