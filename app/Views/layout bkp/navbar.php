<!--begin::Navbar-->
<div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
    <div class="app-navbar-item d-flex align-items-center flex-lg-grow-1">

        <!--begin::Search-->
        <span class="text-gray-900 fw-bolder fs-2x lh-1 d-none d-lg-block">
            <?= esc($title) ?>
        </span>
        <!--end::Search-->
    </div>

    <!--begin::User menu-->
    <div class="app-navbar-item ms-5" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-30px symbol-md-35px"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <!-- <img class="symbol symbol-30px symbol-md-35px" src="/assets/media/avatars/300-3.jpg" alt="user" /> -->
             <?php if (!empty(user()->image)): ?>
                <?php
                // Display the user's avatar image, name, and islander number
                echo '<img src="' . base_url('assets/media/users/' . user()->image) . '" class="me-2 rounded align-self-start" width="100" height="100" style="max-width: 100px; max-height: 100px; object-fit: cover;">';
                ?>
            <?php else: ?>
                <?php
                // Display the user's initials, name, and islander number
                echo '<img src="' . 'https://ui-avatars.com/api/?name=' . user()->full_name .  '&background=d9dbe1&color=f4f4f4&font-size=.5">';
                ?>
            <?php endif; ?>
        </div>

        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <!-- <img alt="Logo" src="/assets/media/avatars/300-3.jpg" /> -->
                        <?php if (!empty(user()->image)): ?>
                            <?php
                            // Display the user's avatar image, name, and islander number
                            echo '<img src="' . base_url('assets/media/users/' . user()->image) . '" class="me-2 rounded align-self-start" width="100" height="100" style="max-width: 100px; max-height: 100px; object-fit: cover;">';
                            ?>
                        <?php else: ?>
                            <?php
                            // Display the user's initials, name, and islander number
                            echo '<img src="' . 'https://ui-avatars.com/api/?name=' . user()->full_name .  '&background=f4f4f4&color=9ba1b6&font-size=.5">';
                            ?>
                        <?php endif; ?>
                    </div>
                    <!--end::Avatar-->

                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">
                            <?= user()->full_name ?>
                        </div>

                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                            <?= user()->email ?> </a>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="/Profile" class="menu-link px-5">
                    Profile
                </a>
            </div>
            <!--end::Menu item-->



            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">
                        Mode

                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                            <i class="ki-duotone ki-night-day theme-light-show fs-2"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                    class="path5"></span><span class="path6"></span><span class="path7"></span><span
                                    class="path8"></span><span class="path9"></span><span class="path10"></span></i> <i
                                class="ki-duotone ki-moon theme-dark-show fs-2"><span class="path1"></span><span
                                    class="path2"></span></i> </span>
                    </span>
                </a>

                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-night-day fs-2"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span><span class="path6"></span><span class="path7"></span><span
                                        class="path8"></span><span class="path9"></span><span class="path10"></span></i>
                            </span>
                            <span class="menu-title">
                                Light
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-moon fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> </span>
                            <span class="menu-title">
                                Dark
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-screen fs-2"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                            </span>
                            <span class="menu-title">
                                System
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->

            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">
                        Language

                        <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                            English <img class="w-15px h-15px rounded-1 ms-2"
                                src="/assets/media/flags/united-states.svg" alt="" />
                        </span>
                    </span>
                </a>

                <!--begin::Menu sub-->
                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="/bold-html-pro/account/settings.html" class="menu-link d-flex px-5 active">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="/assets/media/flags/united-states.svg" alt="" />
                            </span>
                            English
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="/bold-html-pro/account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="/assets/media/flags/spain.svg" alt="" />
                            </span>
                            Spanish
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="/bold-html-pro/account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="/assets/media/flags/germany.svg" alt="" />
                            </span>
                            German
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="/bold-html-pro/account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="/assets/media/flags/japan.svg" alt="" />
                            </span>
                            Japanese
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="/bold-html-pro/account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="/assets/media/flags/france.svg" alt="" />
                            </span>
                            French
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu sub-->
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="/logout" class="menu-link px-5">
                    Sign Out
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->

        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->

    <!--begin::Header menu toggle-->
    <!--end::Header menu toggle-->
</div>
<!--end::Navbar-->