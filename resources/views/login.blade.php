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
                <img src="assets/images/uniba.png" alt="loader" class="dark-logo lds-ripple img-fluid"
                    style="width: 70px;" />
                <!-- Light Logo icon -->
                <img src="assets/images/uniba.png" alt="loader" class="light-logo lds-ripple img-fluid"
                    style="width: 70px;" />
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
                        <img src="assets/images/logo-uniba.jpg" alt="homepage" class="dark-logo w-50" />
                        <!-- Light Logo icon -->
                        <img src="assets/images/logo-uniba.jpg" alt="homepage" class="light-logo w-50" />
                    </b>
                    <!--End Logo icon -->
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
                                        <h5 class="fw-semibold mb-9 fs-5">
                                            Silakan masukkan nama Anda
                                        </h5>
                                        <form id="nameForm">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="nama"
                                                    placeholder="Masukkan Nama">
                                                <button class="btn btn-primary" type="submit">Cari</button>
                                            </div>
                                            <div id="nameError" class="text-danger small mt-1"></div>
                                            <!-- Untuk menampilkan error -->
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
                            <div id="passwordError" class="text-danger small mt-1"></div>
                            <!-- Pesan error tampil di sini -->
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
                        const errorDiv = document.getElementById('nameError');
                        errorDiv.textContent = ''; // Clear error setiap submit

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
                                    errorDiv.textContent = '';
                                    passwordForm.dataset.userId = data.user_id;
                                    new bootstrap.Modal(document.getElementById('login-modal')).show();
                                } else {
                                    errorDiv.textContent = data.message || 'Nama tidak ditemukan';
                                }
                            });
                    });
                }
                if (passwordForm) {
                    passwordForm.addEventListener('submit', function(e) {
                        e.preventDefault(); // mencegah reload

                        const password = document.getElementById('userPassword').value;
                        const userId = this.dataset.userId;
                        const passwordError = document.getElementById('passwordError');
                        passwordError.textContent = ''; // Bersihkan error sebelumnya

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
                                    passwordError.textContent = '';
                                    window.location.href = data.redirect;
                                } else {
                                    if (data.redirect) {
                                        window.location.href = data.redirect; // Redirect setelah 3x gagal
                                    } else {
                                        passwordError.textContent = data.message || "Password salah";
                                    }
                                }
                            })
                            .catch(error => {
                                console.error("Login error:", error);
                                passwordError.textContent = "Terjadi kesalahan saat login.";
                            });
                    });
                }


                // Password form tetap sama
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
                            Paling Sering Ditanyakan
                        </h2>
                        <div class="accordion faq-accordion" id="accordionExample1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fs-5" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Bagaimana cara mengajukan surat pengantar magang atau skripsi melalui website
                                        ini?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Silakan login menggunakan akun yang telah terdaftar, lalu pilih menu
                                            <strong>Pengajuan Surat</strong>.
                                            Setelah itu, isi formulir pengajuan sesuai kebutuhan (magang atau skripsi),
                                            dan unggah dokumen pendukung jika diperlukan.
                                            Setelah semua data terisi lengkap, klik tombol <strong>Kirim
                                                Pengajuan</strong> untuk memproses permintaan Anda.
                                        </p>
                                        <p>
                                            Untuk pengajuan skripsi, silakan <a href="form skripsi.doc"
                                                target="_blank">unduh formulir pengajuan skripsi</a> dan lengkapi
                                            sesuai petunjuk sebelum mengajukan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fs-5" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Berapa lama proses verifikasi pengajuan oleh dosen atau admin?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Proses verifikasi biasanya memakan waktu 1–3 hari kerja. Anda akan menerima
                                            notifikasi melalui sistem jika pengajuan telah disetujui atau ditolak.
                                            Silakan cek status pengajuan secara berkala di halaman dashboard Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fs-5" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Apa yang harus saya lakukan jika pengajuan saya ditolak?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Jika pengajuan Anda ditolak, sistem akan menampilkan alasan penolakan.
                                            Silakan perbaiki data atau dokumen yang diminta, lalu lakukan pengajuan
                                            ulang dengan mengikuti petunjuk yang diberikan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fs-5" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        Di mana saya bisa mengunduh surat pengantar yang sudah disetujui?
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <p>
                                            Setelah pengajuan disetujui oleh dosen dan admin, surat pengantar akan
                                            tersedia di menu Detail Pengajuan. Anda dapat mengunduh file surat tersebut
                                            dalam format PDF langsung dari halaman tersebut.
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
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 border-top border-dark-subtle">
                <!-- Logo & Hak Cipta -->
                <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
                    <img src="assets/images/uniba.png" class="img-fluid rounded-circle" alt="logo"
                        width="30" height="30">
                    <p class="text-white opacity-75 mb-0">© All rights reserved by <a href="https://unibamadura.ac.id/page" class="text-white">UNIBA</a></p>
                </div>

                <!-- Ikon Sosial Media -->
                <div class="d-flex gap-3">
                    <!-- YouTube -->
                    <a href="https://youtube.com" target="_blank" data-bs-toggle="tooltip" data-bs-title="YouTube">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/youtube-play.png" alt="YouTube"
                            width="24" height="24">
                    </a>

                    <!-- Twitter (ubah ke versi putih) -->
                    <a href="https://twitter.com" target="_blank" data-bs-toggle="tooltip" data-bs-title="Twitter">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/twitter--v1.png" alt="Twitter"
                            width="24" height="24">
                    </a>

                    <!-- Instagram (ubah ke versi putih) -->
                    <a href="https://instagram.com" target="_blank" data-bs-toggle="tooltip"
                        data-bs-title="Instagram">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png" alt="Instagram"
                            width="24" height="24">
                    </a>

                    <!-- Website -->
                    <a href="https://mywebsite-friemz.turbo-main.com/" target="_blank" data-bs-toggle="tooltip"
                        data-bs-title="Website">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/domain.png" alt="Website"
                            width="24" height="24">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ------------------------------------- -->
    <!-- Footer End -->
    <!-- ------------------------------------- -->

    <!-- Scroll Top -->
    <a href="" class="top-btn btn d-flex align-items-center justify-content-center round-54 p-0 rounded-circle"
        style="z-index: -3;">
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
