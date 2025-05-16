  <!-- Sidebar Start -->
  <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
          <!-- Start Vertical Layout Sidebar -->
          <!-- ---------------------------------- -->
          <!-- Sidebar scroll-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar>
              <!-----------Profile------------------>
              <div class="user-profile position-relative"
                  style="background: url(../assets/images/backgrounds/user-info.jpg) no-repeat;">
                  <!-- User profile image -->
                  <div class="profile-img">
                      <img src="{{ asset(Auth::user()->foto) }}" class="rounded-circle round-50" alt="User Profile" />

                  </div>
                  <!-- User profile text-->
                  <div class="profile-text hide-menu pt-1 dropdown">
                      <a href=""
                          class=" u-dropdown w-100 text-white
                  d-block
                  position-relative
                "
                          id="dropdownMenuLink" aria-expanded="false"> {{ Auth::user()->nama }}</a>

                  </div>
              </div>
              <!-----------Profile End------------------>

              <ul id="sidebarnav">
                  <!-- Menu Utama -->
                  <li class="nav-small-cap">
                      <iconify-icon icon="solar:menu-dots-bold" class="nav-small-cap-icon fs-4"></iconify-icon>
                      <span class="hide-menu">Menu Utama</span>
                  </li>

                  <li class="sidebar-item">
                      <a class="sidebar-link" href="/dashboard">
                          <iconify-icon icon="solar:box-minimalistic-linear" class="aside-icon"></iconify-icon>
                          <span class="hide-menu">Dashboard</span>
                      </a>
                  </li>

                  @if (auth()->user()->role === 'mahasiswa')
                      <li class="sidebar-item">
                          <a class="sidebar-link" href="/pengajuan">
                              <iconify-icon icon="solar:document-add-line-duotone" class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Pengajuan Surat</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link" href="pengajuan-surat.html">
                              <iconify-icon icon="solar:document-add-line-duotone" class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Detail Pengajuan</span>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->role === 'admin')
                      <li class="sidebar-item">
                          <a class="sidebar-link" href="/verifikasi">
                              <iconify-icon icon="solar:checklist-linear" class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Verifikasi Surat</span>
                          </a>
                      </li>

                      <!-- Data Master -->
                      <li class="nav-small-cap mt-3">
                          <iconify-icon icon="solar:database-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                          <span class="hide-menu">Data Master</span>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link" href="/users">
                              <iconify-icon icon="solar:users-group-two-rounded-linear"
                                  class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Manajemen User</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a class="sidebar-link" href="/mahasiswas">
                              <iconify-icon icon="solar:users-group-rounded-linear" class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Data Mahasiswa</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link" href="/dosens">
                              <iconify-icon icon="solar:buildings-2-linear" class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Data Dosen</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link" href="/job">
                              <iconify-icon icon="solar:buildings-2-linear" class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Data Job</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link" href="/jurusans">
                              <iconify-icon icon="solar:structure-linear" class="aside-icon"></iconify-icon>
                              <span class="hide-menu">Data Jurusan</span>
                          </a>
                      </li>
                      <hr>
                  @endif
                  <!-- Logout -->
                  <li class="sidebar-item mt-0">
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                      <a class="sidebar-link" href="#"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <iconify-icon icon="solar:logout-linear" class="aside-icon"></iconify-icon>
                          <span class="hide-menu">Keluar</span>
                      </a>
                  </li>
              </ul>

          </nav>

          <!-- End Sidebar scroll-->
      </div>
  </aside>
  <!--  Sidebar End -->
