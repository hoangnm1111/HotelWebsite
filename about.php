<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
        <?php require('inc/links.php'); ?>
        <title><?php echo $settings_r['site_title']; ?> - Về chúng tôi</title>
    </head>

    <body class="bg-light">
        
        <?php require('inc/header.php'); ?>

        <div class="my-5 px-4">
            <h2 class="fw-bold b-font text-center">VỀ CHÚNG TÔI</h2>
            <div class="h-line bg-dark"></div>
            <p class="text-center mt-3">
            Với những tiện ích và dịch vụ tuyệt vời, khách sạn BK Hotel là lựa chọn hoàn hảo 
            <br>cho du khách muốn có một kỳ nghỉ hoặc chuyến công tác tuyệt vời tại Hà Nội.
            </p>
        </div>

        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                    <h3 class="mb-3">Đội ngũ quản lý chuyên nghiệp</h3>
                    <p>
                    Đội ngũ quản lý của khách sạn BK Hotel được tạo thành bởi một nhóm chuyên gia giàu kinh nghiệm trong ngành khách sạn và du lịch. 
                    Với sự chuyên nghiệp và sự tận tâm, chúng tôi đảm bảo rằng mọi khách hàng nhận được dịch vụ tốt nhất và trải nghiệm lưu trú đáng nhớ.
                    </p>
                </div>

                <div class="col-lg-5 col-md-4 mb-4 order-lg-2 order-md-2 order-1">
                    <img src="https://hthaostudio.com/wp-content/uploads/2020/08/Son-Tran-12.jpg" width="400px">
                </div>


            </div>
        </div>

        <div class="container mt-5">
            <div class="row justify-content-evenly">
                <div class="col-lg-3 col-md-6 mb-4 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 text-center box h-100">
                        <img src="images/about/hotel.svg" width="70px">
                        <h4 class="mt-4">100+ PHÒNG</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 text-center box h-100">
                        <img src="images/about/customers.svg" width="70px">
                        <h4 class="mt-3">2000+ KHÁCH HÀNG</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 text-center box h-100">
                        <img src="images/about/rating.svg" width="70px">
                        <h4 class="mt-4">150+ ĐÁNH GIÁ</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 text-center box h-100">
                        <img src="images/about/staff.svg" width="70px">
                        <h4 class="mt-4">50+ NHÂN VIÊN</h4>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="my-5 fw-bold b-font text-center">NHÓM QUẢN LÝ</h3>

        <div class="container px-4">
            <div class="swiper mySwiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                <div class="swiper-wrapper mb-5" id="swiper-wrapper-dc64d9daf684fd29" aria-live="polite">
                    <?php 
                        $about_r = selectAll('team_details');
                        $path=ABOUT_IMG_PATH;
                        while($row = mysqli_fetch_assoc($about_r)){
                            echo<<<data
                            <div class="swiper-slide swiper-slide-active bg-white text-center overflow-hidden rounded" role="group" aria-label="1 / 8" style="width: 888px;">
                                <img src="images/about/$row[picture]" class="w-100">
                                <h5 class="mt-2">$row[name]</h5>
                            </div>
                            data;
                        }

                    ?>       
                    
                </div>

                <div class="swiper-pagination swiper-pagination-bullets swiper-pagination-horizontal">
                    <span class="swiper-pagination-bullet swiper-pagination-bullet-active" aria-current="true"></span>
                    <span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span>
                    <span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span>
                    <span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span>
                    <span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 4,
                spaceBetween: 40,
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
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                }
            });
        </script>

        <?php require('inc/footer.php'); ?>
    </body>
</html>

