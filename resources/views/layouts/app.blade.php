<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>@yield('title')</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="AR.jpeg" rel="icon">
        <link href="AR.jpeg" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top">
            <div class="container d-flex align-items-center">
                <a href="{{route('home')}}" class="logo mr-auto"><img src="AR.jpeg" alt="" class="img-fluid"></a>
                <nav class="nav-menu d-none d-lg-block">
                    <ul>
                        @if (session()->has("user"))
                            <li><a href="https://drive.google.com/file/d/19veAma18IV_fj_JVVyVSly3GgBMoRmNE/view?usp=sharing" target="_blank">範例樣本</a></li>
                            <li><a href="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/說明.pdf" target="_blank">操作說明</a></li>
                            <li><a href="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/ARTrivia範例.mp4" target="_blank">網站操作影片</a></li>
                            <li><a href="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/app端.mp4" target="_blank">APP操作影片</a></li>
                            <li><a href="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/new_arlearning2.apk" target="_blank">英語學習APP</a></li>
                            <li><a href="https://forms.gle/XqepPishccYxKiHf9" target="_blank">問卷</a><li>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><a href="{{route('logout')}}">Logout</a></li>
                        @else
                        <li><a href="https://drive.google.com/file/d/19veAma18IV_fj_JVVyVSly3GgBMoRmNE/view?usp=sharing" target="_blank">範例樣本</a></li>
                        <li><a href="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/ARTrivia範例.mp4" target="_blank">網站操作影片</a></li>
                        <li><a href="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/app端.mp4" target="_blank">APP操作影片</a></li>
                        <li><a href="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/new_arlearning2.apk" target="_blank">英語學習APP</a></li>    
                        <li><a href="{{route('login')}}">Login</a></li>
                        <li><a href="{{route('register')}}">Register</a></li>
                        <li><a href="https://forms.gle/XqepPishccYxKiHf9" target="_blank">問卷</a><li>
                        @endif
                        
                        
                    </ul>
                </nav><!-- .nav-menu -->
            </div>
        </header><!-- End Header -->

        @yield("main")

        <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="container d-md-flex py-4">
                <div class="mr-md-auto text-center text-md-left">
                    <div class="copyright">
                        &copy; Copyright <strong><span>AR Trivia</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/ -->
                        Designed by <a href="https://bootstrapmade.com/">MIT Lab</a>
                    </div>
                    <div>
                        <a href="https://forms.gle/XqepPishccYxKiHf9">請大家幫忙填寫問卷</a>
                    </div>
                </div>
                <div class="social-links text-center text-md-right pt-3 pt-md-0">
                    <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    
                    
                </div>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
        <script src="assets/vendor/counterup/counterup.min.js"></script>
        <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>

    </body>

</html>
