<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('template.style')

    <title>MaterialPro Template by WrapPixel</title>
</head>

<body>
    @if (session('show_toast') || session('ferguso'))
        <div class="toast toast-onload align-items-center text-bg-{{ session('ferguso') ? 'danger' : 'secondary' }} border-0 show"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body hstack align-items-start gap-6">
                <div>
                    @if (session('ferguso'))
                        <h5 class="text-white fs-3 mb-1">
                            {{ session('ferguso') }}
                        </h5>
                    @else
                        <h5 class="text-white fs-3 mb-1">
                            Selamat datang, {{ Auth::user()->nama ?? 'Pengguna' }} 🎉
                        </h5>
                        <h6 class="text-white fs-2 mb-0">PENGAJUAN SURAT CEPAT!!!</h6>
                    @endif
                </div>
                <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none"
                    data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.querySelector('.toast')?.classList.remove('show');
            }, 3000);
        </script>
    @endif




    <!-- Preloader -->
    <div class="preloader">
        <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-icon.svg"
            alt="loader" class="lds-ripple img-fluid" />
    </div>


    <div id="main-wrapper">
        @include('template.layout.sideverti')
        <div class="page-wrapper">
            @include('template.layout.header')


            <div class="body-wrapper">
                @yield('content')
            </div>
            @include('template.layout.footer')
        </div>

    </div>
    <div class="dark-transparent sidebartoggler"></div>

    @include('template.script')
</body>


<!-- Mirrored from bootstrapdemos.wrappixel.com/materialpro/dist/main/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 May 2025 04:45:57 GMT -->

</html>
