<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title']; ?> - Trang chủ </title>
    
    <style>
        .availablility-form{
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and(max-width: 575px) {
            .availablility-form{
                margin-top: 25px;
                padding: 0 35px;
            }
        }

        .custom-bg{
            background-color: #2ec1ac;
        }
        .custom-bg:hover{
            background-color: #279e8c;
        }

        .availablility-form{
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px) {
            .availablility-form{
                margin-top: 25px;
                padding: 0 35px;
            }
        }
    </style>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>
    
    <!-- Carousel -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php 
                    $res = selectAll('carousel');
                    while ($row = mysqli_fetch_assoc($res)) {
                        $path = CAROUSEL_IMG_PATH;
                        echo <<<data
                            <div class="swiper-slide">
                            <img src="$path$row[image]" class="w-100 d-block"/>
                            </div>
                        data;
                        }

                    ?>
            
            <!-- <div class="swiper-slide">
                <img src="images/carousel/5.png" class="w-100 d-block"/>
            </div>
            <div class="swiper-slide">
                <img src="images/carousel/6.png" class="w-100 d-block"/>
            </div>
            <div class="swiper-slide">
                <img src="images/carousel/7.png" class="w-100 d-block"/> -->
            <!-- </div> -->
            </div>
        </div>
    </div>

    <!-- check availability form -->

    <div class="container availablility-form">
        <div class=row>
            <div class="col-lg-12 bg-white shadow p-4 rounder">
                <h5 class="mb-4">Tùy chọn</h5>
                <form action="rooms.php">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Nhận phòng</label>
                            <input type="date" class="form-control shadow-none" name="checkin" required>  
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Trả phòng</label>
                            <input type="date" class="form-control shadow-none" name="checkout" required>  
                        </div>
                        <div class="col-lg-3 mb-3">
                        <label class="form-label" style="font-weight: 500;" >Người lớn</label>
                            <select class="form-select shadow-none" name="adult">
                                <?php 
                                    $guests_q = mysqli_query($con, "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children` 
                                        FROM `rooms` WHERE `status`='1' AND `removed`='0'");
                                    $guests_res = mysqli_fetch_assoc($guests_q);

                                    for($i=1;$i<=$guests_res['max_adult']; $i++){
                                        echo"<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                        <label class="form-label" style="font-weight: 500;">Trẻ em</label>
                            <select class="form-select shadow-none" name="children">
                                <?php 
                                    for($i=1;$i<=$guests_res['max_children']; $i++){
                                        echo"<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="check_availability">
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>


<br><br><br>

    <!--Our Rooms-->
    <h2 class = "mt-5 pt-4 mb-4 text-center fx-bold b-font ">Thông tin các phòng</h2>
    <div class="container">
        <div class="row">
        <?php
                    $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3", [1,0], 'ii');
                    while($room_data = mysqli_fetch_assoc($room_res)) {
                        // get features of rooms
                        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `rooms_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");

                        $features_data = "";
                        while($fea_row = mysqli_fetch_assoc($fea_q)) {
                            $features_data .= "<span class='badge rounded-pill text-dark text-wrap bg-light me-1 mb-1'>
                                                    $fea_row[name]
                                                </span>";
                                          
                        }
                        // get facilitites of rooms
                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `rooms_facilities` rfac ON rfac.facilities_id = f.id WHERE rfac.room_id = '$room_data[id]'");
                        $facilities_data = "";
                        while($fac_row = mysqli_fetch_assoc($fac_q)) {
                            $facilities_data .= "<span class='badge rounded-pill text-dark text-wrap bg-light me-1 mb-1'>
                                                    $fac_row[name]
                                                </span>";
                                          
                        }

                        // get thumbnail of images
                        $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
                        $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

                        if (mysqli_num_rows($thumb_q) > 0) {
                            $thumb_res = mysqli_fetch_assoc($thumb_q);
                            $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                        }

                        $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM  `rating_review` 
                         WHERE `room_id` = '$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";

                        $rating_res = mysqli_query($con,$rating_q);
                        $rating_fetch = mysqli_fetch_assoc($rating_res);

                        $rating_data = "";

                        if($rating_fetch['avg_rating']!=NULL)
                        {
                            $rating_data = "<div class='rating mb-4'>
                                <h6 class='mb-1'>Đánh giá</h6>
                                <span class='badge rounded-pill bg-light'>
                            ";

                            for($i=0; $i< $rating_fetch['avg_rating']; $i++){
                                $rating_data .="<i class='bi bi-star-fill text-warning'></i>";
                            }
                                $rating_data .= "</span>
                                    </div>
                                ";
                        
                        }

                        


                        // print room card
                        echo <<<data
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                    <img src="$room_thumb" class="card-img-top">
                                    <div class="card-body">
                                        <h5>$room_data[name]</h5>
                                        <h6 class="mb-4">$room_data[price]VND/đêm</h6>
                                        <div class="features mb-4">
                                            <h6 class="mb-1">Đặc điểm</h6>
                                            $features_data
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1">Tiện nghi</h6>
                                            $facilities_data
                                        </div>
                                        <div class="guests mb-4">
                                            <h6 class="mb-1">Khách</h6>
                                            <span class="badge rounded-pill text-dark text-wrap bg-light">
                                                $room_data[adult] Người lớn
                                            </span>
                                            <span class="badge rounded-pill text-dark text-wrap bg-light">
                                                $room_data[children] Trẻ em
                                            </span>
                                        </div>
                                        $rating_data
                                        <div class="d-flex justify-content-evenly mb-2">
                                            <a href="confirm_booking.php?id=$room_data[id]" class="btn btn-sm text-white custom-bg shadow-none">Đặt phòng</a>
                                            <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none" >Thông tin chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        data;
                    }

                ?>

            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Các phòng khác>>></a>
                
            </div>
        </div>
    </div>

    <h2 class = "mt-5 pt-4 mb-4 text-center fx-bold b-font ">Dịch vụ</h2>

    <div class = "container">
        <div class = "row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
                $res = mysqli_query($con,"SELECT  * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
                while ($row = mysqli_fetch_assoc($res)) {
                    $img = FACILITIES_IMG_PATH.$row['icon'];
                    echo<<<data
                        <div class = "col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                            <img src = $img width = "50px" class = "mt-4">
                            <h5 class = "mt-md-3">$row[name]</h5>
                        </div>
                    data;
                } 
            ?>

            <!-- <div class = "col-lg-2 col-md-2 btn btn-outline-dark text-center border-light rounded shadow py-4 my-3 ">
                <a href="facilities.php" class = "mt-5 mt-sm-12"> Các dịch vụ khác <br> >>></a>
            </div> -->
            <a href = "facilities.php" class = "col-lg-2 col-md-2 btn btn-outline-dark text-center border-light rounded shadow py-4 my-3">
                <div class="mt-4"> Các dịch vụ khác<br>>>> </div>
            </a>
        </div>
    </div>

    <!-- Testimonials -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold b-font">Ðánh giá của khách hàng</h2>

    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">
             <?php 
             
              $review_q = "SELECT rr.*,u.full_name AS uname, r.name AS rname FROM `rating_review` rr
                INNER JOIN `users` u ON rr.user_id = u.id
                INNER JOIN `rooms` r ON rr.room_id = r.id
                ORDER BY `sr_no` DESC LIMIT 6";

                $review_res = mysqli_query($con, $review_q);

                // Kiểm tra số lượng đánh giá và phản hồi
                if (mysqli_num_rows($review_res) == 0) {
                    echo "<div class='text-center'>Chưa có đánh giá nào!</div>";
                } else {
                    while ($row = mysqli_fetch_assoc($review_res)) {
                        $stars = "<i class='bi bi-star-fill text-warning'></i>";
                        for ($i = 1; $i < $row['rating']; $i++) {
                            $stars .= "<i class='bi bi-star-fill text-warning'></i>";
                        }

                        echo "<div class='swiper-slide bg-white p-4'>";
                        echo "<div class='profile d-flex align-items-center mb-3'>";
                        echo "<h6 class='m-0 '>Người dùng:$row[uname]</h6>";
                        echo "</div>";
                        echo "<p>$row[review]</p>";
                        echo "<div class='rating'>$stars</div>";
                        echo "</div>";
                    }
                }
            ?>
             
            

            <div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Tìm hiểu thêm >>></a>
        </div>
    </div>
    <br><br>

    <!-- Reach us -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold b-font">TÌM CHÚNG TÔI</h2>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" height="320px" src="<?php echo $contact_r['iframe'] ?>" loading="lazy"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Liên hệ</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                      <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                    </a>
                    <br>
                    <?php 
                        if($contact_r['pn2']!=''){ 
                            echo<<<data
                            <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                          </a>
                        data;
                        }
                       
                        

                    ?>    
                   
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Theo dõi</h5>
                    <?php 
                        if($contact_r['fb']!=''){
                            echo<<<data
                            <a href="$contact_r[fb]" class="d-inline-block mb-3">
                                <span class="badge bg-light text-dark fs-6 p-2">
                                <i class="bi bi-twitter-x"></i> Twitter
                                </span>
                            </a>
                            <br>
                            data;
                        }
                    
                    ?>
                    
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3">
                      <span class="badge bg-light text-dark fs-6 p-2">
                      <i class="bi bi-facebook"></i> Facebook
                      </span>
                    </a>
                    <br>
                    <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block mb-3">
                      <span class="badge bg-light text-dark fs-6 p-2">
                      <i class="bi bi-instagram"></i> Instagram
                      </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      }
    });
    </script>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      }
    });
    var swiper = new Swiper(".swiper-testimonials", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView: "3",
      loop: true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
      ier: 1,  modif,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
            slidesPerView: 1,
        },
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        }
      }
    });
    </script>
</body>
</html>
