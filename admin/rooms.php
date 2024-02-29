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
    <title>Admin Panel - Rooms</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>


    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4">Thông tin phòng</h3>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                            <i class="bi bi-plus-square"></i> Thêm
                        </button>
                    </div>
            
                    <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Loại phòng</th>
                                    <th scope="col">Diện tích</th>
                                    <th scope="col">Khách</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="room-data">
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            

            </div>
        </div>
    </div>

    <!-- Add room modal-->

    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_room_form" autocomplete="off" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm phòng</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tên</label>
                        <input type="text" name="name" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Diện tích</label>
                        <input type="number" min="1" name="area" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá</label>
                        <input type="number" min="1" name="price" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Số lượng</label>
                        <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ngưới lớn(Max.)</label>
                        <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Trẻ em(Max.)</label>
                        <input type="number" min="1" name="children" class="form-control shadow-none" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Đặc điểm</label>
                        <div class="row">
                            <?php
                                $res = selectAll('features');
                                while($opt = mysqli_fetch_assoc($res)) {
                                    echo "
                                        <div class='col-md-3 mb-1'>
                                            <label>
                                                <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                $opt[name]          
                                        </label>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Tiện ích</label>
                        <div class="row">
                            <?php
                                $res = selectAll('facilities');
                                while($opt = mysqli_fetch_assoc($res)) {
                                    echo "
                                        <div class='col-md-3 mb-1'>
                                            <label>
                                                <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                                $opt[name]      
                                            </label>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" onclick="member_name.value='', member_picture.value=''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn custom-bg text-white shadow-none">Xác nhận</button>
            </div>
            </form>            
        </div>
    </div> 
</div>

   <!-- Edit room modal-->
<div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_room_form" autocomplete="off" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa thông tin phòng</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tên</label>
                        <input type="text" name="name" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Diện tích</label>
                        <input type="number" min="1" name="area" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá</label>
                        <input type="number" min="1" name="price" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Số lượng</label>
                        <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Người lớn(Max.)</label>
                        <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Trẻ em(Max.)</label>
                        <input type="number" min="1" name="children" class="form-control shadow-none" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Đặc điểm</label>
                        <div class="row">
                            <?php
                                $res = selectAll('features');
                                while($opt = mysqli_fetch_assoc($res)) {
                                    echo "
                                        <div class='col-md-3 mb-1'>
                                            <label>
                                                <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                $opt[name]          
                                        </label>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Tiện ích</label>
                        <div class="row">
                            <?php
                                $res = selectAll('facilities');
                                while($opt = mysqli_fetch_assoc($res)) {
                                    echo "
                                        <div class='col-md-3 mb-1'>
                                            <label>
                                                <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                                $opt[name]      
                                            </label>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                    </div>
                    <input type="hidden" name="room_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" onclick="member_name.value='', member_picture.value=''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn custom-bg text-white shadow-none">Xác nhận</button>
            </div>
            </form>            
        </div>
    </div> 
</div>

    <!-- Manage room images modal   -->
    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Loại phòng</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert"></div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form">
                            <label class="form-label fw-bold">Thêm hình ảnh</label>
                            <input type="file" name="image" accept="[.jpg, .png, .webp, .jpeg]" class="form-control shadow-none mb-3" required>
                            <button class="btn custom-bg text-white shadow-none">Thêm</button>
                            <input type="hidden" name="room_id">
                        </form>
                    </div>
                    <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col" width="60%">Ảnh</th>
                                    <th scope="col">Ảnh chủ đề</th>
                                    <th scope="col">Xóa</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">

                            </tbody>
                        </table>
                    </div>            
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>
    <script src="scripts/rooms.js">
    </script>
</body>
</html>