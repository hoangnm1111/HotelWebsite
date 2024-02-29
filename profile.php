<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Thông tin cá nhân</title>
</head>
<body class="bg-light">
    
    <?php 
        require('inc/header.php');

        if(!(isset($_SESSION['user']) && $_SESSION['user'] == "yes")) {
            redirect('index.php');
        }

        $u_exist = select("SELECT * FROM `users` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');

        if (mysqli_num_rows($u_exist) == 0) {
            redirect('index.php');
        }

        $u_fetch = mysqli_fetch_assoc($u_exist);
    ?>

    <div class="container">
        <div class="row">
            
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">Thông tin cá nhân</h2>
                <div style="font-size:14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">Thông tin cá nhân</a>
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3 fw-bold">Thông tin cơ bản</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input name="name" type="text" value="<?php echo $u_fetch['full_name']?>" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input name="phonenum" type="number" value="<?php echo $u_fetch['phonenum']?>" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">CMND/CCCD</label>
                                <input name="idencard" type="text" value="<?php echo $u_fetch['idencard']?>" class="form-control shadow-none" disabled required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <textarea name="email" class="form-control shadow-none" rows="1" disabled required><?php echo $u_fetch['email']?></textarea>
                            </div>

                            
                        </div>

                        <button type="submit" class="btn text-white custom-bg shadow-none">Lưu thay đổi</button>
                    </form>
                </div>
            </div>  

            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb-3 fw-bold">Đổi mật khẩu</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mật khẩu mới</label>
                                <input name="new_pass" type="password" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Xác nhận mật khẩu mới</label>
                                <input name="confirm_pass" type="password"class="form-control shadow-none" required>
                            </div>
                        </div>

                        <button type="submit" class="btn text-white custom-bg shadow-none">Lưu thay đổi</button>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <script>
        let info_form = document.getElementById('info-form');

        info_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();
            data.append('info_form','');
            data.append('name',info_form.elements['name'].value);
            data.append('phonenum',info_form.elements['phonenum'].value);
            data.append('idencard',info_form.elements['idencard'].value);
            data.append('email',info_form.elements['email'].value);        
            
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST","admin/ajax/profile.php",true);

            xhr.onload = function(){
                if (this.responseText == 'phone_already') {
                    alert('Số điện thoại đã được sử dụng');
                }
                else if (this.responseText == 0) {
                    alert('Lưu không thành công! Vui lòng thử lại sau!')
                }
                else {
                    alert("Lưu thành công!");
                }
            }

            xhr.send(data);
    
        }) 

        let pass_form = document.getElementById('pass-form');

        pass_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let new_pass = pass_form.elements['new_pass'].value;
            let confirm_pass = pass_form.elements['confirm_pass'].value;

            if (new_pass != confirm_pass) {
                alert('Xác nhận mật khẩu không thành công!');
                return false;
            }

            let data = new FormData();
            data.append('pass_form','');
            data.append('new_pass',new_pass);   
            data.append('confirm_pass',confirm_pass);
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST","admin/ajax/profile.php",true);

            xhr.onload = function(){
                if (this.responseText == 'mismatch') {
                    alert('Xác nhận mật khẩu không thành công!');
                }
                else {
                    alert('Đổi mật khẩu thành công!');
                    pass_form.reset();
                }
            }

            xhr.send(data);
    
        }) 
    </script>

</body>
</html>