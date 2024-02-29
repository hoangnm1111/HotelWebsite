<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_r['site_title']; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link me-2" href="index.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                <a class="nav-link me-2" href="rooms.php">Phòng</a>
                </li>
                <li class="nav-item">
                <a class="nav-link me-2" href="facilities.php">Tiện ích</a>
                </li>
                <li class="nav-item">
                <a class="nav-link me-2" href="contact.php">Liên hệ</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="about.php">Về chúng tôi</a>
                </li>
                
            </ul>
            <div class="d-flex">  
                <?php 
                    if (isset($_SESSION["user"]) && $_SESSION["user"]==true)
                    {
                        echo <<< data
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    $_SESSION[uName]
                                </button>
                                <ul class="dropdown-menu dropdown-menu-lg-end">
                                    <li><a class="dropdown-item" href="profile.php">Hồ sơ</a></li>
                                    <li><a class="dropdown-item" href="bookings.php">Đặt phòng</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                                </ul>
                            </div>
                        data;
                    }
                    else
                    {
                        echo <<< data
                            <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" onclick="window.location.href='login.php'">
                                Đăng nhập
                            </button>
                            <button type="button" class="btn btn-outline-dark shadow-none" onclick="window.location.href='registration.php'">
                                Đăng ký
                            </button>
                        data;
                    }
                ?>  
            </div>
        </div>
    </div>
</nav>