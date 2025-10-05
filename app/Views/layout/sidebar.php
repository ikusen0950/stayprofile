<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">


    <div class="app-sidebar-header d-flex flex-stack d-none d-lg-flex pt-8 pb-2 px-8" id="kt_app_sidebar_header">
        <!--begin::Logo-->
        <a href="/" class="app-sidebar-logo">
            <img alt="Logo" src="/assets/media/logos/default.svg"
                class="h-20px d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
            <img alt="Logo" src="/assets/media/logos/default-dark.svg" class="h-20px theme-dark-show" />
        </a>
        <!--end::Logo-->

        <!--begin::Sidebar toggle-->
        <!-- <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-sm btn-icon btn-color-gray-600 btn-active-color-primary d-none d-lg-flex rotate "
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">

            <i class="ki-duotone ki-exit-left fs-1 rotate-180 me-n4"><span class="path1"></span><span
                    class="path2"></span></i>
        </div> -->
        <!--end::Sidebar toggle-->
    </div>

    <!--begin::Navs-->
    <div class="app-sidebar-navs flex-column-fluid py-6" id="kt_app_sidebar_navs">
        <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_navs_scroll" class="hover-scroll-y mx-3 my-2" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-wrappers="#kt_app_sidebar_navs"
                data-kt-scroll-offset="5px">


                <!--begin::Sidebar menu-->
                <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                    class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary ps-6 pe-0">

                    <?php
                    // Helper function to check if menu item is active
                    function isMenuActive($routes) {
                        $currentUrl = current_url();
                        $baseUrl = base_url();
                        $uriString = uri_string();
                        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
                        
                        foreach ($routes as $route) {
                            if ($route === '/' || $route === 'dashboard') {
                                // Special handling for dashboard/home
                                if ($currentUrl == $baseUrl || 
                                    $currentUrl == $baseUrl . '/' ||
                                    $currentUrl == $baseUrl . 'dashboard' ||
                                    $uriString == '' ||
                                    $uriString == '/' ||
                                    $uriString == 'dashboard' ||
                                    $requestUri == '/' ||
                                    $requestUri == '/dashboard') {
                                    return true;
                                }
                            } else {
                                // For other routes
                                if (strpos($currentUrl, $route) !== false || 
                                    strpos($requestUri, $route) !== false) {
                                    return true;
                                }
                            }
                        }
                        return false;
                    }
                    ?>

                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/', 'dashboard']); ?>
                    <div data-kt-menu-trigger="click" class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <a href="/" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-setting-3 fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/feed']); ?>
                    <div data-kt-menu-trigger="click" class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <a href="/feed" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-element-12 fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">Feed</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/add_request', '/requests', '/authorizations']); ?>
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-some-files fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i></span>
                            <span class="menu-title">Requests</span>
                            <span class="menu-arrow"></span></span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive1 = isMenuActive(['/add_request']); ?>
                                <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>" href="/add_request"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Add Requests</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive2 = isMenuActive(['/requests']) && !isMenuActive(['/add_request']); ?>
                                <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>" href="/requests"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">All Requests</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive3 = isMenuActive(['/authorizations']); ?>
                                <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>" href="/authorizations"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Authorizations</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/users']); ?>
                    <div data-kt-menu-trigger="click" class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <a href="/users" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-profile-user fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Islanders</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/events']); ?>
                    <div data-kt-menu-trigger="click" class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <a href="/events" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-calendar fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </span>
                            <span class="menu-title">Events</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/policies']); ?>
                    <div data-kt-menu-trigger="click" class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <a href="/policies" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-document fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Policies</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/tickets']); ?>
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-save-2 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i></span>
                            <span class="menu-title">Tickets</span>
                            <span class="menu-arrow"></span></span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive1 = isMenuActive(['/tickets']); ?>
                                <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>" href="/tickets"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">All Tickets</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <?php $isActive = isMenuActive(['/todays_arrival', '/todays_departure', '/exit_request']); ?>
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-security-user fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i></span>
                            <span class="menu-title">Security</span>
                            <span class="menu-arrow"></span></span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive1 = isMenuActive(['/todays_departure']); ?>
                                <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>" href="/todays_departure"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Todays Departure</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive2 = isMenuActive(['/todays_arrival']) && !isMenuActive(['/todays_departure']); ?>
                                <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>" href="/todays_arrival"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Todays Arrival</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive3 = isMenuActive(['/exit_request']); ?>
                                <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>" href="/exit_request"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right"
                                    <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">All Exit Requests</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->







                    <!--begin:Menu item-->
                    <?php 
                    // Check permissions for system settings
                    $hasStatusAccess = has_permission('status.view');
                    $hasModulesAccess = has_permission('modules.view');
                    $hasLogsAccess = has_permission('logs.view');
                    $hasSystemAccess = $hasStatusAccess || $hasModulesAccess || $hasLogsAccess;
                    
                    // For Islander Settings, we'll assume admin/manager access for now
                    // You can add specific permissions for these later if needed
                    $hasIslanderAccess = has_permission('system.admin') || in_groups(['admin', 'manager']);
                    
                    // Check permissions for user management items
                    $hasUserManagementAccess = has_permission('users.view') || has_permission('sessions.view') || 
                                             has_permission('groups.view') || has_permission('permissions.view') || 
                                             in_groups(['admin', 'manager']);
                    
                    // Check if user has access to any settings
                    $hasAnySettingsAccess = $hasSystemAccess || $hasIslanderAccess || $hasUserManagementAccess;
                    
                    $isActive = isMenuActive(['/modules', '/status', '/logs', '/divisions', '/departments', '/sections', '/positions', '/genders', '/nationalities', '/houses', '/policy', '/islanders', '/visitors', '/sessions', '/requesting-sequence', '/authorizations-sequence', '/roles', '/group-permissions', '/user-permissions']) && $hasAnySettingsAccess;
                    ?>
                    <?php if ($hasAnySettingsAccess): ?>
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>" <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-icon">
                                <i class="ki-duotone ki-setting-2 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Settings</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item User Management-->
                            <?php 
                            // Check permissions for user management items
                            $hasUserManagementAccess = has_permission('users.view') || has_permission('sessions.view') || 
                                                     has_permission('groups.view') || has_permission('permissions.view') || 
                                                     in_groups(['admin', 'manager']);
                            $userMgmtActive = isMenuActive(['/islanders', '/visitors', '/sessions', '/requesting-sequence', '/authorizations-sequence', '/roles', '/group-permissions', '/user-permissions']) && $hasUserManagementAccess;
                            ?>
                            <?php if ($hasUserManagementAccess): ?>
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= $userMgmtActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link <?= $userMgmtActive ? 'active bg-dark' : '' ?>" <?= $userMgmtActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">User Management</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('users.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive1 = isMenuActive(['/islanders']); ?>
                                        <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>" href="/islanders" <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Islanders</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('visitors.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive2 = isMenuActive(['/visitors']); ?>
                                        <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>" href="/visitors" <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Visitors</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('sessions.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive3 = isMenuActive(['/sessions']); ?>
                                        <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>" href="/sessions" <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Sessions</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('sequence.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive4 = isMenuActive(['/requesting-sequence']); ?>
                                        <a class="menu-link <?= $subActive4 ? 'active bg-dark' : '' ?>" href="/requesting-sequence" <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Requesting Sequence</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('sequence.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive5 = isMenuActive(['/authorizations-sequence']); ?>
                                        <a class="menu-link <?= $subActive5 ? 'active bg-dark' : '' ?>" href="/authorizations-sequence" <?= $subActive5 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Authorizations Sequence</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('groups.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive6 = isMenuActive(['/roles']); ?>
                                        <a class="menu-link <?= $subActive6 ? 'active bg-dark' : '' ?>" href="/roles" <?= $subActive6 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Roles</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('permissions.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive7 = isMenuActive(['/group-permissions']); ?>
                                        <a class="menu-link <?= $subActive7 ? 'active bg-dark' : '' ?>" href="/group-permissions" <?= $subActive7 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Group Permissions</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('permissions.view') || $hasUserManagementAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive8 = isMenuActive(['/user-permissions']); ?>
                                        <a class="menu-link <?= $subActive8 ? 'active bg-dark' : '' ?>" href="/user-permissions" <?= $subActive8 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">User Permissions</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <?php endif; ?>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <?php 
                            $islanderActive = isMenuActive(['/divisions', '/departments', '/sections', '/positions', '/genders', '/nationalities', '/houses', '/policy']) && $hasIslanderAccess;
                            ?>
                            <?php if ($hasIslanderAccess): ?>
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= $islanderActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link <?= $islanderActive ? 'active bg-dark' : '' ?>" <?= $islanderActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Islander Settings</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('divisions.view') || $hasIslanderAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive1 = isMenuActive(['/divisions']); ?>
                                        <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>" href="/divisions" <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Division</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('departments.view') || $hasIslanderAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive2 = isMenuActive(['/departments']); ?>
                                        <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>" href="/departments" <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Department</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('sections.view') || $hasIslanderAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive3 = isMenuActive(['/sections']); ?>
                                        <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>" href="/sections" <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Section</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive4 = isMenuActive(['/positions']); ?>
                                        <a class="menu-link <?= $subActive4 ? 'active bg-dark' : '' ?>" href="/positions" <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Position</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive5 = isMenuActive(['/genders']); ?>
                                        <a class="menu-link <?= $subActive5 ? 'active bg-dark' : '' ?>" href="/genders" <?= $subActive5 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Gender</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive6 = isMenuActive(['/nationalities']); ?>
                                        <a class="menu-link <?= $subActive6 ? 'active bg-dark' : '' ?>" href="/nationalities" <?= $subActive6 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Nationality</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if (has_permission('houses.view') || $hasIslanderAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive7 = isMenuActive(['/houses']); ?>
                                        <a class="menu-link <?= $subActive7 ? 'active bg-dark' : '' ?>" href="/houses" <?= $subActive7 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Houses</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive8 = isMenuActive(['/policy']); ?>
                                        <a class="menu-link <?= $subActive8 ? 'active bg-dark' : '' ?>" href="/policy" <?= $subActive8 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Policy</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <?php endif; ?>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <?php 
                            // Check permissions for system settings items
                            $hasStatusAccess = has_permission('status.view');
                            $hasModulesAccess = has_permission('modules.view');
                            $hasLogsAccess = has_permission('logs.view');
                            $systemActive = isMenuActive(['/modules', '/status', '/logs']) && ($hasStatusAccess || $hasModulesAccess || $hasLogsAccess);
                            ?>
                            <?php if ($hasStatusAccess || $hasModulesAccess || $hasLogsAccess): ?>
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= $systemActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link <?= $systemActive ? 'active bg-dark' : '' ?>" <?= $systemActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">System Settings</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    <?php if ($hasStatusAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive1 = isMenuActive(['/status']); ?>
                                        <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>" href="/status" <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Status</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if ($hasModulesAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive2 = isMenuActive(['/modules']) && !isMenuActive(['/status']); ?>
                                        <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>" href="/modules" <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Module</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php if ($hasLogsAccess): ?>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <?php $subActive4 = isMenuActive(['/logs']); ?>
                                        <a class="menu-link <?= $subActive4 ? 'active bg-dark' : '' ?>" href="/logs" <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Logs</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <?php endif; ?>
                            <!--end:Menu item-->

                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <?php endif; ?>
                    <!--end:Menu item-->





                </div>
                <!--end::Sidebar menu-->
            </div>
        </div>
    </div>
    <!--end::Navs-->


</div>
<!--end::Sidebar-->