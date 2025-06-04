@extends('template.temp')
@section('content')
    <!-- Content -->
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">

            @if (auth()->user()->role === 'mahasiswa')
                <!-- Profile card -->
                <div class="col-lg-5 col-xl-12">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body p-2">
                            <img class="card-img-top w-100 profile-bg-height rounded overflow-hidden"
                                src="../assets/images/backgrounds/profile-bg.jpg" height="111" alt="Card image cap" />
                            <div class="card-body little-profile text-center p-9">
                                <div class="pro-img">
                                    <img src="../assets/images/profile/user-2.jpg" alt="user"
                                        class="rounded-circle shadow-sm" width="112" />
                                </div>
                                <h3 class="mb-1 ">Angela Dominic</h3>
                                <p class="fs-3">Web Designer &amp; Developer</p>
                                <a href="javascript:void(0)"
                                    class="
                        waves-effect waves-dark
                        btn btn-primary btn-md btn-rounded mb-4
                      ">Follow</a>
                                <div class="row gx-lg-4 text-center pt-9 justify-content-center border-top">
                                    <div class="col-4">
                                        <h3 class="mb-0 ">1099</h3>
                                        <small class="text-muted fs-3">Articles</small>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="mb-0 ">23,469</h3>
                                        <small class="text-muted fs-3">Followers</small>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="mb-0 ">6035</h3>
                                        <small class="text-muted fs-3">Following</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="card text-bg-dark text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-ethereum display-6 text-white" title="ETH"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Ethereum
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$3589.00k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="card text-bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-dogecoin display-6 text-white" title="LTC"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Dash
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$900.00k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->role === 'dosen')
                <div class="col-12 col-lg-5 col-xl-12">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body pb-0">
                            <h4 class="card-title">My Contacts</h4>
                            <p class="card-subtitle mb-0">
                                Checkout my contacts here
                            </p>
                        </div>
                        <div class="message-box contact-box position-relative">
                            <div class="message-widget contact-widget position-relative">
                                <!-- contact -->
                                <a href="javascript:void(0)" class="py-4 hstack px-7 gap-3">
                                    <div class="user-img position-relative">
                                        <img src="../assets/images/profile/user-2.jpg" alt="user"
                                            class="rounded-circle w-100" />
                                        <span
                                            class="
                            profile-status
                            pull-right
                            d-inline-block
                            position-absolute
                            text-bg-secondary
                            rounded-circle
                          "></span>
                                    </div>
                                    <div class="v-middle d-md-flex align-items-center w-100">
                                        <div class="text-truncate">
                                            <h5 class="mb-1 text-dark font-weight-medium">
                                                James Smith
                                            </h5>
                                            <span class="text-muted fs-3">you were in video call</span>
                                        </div>
                                        <div class="ms-auto d-flex button-group gap-1">
                                            <button type="button" href="javascript:void(0)"
                                                class="btn btn-sm bg-danger-subtle text-danger round-sm rounded-pill m-0">
                                                <i data-feather="video" class="feather-sm"></i>
                                            </button>
                                            <button type="button" href="javascript:void(0)"
                                                class="btn btn-sm bg-primary-subtle text-primary round-sm rounded-pill m-0">
                                                <i data-feather="phone-incoming" class="feather-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                <!-- contact -->
                                <a href="javascript:void(0)" class="py-4 hstack px-7 gap-3">
                                    <div class="user-img position-relative">
                                        <img src="../assets/images/profile/user-6.jpg" alt="user"
                                            class="rounded-circle w-100" />
                                        <span
                                            class="
                            profile-status
                            pull-right
                            d-inline-block
                            position-absolute
                            text-bg-light-indigo
                            rounded-circle
                          "></span>
                                    </div>
                                    <div class="v-middle d-md-flex align-items-center w-100">
                                        <div class="text-truncate">
                                            <h5 class="mb-1 text-dark font-weight-medium">
                                                Joseph Garciar
                                            </h5>
                                            <span class="text-muted fs-3">you were in video call</span>
                                        </div>
                                        <div class="ms-auto d-flex button-group gap-1">
                                            <button type="button" href="javascript:void(0)"
                                                class="btn btn-sm bg-danger-subtle text-danger round-sm rounded-pill m-0">
                                                <i data-feather="video" class="feather-sm"></i>
                                            </button>
                                            <button type="button" href="javascript:void(0)"
                                                class="btn btn-sm bg-primary-subtle text-primary round-sm rounded-pill m-0">
                                                <i data-feather="phone-incoming" class="feather-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                <!-- contact -->
                                <a href="javascript:void(0)" class="py-4 pb-7 hstack px-7 gap-8">
                                    <div class="user-img position-relative">
                                        <img src="../assets/images/profile/user-3.jpg" alt="user"
                                            class="rounded-circle w-100" />
                                        <span
                                            class="
                            profile-status
                            pull-right
                            d-inline-block
                            position-absolute
                            text-bg-light-indigo
                            rounded-circle
                          "></span>
                                    </div>
                                    <div class="v-middle d-md-flex align-items-center w-100">
                                        <div class="text-truncate">
                                            <h5 class="mb-1 text-dark font-weight-medium">
                                                Maria Rodriguez
                                            </h5>
                                            <span class="text-muted fs-3">you missed john call</span>
                                        </div>
                                        <div class="ms-auto d-flex button-group gap-1">
                                            <button type="button" href="javascript:void(0)"
                                                class="btn btn-sm bg-danger-subtle text-danger round-sm rounded-pill m-0">
                                                <i data-feather="video" class="feather-sm"></i>
                                            </button>
                                            <button type="button" href="javascript:void(0)"
                                                class="btn btn-sm bg-primary-subtle text-primary round-sm rounded-pill m-0">
                                                <i data-feather="phone-incoming" class="feather-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->role === 'admin')
                <div class="col-lg-3 col-6">
                    <div class="card text-bg-dark text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-ethereum display-6 text-white" title="ETH"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Ethereum
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$3589.00k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card text-bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-dogecoin display-6 text-white" title="LTC"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Dash
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$900.00k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card text-bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-bitcoin display-6 text-white" title="BTC"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Bitcoin
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$284.50k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card text-bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-ripple display-6 text-white" title="AMP"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Ripple
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$650.80k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Profile card -->
                <div class="col-lg-5 col-xl-12">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body p-2">
                            <img class="card-img-top w-100 profile-bg-height rounded overflow-hidden"
                                src="../assets/images/backgrounds/profile-bg.jpg" height="111" alt="Card image cap" />
                            <div class="card-body little-profile text-center p-9">
                                <div class="pro-img">
                                    <img src="../assets/images/profile/user-2.jpg" alt="user"
                                        class="rounded-circle shadow-sm" width="112" />
                                </div>
                                <h3 class="mb-1 ">Angela Dominic</h3>
                                <p class="fs-3">Web Designer &amp; Developer</p>
                                <a href="javascript:void(0)"
                                    class="
                        waves-effect waves-dark
                        btn btn-primary btn-md btn-rounded mb-4
                      ">Follow</a>
                                <div class="row gx-lg-4 text-center pt-9 justify-content-center border-top">
                                    <div class="col-4">
                                        <h3 class="mb-0 ">1099</h3>
                                        <small class="text-muted fs-3">Articles</small>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="mb-0 ">23,469</h3>
                                        <small class="text-muted fs-3">Followers</small>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="mb-0 ">6035</h3>
                                        <small class="text-muted fs-3">Following</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- / Content -->
@endsection
