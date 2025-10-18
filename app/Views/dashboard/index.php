<!--begin::Header-->
<?= $this->include('layout/header.php') ?>
<!--end::Header-->


<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar  pt-7 pt-lg-10 ">

            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
                <!--begin::Toolbar container-->
                <div class="d-flex flex-stack flex-row-fluid">
                    <!--begin::Toolbar container-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Toolbar wrapper-->


                        <!--begin::Page title-->
                        <div class="page-title d-flex align-items-center gap-1 me-3">
                            <!--begin::Title-->
                            <span class="text-gray-900 fw-bolder fs-2x lh-1">
                                Logistics
                            </span>
                            <!--end::Title-->


                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base ms-3 d-flex mb-0">


                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                    <a href="/" class="text-gray-700 text-hover-primary">
                                        <i class="ki-duotone ki-home fs-3 text-gray-500 ms-2"></i>
                                    </a>
                                </li>
                                <!--end::Item-->

                                <!--begin::Item-->
                                <li class="breadcrumb-item mx-n1">
                                    <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                                </li>
                                <!--end::Item-->



                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                    Dashboards </li>
                                <!--end::Item-->

                                <!--begin::Item-->
                                <li class="breadcrumb-item mx-n1">
                                    <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                                </li>
                                <!--end::Item-->



                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-500">
                                    Logistics </li>
                                <!--end::Item-->


                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--end::Toolbar container-->

                    <!--begin::Actions-->
                    <div class="d-flex align-self-center flex-center flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-secondary d-flex flex-center ms-3 px-4 py-3"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                            <i class="ki-duotone ki-plus-square fs-2 text-gray-500"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span></i>
                            <span>Invite</span>
                        </a>

                        <a href="#" class="btn btn-sm btn-primary ms-3 px-4 py-3" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_new_target">
                            Create <span class="d-none d-sm-inline">App</span>
                        </a>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">


            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                
                <!-- Register Token Button -->
                <div class="d-flex justify-content-end mb-5">
                    <button type="button" class="btn btn-success d-flex align-items-center" 
                            id="registerTokenBtn" onclick="registerFCMToken()">
                        <i class="ki-duotone ki-notification-bing fs-2 text-white me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <span>Register Token</span>
                    </button>
                </div>
                
                <!--begin::Row-->
                <div class="row gy-5 gx-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-4 mb-xl-10">

                        <!--begin::Engage widget 1-->
                        <div class="card h-md-100" dir="ltr">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column flex-center">
                                <!--begin::Heading-->
                                <div class="mb-2">
                                    <!--begin::Title-->
                                    <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                                        Quick form to <br />
                                        <span class="fw-bolder"> Bid a New Shipment</span>
                                    </h1>
                                    <!--end::Title-->

                                    <!--begin::Illustration-->
                                    <div class="py-10 text-center">
                                        <img src="/assets/media/svg/illustrations/easy/3.svg"
                                            class="theme-light-show w-200px" alt="" />
                                        <img src="/assets/media/svg/illustrations/easy/3-dark.svg"
                                            class="theme-dark-show w-200px" alt="" />
                                    </div>
                                    <!--end::Illustration-->
                                </div>
                                <!--end::Heading-->

                                <!--begin::Links-->
                                <div class="text-center mb-1">
                                    <!--begin::Link-->
                                    <a class="btn btn-sm btn-primary me-2" data-bs-target="#kt_modal_bidding"
                                        data-bs-toggle="modal">
                                        Start Now </a>
                                    <!--end::Link-->

                                    <!--begin::Link-->
                                    <a class="btn btn-sm btn-light"
                                        href="/bold-html-pro/apps/invoices/view/invoice-2.html">
                                        Quick Guide </a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Links-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Engage widget 1-->

                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8 mb-5 mb-xl-10">
                        <!--begin::Row-->
                        <div class="row g-lg-5 g-xl-10">
                            <!--begin::Col-->
                            <div class="col-md-6 col-xl-6 mb-5 mb-xl-10">
                                <!--begin::Card widget 12-->
                                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <!--begin::Statistics-->
                                        <div class="mb-4 px-9">
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center mb-2">


                                                <!--begin::Value-->
                                                <span
                                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">47,769,700</span>
                                                <!--end::Value-->

                                                <!--begin::Label-->
                                                <span class="d-flex align-items-end text-gray-500 fs-6 fw-semibold">
                                                    Tons </span>

                                                <!--end::Label-->
                                            </div>
                                            <!--end::Info-->

                                            <!--begin::Description-->
                                            <span class="fs-6 fw-semibold text-gray-500">Total Online
                                                Sales</span>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Statistics-->

                                        <!--begin::Chart-->
                                        <div id="kt_card_widget_12_chart" class="min-h-auto" style="height: 125px">
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card widget 12-->


                                <!--begin::Card widget 10-->
                                <div class="card card-flush h-md-50 mb-lg-10">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">69,700</span>
                                            <!--end::Amount-->

                                            <!--begin::Subtitle-->
                                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Expected
                                                Earnings This Month</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Card body-->
                                    <div class="card-body d-flex align-items-end pt-0">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex align-items-center flex-wrap">
                                            <!--begin::Chart-->
                                            <div class="d-flex me-7 me-xxl-10">
                                                <div id="kt_card_widget_10_chart" class="min-h-auto"
                                                    style="height: 78px; width: 78px" data-kt-size="78"
                                                    data-kt-line="11">
                                                </div>
                                            </div>
                                            <!--end::Chart-->

                                            <!--begin::Labels-->
                                            <div class="d-flex flex-column content-justify-center flex-grow-1">
                                                <!--begin::Label-->
                                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                                    <!--begin::Bullet-->
                                                    <div class="bullet w-8px h-6px rounded-2 bg-success me-3">
                                                    </div>
                                                    <!--end::Bullet-->

                                                    <!--begin::Label-->
                                                    <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">
                                                        Used Truck freight</div>
                                                    <!--end::Label-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2">
                                                    </div>
                                                    <!--end::Separator-->

                                                    <!--begin::Stats-->
                                                    <div class="ms-auto fw-bolder text-gray-700 text-end">
                                                        45%</div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Label-->

                                                <!--begin::Label-->
                                                <div class="d-flex fs-6 fw-semibold align-items-center my-1">
                                                    <!--begin::Bullet-->
                                                    <div class="bullet w-8px h-6px rounded-2 bg-primary me-3">
                                                    </div>
                                                    <!--end::Bullet-->

                                                    <!--begin::Label-->
                                                    <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">
                                                        Used Ship freight</div>
                                                    <!--end::Label-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2">
                                                    </div>
                                                    <!--end::Separator-->

                                                    <!--begin::Stats-->
                                                    <div class="ms-auto fw-bolder text-gray-700 text-end">
                                                        21%</div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Label-->

                                                <!--begin::Label-->
                                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                                    <!--begin::Bullet-->
                                                    <div class="bullet w-8px h-6px rounded-2 me-3"
                                                        style="background-color: #E4E6EF"></div>
                                                    <!--end::Bullet-->

                                                    <!--begin::Label-->
                                                    <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">
                                                        Used Plane freight</div>
                                                    <!--end::Label-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2">
                                                    </div>
                                                    <!--end::Separator-->

                                                    <!--begin::Stats-->
                                                    <div class="ms-auto fw-bolder text-gray-700 text-end">
                                                        34%</div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Labels-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card widget 10-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-6 col-xl-6 mb-md-5 mb-xl-10">

                                <!--begin::Card widget 13-->
                                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <!--begin::Statistics-->
                                        <div class="mb-4 px-9">
                                            <!--begin::Statistics-->
                                            <div class="d-flex align-items-center mb-2">


                                                <!--begin::Value-->
                                                <span
                                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">259,786</span>
                                                <!--end::Value-->

                                                <!--begin::Label-->

                                                <!--end::Label-->
                                            </div>
                                            <!--end::Statistics-->

                                            <!--begin::Description-->
                                            <span class="fs-6 fw-semibold text-gray-500">Total
                                                Shipments</span>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Statistics-->

                                        <!--begin::Chart-->
                                        <div id="kt_card_widget_13_chart" class="min-h-auto" style="height: 125px">
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card widget 13-->




                                <!--begin::Card widget 7-->
                                <div class="card card-flush h-md-50 mb-lg-10">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">604</span>
                                            <!--end::Amount-->

                                            <!--begin::Subtitle-->
                                            <span class="text-gray-500 pt-1 fw-semibold fs-6">New
                                                Customers This Month</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Card body-->
                                    <div class="card-body d-flex flex-column justify-content-end pe-0">
                                        <!--begin::Title-->
                                        <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today’s
                                            Heroes</span>
                                        <!--end::Title-->

                                        <!--begin::Users group-->
                                        <div class="symbol-group symbol-hover flex-nowrap">
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                                title="Alan Warden">
                                                <span
                                                    class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                                title="Michael Eberon">
                                                <img alt="Pic" src="/assets/media/avatars/300-11.jpg" />
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                                title="Susan Redwood">
                                                <span
                                                    class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                                title="Melody Macy">
                                                <img alt="Pic" src="/assets/media/avatars/300-2.jpg" />
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                                title="Perry Matthew">
                                                <span
                                                    class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                                title="Barry Walter">
                                                <img alt="Pic" src="/assets/media/avatars/300-12.jpg" />
                                            </div>
                                            <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_view_users">
                                                <span
                                                    class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+42</span>
                                            </a>
                                        </div>
                                        <!--end::Users group-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card widget 7-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->


                <!--begin::Row-->
                <div class="row gy-5 g-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-4">

                        <!--begin::List widget 11-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header pt-7 mb-3">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Our Fleet
                                        Tonnage</span>
                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Total 1,247
                                        vehicles</span>
                                </h3>
                                <!--end::Title-->

                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-sm btn-light" data-bs-toggle='tooltip'
                                        data-bs-dismiss='click' data-bs-custom-class="tooltip-inverse"
                                        title="Logistics App is coming soon">Review Fleet</a>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body pt-4">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-ship text-gray-600 fs-1"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Content-->
                                        <div class="me-5">
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Ships</a>
                                            <!--end::Title-->

                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">234
                                                Ships</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Section-->

                                    <!--begin::Wrapper-->
                                    <div class="text-gray-500 fw-bold fs-7 text-end">
                                        <!--begin::Number-->
                                        <span class="text-gray-800 fw-bold fs-6 d-block">2,345,500</span>
                                        <!--end::Number-->

                                        Tons
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Item-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-5"></div>
                                <!--end::Separator-->

                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-truck text-gray-600 fs-1"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span><span
                                                        class="path5"></span></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Content-->
                                        <div class="me-5">
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Trucks</a>
                                            <!--end::Title-->

                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">1,460
                                                Trucks</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Section-->

                                    <!--begin::Wrapper-->
                                    <div class="text-gray-500 fw-bold fs-7 text-end">
                                        <!--begin::Number-->
                                        <span class="text-gray-800 fw-bold fs-6 d-block">457,200</span>
                                        <!--end::Number-->

                                        Tons
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Item-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-5"></div>
                                <!--end::Separator-->

                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-airplane-square text-gray-600 fs-1"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Content-->
                                        <div class="me-5">
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Planes</a>
                                            <!--end::Title-->

                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">8
                                                Aircrafts</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Section-->

                                    <!--begin::Wrapper-->
                                    <div class="text-gray-500 fw-bold fs-7 text-end">
                                        <!--begin::Number-->
                                        <span class="text-gray-800 fw-bold fs-6 d-block">1,240</span>
                                        <!--end::Number-->

                                        Tons
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Item-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-5"></div>
                                <!--end::Separator-->

                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-bus text-gray-600 fs-1"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span><span
                                                        class="path5"></span></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Content-->
                                        <div class="me-5">
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Trains</a>
                                            <!--end::Title-->

                                            <!--begin::Desc-->
                                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">36
                                                Trains</span>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Section-->

                                    <!--begin::Wrapper-->
                                    <div class="text-gray-500 fw-bold fs-7 text-end">
                                        <!--begin::Number-->
                                        <span class="text-gray-800 fw-bold fs-6 d-block">804,300</span>
                                        <!--end::Number-->

                                        Tons
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Item-->




                                <div class="text-center pt-9">
                                    <a href="/bold-html-pro/apps/ecommerce/catalog/add-product.html"
                                        class="btn btn-primary">Add Vehicle</a>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::List widget 11-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Chart widget 17-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header pt-7">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Sales
                                        Statistics</span>

                                    <span class="text-gray-500 pt-2 fw-semibold fs-6">Top Selling
                                        Countries</span>
                                </h3>
                                <!--end::Title-->

                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <button
                                        class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-500 me-n1"><span
                                                class="path1"></span><span class="path2"></span><span
                                                class="path3"></span><span class="path4"></span></i>
                                    </button>

                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-100px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Remove
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Mute
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Settings
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->

                                    <!--end::Menu-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <!--begin::Chart container-->
                                <div id="kt_charts_widget_16_chart" class="w-100 h-350px"></div>
                                <!--end::Chart container-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Chart widget 17-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->

    </div>
    <!--end::Content wrapper-->


    <!--begin::Footer-->
    <?= $this->include('layout/footer.php') ?>
    <!--end::Footer-->

</div>
<!--end::Content wrapper-->

<!-- Agreement Modal (if needed) -->
<?php if ($show_agreement_modal ?? false): ?>
<div class="modal fade" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-md-down">
        <div class="modal-content" style="min-height: 90vh;">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white d-flex align-items-center" id="agreementModalLabel">
                    <i class="ki-duotone ki-security-user fs-4x me-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span>Software License Agreement</span>
                </h5>
            </div>
            <div class="modal-body" style="flex: 1; overflow-y: auto;">
                <div class="agreement-content">
                    <h6 class="fw-bold">Islanders Finolhu Software License Agreement</h6>
                    <p class="text-muted">Last updated: <?= date('F j, Y') ?></p>

                    <div class="agreement-text"
                        style="max-height: 75vh; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                        <h6 class="fw-bold text-primary">1. ACCEPTANCE OF TERMS</h6>
                        <p>By accessing and using the Islanders Finolhu software system, you acknowledge that you have
                            read, understood, and agree to be bound by the terms and conditions of this Software License
                            Agreement.</p>

                        <h6 class="fw-bold text-primary">2. PERMITTED USE</h6>
                        <p>This software is provided for the exclusive use of authorized Islanders Finolhu employees and
                            contractors. You may use this system solely for legitimate business purposes related to your
                            employment or contract with Islanders Finolhu.</p>

                        <h6 class="fw-bold text-primary">3. RESTRICTIONS</h6>
                        <p>You agree NOT to:</p>
                        <ul class="list-styled">
                            <li>Share your login credentials with unauthorized persons</li>
                            <li>Attempt to reverse engineer, decompile, or disassemble the software</li>
                            <li>Use the system for any illegal or unauthorized purpose</li>
                            <li>Access data or functionality beyond your authorized scope</li>
                            <li>Download, copy, or distribute confidential company information without authorization
                            </li>
                        </ul>

                        <h6 class="fw-bold text-primary">4. DATA PROTECTION & PRIVACY</h6>
                        <p>You acknowledge that this system may contain sensitive and confidential information. You
                            agree to maintain the confidentiality of all data accessed through this system and comply
                            with all applicable data protection regulations.</p>

                        <h6 class="fw-bold text-primary">5. MONITORING & COMPLIANCE</h6>
                        <p>Your use of this system may be monitored for security, compliance, and operational purposes.
                            By using this system, you consent to such monitoring activities.</p>

                        <h6 class="fw-bold text-primary">6. TERMINATION</h6>
                        <p>This license is effective until terminated. Your access may be terminated immediately without
                            notice if you violate any terms of this agreement or upon termination of your
                            employment/contract with Islanders Finolhu.</p>

                        <h6 class="fw-bold text-primary">7. LIMITATION OF LIABILITY</h6>
                        <p>Islanders Finolhu shall not be liable for any damages arising from the use or inability to
                            use this software, except as required by applicable law.</p>

                        <div class="alert alert-warning d-flex align-items-center mt-4">
                            <i class="ki-duotone ki-information-5 fs-2x text-warning me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div>
                                <strong>Important:</strong> You must accept this agreement to continue using the system.
                                If you do not agree to these terms, please contact your system administrator.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-primary" id="acceptAgreementBtn">
                    <i class="ki-duotone ki-check fs-2 me-1">
                        <span class="path1"></span>
                    </i>
                    I Accept the Agreement
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
console.log('Show agreement modal:', <?= json_encode($show_agreement_modal ?? false) ?>);
<?php if ($show_agreement_modal ?? false): ?>
console.log('Agreement modal should show - initializing...');
// Show the agreement modal on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, showing modal...');
    var modalElement = document.getElementById('agreementModal');
    console.log('Modal element found:', modalElement);

    if (modalElement) {
        // Try multiple ways to show the modal
        try {
            var agreementModal = new bootstrap.Modal(modalElement);
            agreementModal.show();
            console.log('Modal shown using Bootstrap 5 method');
        } catch (e) {
            console.error('Bootstrap Modal error:', e);
            // Fallback to jQuery if available
            if (typeof $ !== 'undefined') {
                $('#agreementModal').modal('show');
                console.log('Modal shown using jQuery fallback');
            } else {
                // Manual show
                modalElement.style.display = 'block';
                modalElement.classList.add('show');
                console.log('Modal shown manually');
            }
        }
    } else {
        console.error('Agreement modal element not found');
    }
});

// Handle agreement acceptance
document.getElementById('acceptAgreementBtn').addEventListener('click', function() {
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...';

    fetch('<?= base_url('accept-agreement') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
            },
            body: JSON.stringify({
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                var agreementModal = bootstrap.Modal.getInstance(document.getElementById('agreementModal'));
                agreementModal.hide();

                // Show success toast notification
                Swal.fire({
                    icon: 'success',
                    title: 'Agreement Accepted!',
                    text: data.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                // Show notification modal after agreement is accepted
                <?php if ($show_notification_prompt ?? false): ?>
                console.log('Agreement accepted, scheduling notification modal...');
                setTimeout(() => {
                    showNotificationModal();
                }, 1000); // Show notification modal 1 second after agreement acceptance
                <?php endif; ?>
            } else {
                // Show error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
                this.disabled = false;
                this.innerHTML =
                    '<i class="ki-duotone ki-check fs-2 me-1"><span class="path1"></span></i>I Accept the Agreement';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again.'
            });
            this.disabled = false;
            this.innerHTML =
                '<i class="ki-duotone ki-check fs-2 me-1"><span class="path1"></span></i>I Accept the Agreement';
        });
});
<?php endif; ?>
</script>

<style>
/* Ensure proper fullscreen modal on mobile */
@media (max-width: 767.98px) {
    #agreementModal .modal-fullscreen-md-down {
        width: 100vw;
        max-width: none;
        height: 100vh;
        margin: 0;
    }

    #agreementModal .modal-fullscreen-md-down .modal-content {
        height: 100vh;
        min-height: 100vh;
        border: 0;
        border-radius: 0;
    }

    #agreementModal .modal-body {
        flex: 1;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }
}

/* Desktop height optimization */
@media (min-width: 768px) {
    #agreementModal .modal-content {
        height: 85vh;
        min-height: 85vh;
    }
}
</style>

<!-- Notification Permission Modal -->
<div class="modal fade" id="notificationPermissionModal" tabindex="-1" aria-labelledby="notificationPermissionLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white d-flex align-items-center" id="notificationPermissionLabel">
                    <i class="ki-duotone ki-notification-bing fs-2x me-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <span>Enable Push Notifications</span>
                </h5>
            </div>
            <div class="modal-body">
                <div class="text-center py-5">
                    <i class="ki-duotone ki-notification-on fs-5x text-primary mb-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <h4 class="fw-bold mb-3">Stay Updated!</h4>
                    <p class="text-gray-700 mb-4">
                        Enable push notifications to receive instant updates about:
                    </p>
                    <ul class="list-unstyled text-start mb-4">
                        <li class="mb-2">
                            <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            New requests and assignments
                        </li>
                        <li class="mb-2">
                            <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Status updates and approvals
                        </li>
                        <li class="mb-2">
                            <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Important system announcements
                        </li>
                        <li class="mb-2">
                            <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Team messages and reminders
                        </li>
                    </ul>
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="ki-duotone ki-information-5 fs-2x text-info me-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="text-start">
                            <small>You can change this setting anytime in your browser or profile settings.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-light" id="skipNotificationBtn">
                    <i class="ki-duotone ki-cross fs-2 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Maybe Later
                </button>
                <button type="button" class="btn btn-primary" id="enableNotificationBtn">
                    <i class="ki-duotone ki-notification-on fs-2 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Enable Notifications
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Debug Dashboard Modal Flags  
console.log('=== DASHBOARD DEBUG ===');
console.log('show_agreement_modal:', <?= json_encode($show_agreement_modal ?? false) ?>);
console.log('show_notification_prompt:', <?= json_encode($show_notification_prompt ?? false) ?>);
console.log('User device_token:', <?= json_encode($user->device_token ?? 'undefined') ?>);
console.log('User has_accepted_agreement:', <?= json_encode($user->has_accepted_agreement ?? 'undefined') ?>);
console.log('======================');

// Simple notification system - FCM logic is now in header.php like working app
console.log('Show notification prompt flag:', <?= json_encode($show_notification_prompt ?? false) ?>);

// Detect if running in Capacitor mobile app
const isCapacitor = window.Capacitor !== undefined;
const platform = isCapacitor ? window.Capacitor.getPlatform() : 'web';
console.log('Platform detected:', platform);
console.log('Is Capacitor:', isCapacitor);
console.log('FCM registration handled automatically in header.php (like working CI4 app)');

// Register FCM Token Button Function
async function registerFCMToken() {
    const btn = document.getElementById('registerTokenBtn');
    const originalHTML = btn.innerHTML;
    
    try {
        // Show loading state
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registering...';
        
        if (isCapacitor) {
            // Mobile app - trigger FCM registration
            console.log('Capacitor app detected - triggering FCM registration...');
            
            if (window.Capacitor.Plugins && window.Capacitor.Plugins.PushNotifications) {
                const PushNotifications = window.Capacitor.Plugins.PushNotifications;
                
                // Request permissions
                const permission = await PushNotifications.requestPermissions();
                console.log('Permission result:', permission);
                
                if (permission.receive === 'granted') {
                    // Set up listener for token
                    const listener = PushNotifications.addListener('registration', async (token) => {
                        console.log('Received FCM token:', token.value);
                        
                        try {
                            // Save token to backend
                            const response = await fetch('<?= base_url('api/save-token') ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    token: token.value
                                })
                            });
                            
                            const result = await response.json();
                            console.log('Token save result:', result);
                            
                            if (response.ok && result.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'FCM token registered successfully!',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                
                                // Update button to show success
                                btn.innerHTML = '<i class="ki-duotone ki-check fs-2 text-white"><span class="path1"></span><span class="path2"></span></i><span class="d-none d-sm-inline ms-2">Token Registered</span>';
                                btn.classList.remove('btn-success');
                                btn.classList.add('btn-light-success');
                                
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                throw new Error(result.message || 'Failed to save token');
                            }
                        } catch (error) {
                            console.error('Error saving token:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to save token: ' + error.message
                            });
                        } finally {
                            listener.remove();
                        }
                    });
                    
                    // Register for notifications
                    await PushNotifications.register();
                    
                } else {
                    throw new Error('Push notification permission not granted');
                }
            } else {
                throw new Error('PushNotifications plugin not available');
            }
        } else {
            // Web browser - show info
            Swal.fire({
                icon: 'info',
                title: 'Web Browser',
                text: 'FCM token registration is primarily for mobile apps. Use the notification permission modal for web browsers.',
                confirmButtonText: 'OK'
            });
        }
        
    } catch (error) {
        console.error('Token registration error:', error);
        
        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: error.message || 'Failed to register FCM token. Please try again.',
            confirmButtonText: 'OK'
        });
        
    } finally {
        // Restore button state
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    }
}

// Simple notification modal function (FCM logic is in header.php)
function showNotificationModal() {
    console.log('=== showNotificationModal called ===');
    var modalElement = document.getElementById('notificationPermissionModal');
    
    if (modalElement) {
        try {
            var notificationModal = new bootstrap.Modal(modalElement);
            notificationModal.show();
            console.log('Notification permission modal shown successfully');
        } catch (error) {
            console.error('Error showing notification modal:', error);
        }
    } else {
        console.error('Modal element notificationPermissionModal not found!');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DOMContentLoaded fired ===');

    // Check if notification prompt should be shown
    const showNotificationPrompt = <?= json_encode($show_notification_prompt ?? false) ?>;
    console.log('showNotificationPrompt flag:', showNotificationPrompt);

    // Check if agreement modal is also being shown
    const showAgreementModal = <?= json_encode($show_agreement_modal ?? false) ?>;
    console.log('showAgreementModal flag:', showAgreementModal);

    // Only proceed if notification prompt should be shown
    if (showNotificationPrompt) {
        if (!showAgreementModal) {
            console.log('No agreement modal, scheduling notification modal...');
            // No agreement modal, show notification modal after delay as usual
            setTimeout(() => {
                console.log('Timeout fired, calling showNotificationModal...');
                showNotificationModal();
            }, 1000); // 1 second delay
        } else {
            console.log('Agreement modal is showing, notification modal will wait...');
        }
    } else {
        console.log('Notification prompt not needed (user has device token)');
    }
    // If agreement modal is shown, the notification modal will be triggered after agreement acceptance
    // (handled in the agreement acceptance success callback above)

    // Handle "Enable Notifications" button - Simple version (FCM logic is in header.php)
    document.getElementById('enableNotificationBtn').addEventListener('click', async function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enabling...';

        try {
            if (isCapacitor) {
                console.log('Capacitor app: FCM registration handled automatically in header.php');
                
                // Just trigger the deviceready event manually to activate the header's FCM system
                const event = new Event('deviceready');
                document.dispatchEvent(event);
                
                // Show success message
                closeNotificationModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Enabled!',
                    text: 'Push notifications are being set up automatically.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // Reload page after delay
                setTimeout(() => location.reload(), 2000);
            } else {
                // Web browser - simple notification request
                const permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    closeNotificationModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Enabled!',
                        text: 'Browser notifications have been enabled.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    setTimeout(() => location.reload(), 2000);
                } else {
                    throw new Error('Browser notification permission denied');
                }
            }
        } catch (error) {
            console.error('Error enabling notifications:', error);
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to enable notifications. Please try again.',
                confirmButtonText: 'OK'
            });

            btn.disabled = false;
            btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
        }
    });

    // Handle "Maybe Later" button
    document.getElementById('skipNotificationBtn').addEventListener('click', function() {
        closeNotificationModal();
        Swal.fire({
            icon: 'info',
            title: 'Skipped',
            text: 'You can enable notifications anytime from your profile settings.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    });

    // Simple close modal function (complex FCM logic moved to header.php)

    function closeNotificationModal() {
        var modalElement = document.getElementById('notificationPermissionModal');
        if (modalElement) {
            var modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    }
});
</script>
