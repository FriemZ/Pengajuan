<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">


<!-- Mirrored from bootstrapdemos.wrappixel.com/materialpro/dist/main/frontend-landingpage.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 May 2025 04:46:18 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

    <!-- Core Css -->
    <link rel="stylesheet" href="../assets/css/styles.css" />

    <title>MaterialPro Bootstrap Admin</title>
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="../assets/libs/owl.carousel/dist/assets/owl.carousel.min.css" />
</head>

<body>
    <div class="costom-logo-fp preloader">
        <a href="javascript:void(0)" class="text-nowrap logo-img d-flex align-items-center">
            <b class="logo-icon">
                <!-- Dark Logo icon -->
                <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-icon.svg"
                    alt="loader" class="dark-logo lds-ripple img-fluid" />
                <!-- Light Logo icon -->
                <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-icon.svg"
                    alt="loader" class="light-logo lds-ripple img-fluid" />
            </b>
        </a>
    </div>

    <!-- -------------------------------------------- -->
    <!-- Header start -->
    <!-- -------------------------------------------- -->
    <header class="header-fp p-0 w-100 bg-primary-subtle">
        <nav class="navbar navbar-expand-lg py-10">
            <div class="container-fluid d-flex justify-content-between">
                <a href="frontend-landingpage.html" class="text-nowrap logo-img d-flex align-items-center gap-2">
                    <b class="logo-icon">
                        <!-- Dark Logo icon -->
                        <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-icon.svg"
                            alt="homepage" class="dark-logo" />
                        <!-- Light Logo icon -->
                        <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-icon.svg"
                            alt="homepage" class="light-logo" />
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                        <!-- dark Logo text -->
                        <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-text.svg"
                            alt="homepage" class="dark-logo ps-2" />
                        <!-- Light Logo text -->
                        <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-text.svg"
                            class="light-logo ps-2" alt="homepage" />
                    </span>
                </a>

            </div>
        </nav>
    </header>
    <!-- -------------------------------------------- -->
    <!-- Header End -->
    <!-- -------------------------------------------- -->


    <div class="main-wrapper overflow-hidden">
        <!-- ------------------------------------- -->
        <!-- banner Start -->
        <section class="py-7 py-lg-0 pt-lg-12 overflow-hidden bg-primary-subtle">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden shadow-none">
                            <div class="card-body bg-white rounded-4 position-relative z-1">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-sm-6">
                                        <h5 class="fw-semibold mb-9 fs-5 ">Welcome back, please enter your name!</h5>
                                        <form id="nameForm">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="nama"
                                                    placeholder="Masukkan Nama">
                                                <button class="btn btn-primary" type="submit">Cari</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="position-relative mb-n7 text-end">
                                            <img src="../assets/images/backgrounds/welcome-bg2.png"
                                                alt="materialpro-img" class="img-fluid" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- ------------------------------------- -->
        <!-- banner End -->
        <!-- ------------------------------------- -->

        <!-- SignIn modal content -->
        <div id="login-modal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="passwordForm" method="POST" data-user-id="{{ $userId ?? '' }}">
                            @csrf
                            <div class="mb-4">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="userPassword" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-8 mb-4">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchForm = document.getElementById('nameForm');
                const passwordForm = document.getElementById('passwordForm');

                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const nama = document.getElementById('nama').value;

                        fetch('{{ route('check-name') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    nama
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    passwordForm.dataset.userId = data.user_id;
                                    new bootstrap.Modal(document.getElementById('login-modal')).show();
                                } else {
                                    alert(data.message || 'Nama tidak ditemukan');
                                }
                            });
                    });
                }

                if (passwordForm) {
                    passwordForm.addEventListener('submit', function(e) {
                        e.preventDefault(); // mencegah reload

                        const password = document.getElementById('userPassword').value;
                        const userId = this.dataset.userId;

                        fetch("{{ route('check-password') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({
                                    password,
                                    userId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.href = data.redirect;
                                } else {
                                    alert(data.message || "Password salah");
                                }
                            })
                            .catch(error => {
                                console.error("Login error:", error);
                            });
                    });
                }
            });
        </script>

        <!-- ------------------------------------- -->
        <!-- Team Start -->
        <!-- ------------------------------------- -->
        <section class="bg-dark py-7 py-md-14 py-lg-11 mb-5">
            <div class="container-fluid">
                <div class="row mb-7 mb-lg-0">
                    <div class="col-lg-7">
                        <h2 class="text-white fs-15 fw-semibold mb-lg-0 lh-sm">
                            Meet our team
                        </h2>
                    </div>

                </div>
                <div class="owl-carousel leadership-carousel owl-theme mt-lg-5 mb-lg-7">
                    <div class="item">
                        <div class="meet-our-team position-relative rounded-3 overflow-hidden">
                            <img src="../assets/images/frontend-pages/alex.jpg" alt="leader" class="">
                            <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                <h4 class="fs-5 mb-8">Alex Martinez</h4>
                                <p class="fs-3 mb-0">CEO & Co-Founder</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="meet-our-team position-relative rounded-3 overflow-hidden">
                            <img src="../assets/images/frontend-pages/jordan.jpg" alt="leader" class="">
                            <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                <h4 class="fs-5 mb-2">Jordan Nguyen</h4>
                                <p class="fs-3 mb-0">CTO & Co-Founder</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="meet-our-team position-relative rounded-3 overflow-hidden">
                            <img src="../assets/images/frontend-pages/taylor.jpg" alt="leader" class="">
                            <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                <h4 class="fs-5 mb-2">Taylor Roberts</h4>
                                <p class="fs-3 mb-0">Product Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="meet-our-team position-relative rounded-3 overflow-hidden">
                            <img src="../assets/images/frontend-pages/morgan.jpg" alt="leader" class="">
                            <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                <h4 class="fs-5 mb-2">Morgan Patel</h4>
                                <p class="fs-3 mb-0">Lead Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ------------------------------------- -->
        <!-- Team End -->
        <!-- ------------------------------------- -->



        <!-- ------------------------------------- -->
        <!-- FAQ Start -->
        <!-- ------------------------------------- -->
        <section class="pb-lg-11 pb-5 mt-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="fs-15 fw-semibold mb-0 text-center mb-5 mb-md-12">
                            Frequently asked questions
                        </h2>
                        <div class="accordion faq-accordion" id="accordionExample1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fs-5" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        What is included with my purchase?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                            commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum
                                            dolore
                                            eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                            sunt in
                                            culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fs-5" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Can I customize the admin dashboard template to match my brand?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                            commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum
                                            dolore
                                            eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                            sunt in
                                            culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fs-5" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Are there any restrictions on using the template?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                            commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum
                                            dolore
                                            eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                            sunt in
                                            culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fs-5" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        How can I get support after purchase?
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                            commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum
                                            dolore
                                            eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                            sunt in
                                            culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- ------------------------------------- -->
    <!-- Footer Start -->
    <!-- ------------------------------------- -->
    <footer class="bg-dark">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-md-nowrap flex-wrap py-13 border-top border-dark-subtle">
                <div class="d-flex align-items-center gap-3">
                    <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-icon.svg"
                        alt="logo" width="30">
                    <p class="text-white opacity-50 mb-0">All rights reserved by MaterialPro. </p>
                </div>
                <div class="col-md-3 col-6 mb-7 mb-md-0">
                    <h3 class="fs-4 text-white fw-semibold mb-7">Follow us</h3>
                    <div class="d-flex gap-9">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-title="Facebook">
                            <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/frontend-pages/icon-facebook.svg"
                                alt="facebook">
                        </a>
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-title="Twitter">
                            <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/frontend-pages/icon-twitter.svg"
                                alt="twitter">
                        </a>
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-title="Instagram">
                            <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/frontend-pages/icon-instagram.svg"
                                alt="instagram">
                        </a>
                    </div>
                </div>
                <div>
                    <p class="text-white mb-0">
                        <span class="opacity-50">Produced by</span>
                        <a href="https://www.wrappixel.com/" class="text-white link-primary">Wrappixel</a>.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ------------------------------------- -->
    <!-- Footer End -->
    <!-- ------------------------------------- -->

    <!-- Scroll Top -->
    <a href="javascript:void(0)"
        class="top-btn btn btn-primary d-flex align-items-center justify-content-center round-54 p-0 rounded-circle">
        <i class="ti ti-arrow-up fs-7"></i>
    </a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Jika pakai Bootstrap modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/vendor.min.js"></script>
    <!-- Import Js Files -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../assets/js/theme/app.init.js"></script>
    <script src="../assets/js/theme/theme.js"></script>
    <script src="../assets/js/theme/app.min.js"></script>
    <script src="../assets/js/theme/feather.min.js"></script>

    <!-- solar icons -->
    <script src="../../../../cdn.jsdelivr.net/npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
    <script src="../assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="../assets/js/frontend-landingpage/homepage.js"></script>
</body>


<!-- Mirrored from bootstrapdemos.wrappixel.com/materialpro/dist/main/frontend-landingpage.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 May 2025 04:46:24 GMT -->

</html>
