 <!--  Header Start -->
 <header class="topbar rounded-0 border-0 bg-primary">
     <div class="with-vertical"><!-- ---------------------------------- -->
         <!-- Start Vertical Layout Header -->
         <!-- ---------------------------------- -->
         <nav class="navbar navbar-expand-lg px-lg-0 px-3 py-0">
             <div class="d-none d-lg-block">
                 <div class="brand-logo d-flex align-items-center justify-content-between">
                     <a href="index.html" class="text-nowrap logo-img d-flex align-items-center gap-2">
                         <b class="logo-icon">
                             <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                             <!-- Dark Logo icon -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-icon.svg"
                                 alt="homepage" class="dark-logo" />
                             <!-- Light Logo icon -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-icon.svg"
                                 alt="homepage" class="light-logo" />
                         </b>
                         <!--End Logo icon -->
                         <!-- Logo text -->
                         <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-text.svg"
                                 alt="homepage" class="dark-logo ps-2" />
                             <!-- Light Logo text -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-text.svg"
                                 class="light-logo ps-2" alt="homepage" />
                         </span>
                     </a>
                 </div>
             </div>

             <ul class="navbar-nav gap-2">

                 <li class="nav-item nav-icon-hover-bg rounded-circle">
                     <a class="nav-link nav-icon-hover sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                         <iconify-icon icon="solar:list-bold"></iconify-icon>
                     </a>
                 </li>

             </ul>

             <div class="d-block d-lg-none">
                 <div class="brand-logo d-flex align-items-center justify-content-between">
                     <a href="index.html" class="text-nowrap logo-img d-flex align-items-center gap-2">
                         <b class="logo-icon">
                             <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                             <!-- Dark Logo icon -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-icon.svg"
                                 alt="homepage" class="dark-logo" />
                             <!-- Light Logo icon -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-icon.svg"
                                 alt="homepage" class="light-logo" />
                         </b>
                         <!--End Logo icon -->
                         <!-- Logo text -->
                         <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-text.svg"
                                 alt="homepage" class="dark-logo ps-2" />
                             <!-- Light Logo text -->
                             <img src="https://bootstrapdemos.wrappixel.com/materialpro/dist/assets/images/logos/logo-light-text.svg"
                                 class="light-logo ps-2" alt="homepage" />
                         </span>
                     </a>
                 </div>
             </div>
             <ul class="navbar-nav flex-row  gap-2 align-items-center justify-content-center d-flex d-lg-none">
                 <li class="nav-item dropdown nav-icon-hover-bg rounded-circle">
                     <a class="navbar-toggler nav-link text-white nav-icon-hover border-0" href="javascript:void(0)"
                         data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                         aria-expanded="false" aria-label="Toggle navigation">
                         <span class="">
                             <iconify-icon icon="solar:widget-4-linear" class="aside-icon"></iconify-icon>
                         </span>
                     </a>
                 </li>
             </ul>
             <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                 <div class="d-flex align-items-center justify-content-between py-2 py-lg-0">
                     <ul class="navbar-nav gap-2 flex-row ms-auto align-items-center justify-content-center">

                         <li class="nav-item nav-icon-hover-bg rounded-circle">
                             <a class="nav-link nav-icon-hover moon dark-layout" href="javascript:void(0)">
                                 <iconify-icon icon="solar:moon-line-duotone" class="moon"></iconify-icon>
                             </a>
                             <a class="nav-link nav-icon-hover sun light-layout" href="javascript:void(0)">
                                 <iconify-icon icon="solar:sun-2-line-duotone" class="sun"></iconify-icon>
                             </a>
                         </li>

                         <!-- ------------------------------- -->
                         <!-- end notification Dropdown -->
                         <!-- ------------------------------- -->

                         <!-- ------------------------------- -->
                         <!-- start profile Dropdown -->
                         <!-- ------------------------------- -->
                         <li class="nav-item hover-dd dropdown">
                             <a class="nav-link nav-icon-hover  dropdown-toggle" href="javascript:void(0)"
                                 id="drop2" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                                 <img src="{{ asset(Auth::user()->foto) }}" class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;" alt="User Profile" />

                             </a>
                             <div class="dropdown-menu pt-0 content-dd overflow-hidden pt-0 dropdown-menu-end user-dd"
                                 aria-labelledby="drop2">
                                 <div class="profile-dropdown position-relative" data-simplebar>
                                     <div class=" py-3 border-bottom">
                                         <div class="d-flex align-items-center px-3">
                                             <img src="{{ asset(Auth::user()->foto) }}" class="rounded-circle round-50"
                                                 alt="User Profile" />
                                             <div class="ms-3">
                                                 <h5 class="mb-1 fs-4"> {{ Auth::user()->nama }}</h5>
                                                 <p class="mb-0 fs-2 d-flex align-items-center text-muted">
                                                     {{ Auth::user()->email }}
                                                 </p>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="message-body pb-3">

                                         <div class="px-3">
                                             @if (Auth::user()->role === 'dosen')
                                                 <div class="ms-3">
                                                     <div class="mt-3 d-flex align-items-center gap-2">
                                                         @if (Auth::user()->dosen && Auth::user()->dosen->ttd_path)
                                                             <img src="{{ asset(Auth::user()->dosen->ttd_path) }}"
                                                                 alt="Tanda Tangan" width="100" class="mb-2" />
                                                         @else
                                                             <p class="text-muted mb-0">Tanda tangan belum ada</p>
                                                         @endif

                                                         <form
                                                             action="{{ route('dosen.updateTtd', Auth::user()->dosen->id ?? 0) }}"
                                                             method="POST" enctype="multipart/form-data"
                                                             class="d-flex align-items-center gap-2 mb-0">
                                                             @csrf
                                                             @method('PUT')

                                                             <input type="file" name="ttd_path" accept="image/*"
                                                                 required class="form-control form-control-sm"
                                                                 style="max-width: 180px;" />
                                                             <button type="submit"
                                                                 class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                                                                 <iconify-icon icon="mdi:upload" width="18"
                                                                     height="18"></iconify-icon>
                                                                 Upload
                                                             </button>
                                                         </form>
                                                     </div>

                                                 </div>
                                             @endif

                                             <div class="h6 mb-0 dropdown-item py-8 px-3 rounded-2 link">
                                                 <a href="#"
                                                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                     <iconify-icon icon="mdi:logout" class="me-1"></iconify-icon>
                                                     Logout
                                                 </a>

                                                 <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                     class="d-none">
                                                     @csrf
                                                 </form>

                                             </div>
                                         </div>
                                     </div>

                                 </div>
                             </div>
                         </li>


                         <!-- ------------------------------- -->
                         <!-- end profile Dropdown -->
                         <!-- ------------------------------- -->
                     </ul>
                 </div>
             </div>
         </nav>
         <!-- ---------------------------------- -->
         <!-- End Vertical Layout Header -->
         <!-- ---------------------------------- -->
     </div>
 </header>
 <!--  Header End -->
