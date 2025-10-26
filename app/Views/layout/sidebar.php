<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Main-->
    <div class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 mx-5 d-flex flex-column"
        id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <!-- <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
            class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7">


        </div> -->

        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
            class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7">

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
            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <a href="/" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <a href="/feed" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
            <?php $isActive = isMenuActive(['/requests/add_request', '/requests', '/authorizations']); ?>
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                        <?php $subActive1 = isMenuActive(['/requests/add_request']); ?>
                        <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/requests/add_request"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right" <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                        <?php $subActive2 = isMenuActive(['/requests']) && !isMenuActive(['/requests/add_request']); ?>
                        <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>" href="/requests"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right" <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                        <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>" href="/authorizations"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right" <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <a href="/users" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <a href="/events" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <a href="/policies" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                        <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/tickets"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right" <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                        <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/todays_departure"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right" <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                        <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>" href="/todays_arrival"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right" <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                        <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>" href="/exit_request"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right" <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                    $hasRequestsAccess = has_permission('requests.view');
                    $hasModulesAccess = has_permission('modules.view');
                    $hasLogsAccess = has_permission('logs.view');
                    $hasSystemAccess = $hasStatusAccess || $hasRequestsAccess || $hasModulesAccess || $hasLogsAccess;
                    
                    // For Islander Settings, we'll assume admin/manager access for now
                    // You can add specific permissions for these later if needed
                    $hasIslanderAccess = has_permission('system.admin') || in_groups(['admin', 'manager']);
                    
                    // Check permissions for user management items
                    $hasUserManagementAccess = has_permission('users.view') || has_permission('sessions.view') || 
                                             has_permission('groups.view') || has_permission('permissions.view') || 
                                             in_groups(['admin', 'manager']);
                    
                    // Check if user has access to any settings
                    $hasAnySettingsAccess = $hasSystemAccess || $hasIslanderAccess || $hasUserManagementAccess;
                    
                    $isActive = isMenuActive(['/modules', '/status', '/logs', '/flight-routes', '/leave', '/divisions', '/departments', '/sections', '/positions', '/genders', '/nationalities', '/houses', '/policy', '/islanders', '/visitors', '/sessions', '/requesting-rules', '/authorization-rules', '/roles', '/group-permissions', '/user-permissions']) && $hasAnySettingsAccess;
                    ?>
            <?php if ($hasAnySettingsAccess): ?>
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                <!--begin:Menu link-->
                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
                    <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                            $userMgmtActive = isMenuActive(['/islanders', '/visitors', '/sessions', '/requesting-rules', '/authorization-rules', '/roles', '/group-permissions', '/user-permissions']) && $hasUserManagementAccess;
                            ?>
                    <?php if ($hasUserManagementAccess): ?>
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion <?= $userMgmtActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $userMgmtActive ? 'active bg-white' : '' ?>"
                            <?= $userMgmtActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/islanders"
                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>" href="/visitors"
                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>" href="/sessions"
                                    <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <?php $subActive4 = isMenuActive(['/requesting-rules']); ?>
                                <a class="menu-link <?= $subActive4 ? 'active bg-white' : '' ?>" href="/requesting-rules"
                                    <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                            <?php if (has_permission('authorization_rules.view') || $hasUserManagementAccess): ?>
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive5 = isMenuActive(['/authorization-rules']); ?>
                                <a class="menu-link <?= $subActive5 ? 'active bg-white' : '' ?>"
                                    href="/authorization-rules"
                                    <?= $subActive5 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive6 ? 'active bg-white' : '' ?>" href="/roles"
                                    <?= $subActive6 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive7 ? 'active bg-white' : '' ?>"
                                    href="/group-permissions"
                                    <?= $subActive7 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive8 ? 'active bg-white' : '' ?>" href="/user-permissions"
                                    <?= $subActive8 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion <?= $islanderActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $islanderActive ? 'active bg-white' : '' ?>"
                            <?= $islanderActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/divisions"
                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>" href="/departments"
                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>" href="/sections"
                                    <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive4 ? 'active bg-white' : '' ?>" href="/positions"
                                    <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive5 ? 'active bg-white' : '' ?>" href="/genders"
                                    <?= $subActive5 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive6 ? 'active bg-white' : '' ?>" href="/nationalities"
                                    <?= $subActive6 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive7 ? 'active bg-white' : '' ?>" href="/houses"
                                    <?= $subActive7 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Houses</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <?php endif; ?>
                            <!--begin:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive8 = isMenuActive(['/policy']); ?>
                                <a class="menu-link <?= $subActive8 ? 'active bg-white' : '' ?>" href="/policy"
                                    <?= $subActive8 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                            $islanderActive = isMenuActive(['/leave', '/flight-routes']) && $hasIslanderAccess;
                            ?>
                    <?php if ($hasIslanderAccess): ?>
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion <?= $islanderActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $islanderActive ? 'active bg-white' : '' ?>"
                            <?= $islanderActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Request Settings</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <?php if (has_permission('leave.view') || $hasIslanderAccess): ?>
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive1 = isMenuActive(['/leave']); ?>
                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/leave"
                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Leave Reasons</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <?php endif; ?>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <?php if (has_permission('flight-routes.view') || $hasIslanderAccess): ?>
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <?php $subActive2 = isMenuActive(['/flight-routes']); ?>
                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>" href="/flight-routes"
                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Flight Routes</span>
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
                            // Check permissions for system settings items
                            $hasStatusAccess = has_permission('status.view');
                            $hasRequestsAccess = has_permission('requests.view');
                            $hasModulesAccess = has_permission('modules.view');
                            $hasLogsAccess = has_permission('logs.view');
                            $systemActive = isMenuActive(['/modules', '/status', '/logs']) && ($hasStatusAccess || $hasRequestsAccess || $hasModulesAccess || $hasLogsAccess);
                            ?>
                    <?php if ($hasStatusAccess || $hasRequestsAccess || $hasModulesAccess || $hasLogsAccess): ?>
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion <?= $systemActive ? 'here show' : '' ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link <?= $systemActive ? 'active bg-white' : '' ?>"
                            <?= $systemActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/status"
                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <?php $subActive2 = isMenuActive(['/modules']) && !isMenuActive(['/status']) ?>
                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>" href="/modules"
                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
                                <a class="menu-link <?= $subActive4 ? 'active bg-white' : '' ?>" href="/logs"
                                    <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
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
        <!--begin::Footer-->
        <!-- <div class="app-sidebar-project-default app-sidebar-project-minimize text-center min-h-lg-400px flex-column-auto d-flex flex-column justify-content-end"
                            id="kt_app_sidebar_footer"> -->
        <!--begin::Title-->
        <!-- <h2 class="fw-bold text-gray-800">Welcome to Islanders 3.0</h2> -->
        <!--end::Title-->

        <!--begin::Description-->
        <!-- <div class="fw-semibold text-gray-700 fs-7 lh-2 px-7 mb-1">Join the movement make a
                                difference.</div> -->
        <!--end::Description-->

        <!--begin::Illustration-->
        <!-- <img class="mx-auto h-150px h-lg-175px mb-4" src="/assets/media/misc/saul-welcome.png"
                                alt="" /> -->
        <!--end::Illustration-->

        <!-- <div class="text-center mb-lg-15 pb-lg-3"> -->
        <!-- <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_create_account">Get Started</a> -->
        <!-- </div> -->
        <!-- </div> -->
        <!--end::Footer-->
    </div>
    <!--end::Main-->
</div>