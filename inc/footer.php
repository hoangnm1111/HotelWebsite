<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title']; ?></h3>
            <p>
                <?php echo $settings_r['site_about']; ?>
            </p>
        </div>

        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Liên kết</h5>
            <!-- <a href="home.php" class="d-inline-block mb-2 text-dark text-decoration-none">Trang chủ</a> <br>  -->
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Phòng</a> <br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Tiện ích</a> <br> 
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Liên hệ</a> <br> 
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">Về chúng tôi</a> 
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Mạng xã hội</h5>
            
            <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2 ">
             <i class="bi bi-facebook me-1"></i> Facebook
            </a><br>
            <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
             <i class="bi bi-instagram me-1"></i> Instagram
            </a><br>
            <a href="<?php echo "tiktok.com" ?>" class="d-inline-block text-dark text-decoration-none mb-2">
             <i class="bi bi-tiktok me-1"></i> TikTok
            </a><br>
    </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-8">Nhập môn công nghệ phần mềm - Nhóm 12</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    function setActive(){
      let navbar = document.getElementById('nav-bar');
      let a_tags = navbar.getElementsByTagName('a');

      for(i=0; i<a_tags.length; i++)
      {
        let file = a_tags[i].href.split('/').pop();
        let file_name = file.split('.')[0];

        if(document.location.href.indexOf(file_name) >= 0){
            a_tags[i].classList.add('active');
        }
      }
    }
    setActive();

</script>
