<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="d-flex m-0 justify-content-center text-wrap" href="{{ route('home') }}">
            <img height="60" class="logo-site" src="{{ asset('assets/images/logo/logo-site.png') }}" alt="logo-site">
        </a>
    </div>
    <hr class="horizontal dark mt-0">

    <div class="docs-info">
        <a href="{{ route('home') }}" class="btn btn-white btn-sm w-100 mb-0">Trang chủ</a>
    </div>

    <div class="collapse navbar-collapse  w-auto mt-2" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bảng điều khiển</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Chức năng</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.tickets.*') ? 'active' : '' }}"
                    href="{{ route('admin.tickets.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-ticket text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Vé tàu</span>
                </a>
            </li>



            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.schedules.*') ? 'active' : '' }}"
                    href="{{ route('admin.schedules.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-clock text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Lịch trình</span>
                </a>
            </li>



            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('admin.trains.*', 'admin.seat-classes.*','admin.train-seat-classes.*') ? 'active' : '' }}"
                    href="#" id="TrainDropdown" role="button" data-bs-toggle="collapse"
                    data-bs-target="#train-management" aria-expanded="false">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-train text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý tàu</span>
                </a>
                <div class="collapse mt-1" id="train-management" style="margin-left: 30px">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.trains.*') ? 'active' : '' }}"
                                href="{{ route('admin.trains.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-train text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Tàu</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.seat-classes.*') ? 'active' : '' }}"
                                href="{{ route('admin.seat-classes.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-chair text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Hạng ghế</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('admin.routes.*', 'admin.stations.*') ? 'active' : '' }}"
                    href="#" id="RouteDropdown" role="button" data-bs-toggle="collapse"
                    data-bs-target="#route-management" aria-expanded="false">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-route text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý tuyến đường</span>
                </a>
                <div class="collapse mt-1" id="route-management" style="margin-left: 30px">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.routes.*') ? 'active' : '' }}"
                                href="{{ route('admin.routes.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-route text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Tuyến đường</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.stations.*') ? 'active' : '' }}"
                                href="{{ route('admin.stations.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-train text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Ga tàu</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('admin.countries.*', 'admin.administrative-units.*') ? 'active' : '' }}"
                    href="#" id="UnitDropdown" role="button" data-bs-toggle="collapse"
                    data-bs-target="#unit-management" aria-expanded="false">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-flag text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý đơn vị</span>
                </a>
                <div class="collapse mt-1" id="unit-management" style="margin-left: 30px">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.countries.*') ? 'active' : '' }}"
                                href="{{ route('admin.countries.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-flag text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Quốc gia</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.administrative-units.*') ? 'active' : '' }}"
                                href="{{ route('admin.administrative-units.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-building text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Đơn vị</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Nội dung</h6>
            </li>

            <!-- FAQ Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('admin.faq-categories.*', 'admin.faqs.*') ? 'active' : '' }}"
                    href="#" id="faqDropdown" role="button" data-bs-toggle="collapse"
                    data-bs-target="#faq-management" aria-expanded="false">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-folder text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý FAQ</span>
                </a>
                <div class="collapse mt-1" id="faq-management" style="margin-left: 30px">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.faq-categories.*') ? 'active' : '' }}"
                                href="{{ route('admin.faq-categories.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-folder text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Danh mục FAQ</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.faqs.*') ? 'active' : '' }}"
                                href="{{ route('admin.faqs.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-circle-question text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Câu hỏi thường gặp</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.blogs.*') ? 'active' : '' }}"
                    href="{{ route('admin.blogs.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-message text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bài viết</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.about-us.*') ? 'active' : '' }}"
                    href="{{ route('admin.about-us.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-info-circle text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">About Us</span>
                </a>
            </li>




            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Hệ thống</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.socials.*') ? 'active' : '' }}"
                    href="{{ route('admin.socials.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-globe text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Mạng xã hội</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.banner-home.*') ? 'active' : '' }}"
                    href="{{ route('admin.banner-home.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-image text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Banner</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.users.index') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Danh sách tài khoản</span>
                </a>
            </li>



            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Cài đặt</h6>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.languages.*') ? 'active' : '' }}"
                    href="{{ route('admin.languages.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-language text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý ngôn ngữ</span>
                </a>
            </li> --}}



            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('admin.smtp-settings.edit') ? 'active' : '' }}"
                    href="{{ route('admin.smtp-settings.edit') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-envelope text-dark icon-sidebar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Cài đặt email</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-right-from-bracket text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">Đăng xuất</span>
                </a>
            </li>
        </ul>
    </div>

</aside>
