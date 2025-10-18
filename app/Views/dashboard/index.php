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
<div class="modal fade" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                    
                    <div class="agreement-text" style="max-height: 75vh; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                        <h6 class="fw-bold text-primary">1. ACCEPTANCE OF TERMS</h6>
                        <p>By accessing and using the Islanders Finolhu software system, you acknowledge that you have read, understood, and agree to be bound by the terms and conditions of this Software License Agreement.</p>
                        
                        <h6 class="fw-bold text-primary">2. PERMITTED USE</h6>
                        <p>This software is provided for the exclusive use of authorized Islanders Finolhu employees and contractors. You may use this system solely for legitimate business purposes related to your employment or contract with Islanders Finolhu.</p>
                        
                        <h6 class="fw-bold text-primary">3. RESTRICTIONS</h6>
                        <p>You agree NOT to:</p>
                        <ul class="list-styled">
                            <li>Share your login credentials with unauthorized persons</li>
                            <li>Attempt to reverse engineer, decompile, or disassemble the software</li>
                            <li>Use the system for any illegal or unauthorized purpose</li>
                            <li>Access data or functionality beyond your authorized scope</li>
                            <li>Download, copy, or distribute confidential company information without authorization</li>
                        </ul>
                        
                        <h6 class="fw-bold text-primary">4. DATA PROTECTION & PRIVACY</h6>
                        <p>You acknowledge that this system may contain sensitive and confidential information. You agree to maintain the confidentiality of all data accessed through this system and comply with all applicable data protection regulations.</p>
                        
                        <h6 class="fw-bold text-primary">5. MONITORING & COMPLIANCE</h6>
                        <p>Your use of this system may be monitored for security, compliance, and operational purposes. By using this system, you consent to such monitoring activities.</p>
                        
                        <h6 class="fw-bold text-primary">6. TERMINATION</h6>
                        <p>This license is effective until terminated. Your access may be terminated immediately without notice if you violate any terms of this agreement or upon termination of your employment/contract with Islanders Finolhu.</p>
                        
                        <h6 class="fw-bold text-primary">7. LIMITATION OF LIABILITY</h6>
                        <p>Islanders Finolhu shall not be liable for any damages arising from the use or inability to use this software, except as required by applicable law.</p>
                        
                        <div class="alert alert-warning d-flex align-items-center mt-4">
                            <i class="ki-duotone ki-information-5 fs-2x text-warning me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div>
                                <strong>Important:</strong> You must accept this agreement to continue using the system. If you do not agree to these terms, please contact your system administrator.
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
            this.innerHTML = '<i class="ki-duotone ki-check fs-2 me-1"><span class="path1"></span></i>I Accept the Agreement';
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
        this.innerHTML = '<i class="ki-duotone ki-check fs-2 me-1"><span class="path1"></span></i>I Accept the Agreement';
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
<div class="modal fade" id="notificationPermissionModal" tabindex="-1" aria-labelledby="notificationPermissionLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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

// Notification Permission Handler
// Always load notification functions regardless of flag
console.log('Show notification prompt flag:', <?= json_encode($show_notification_prompt ?? false) ?>);

// Detect if running in Capacitor mobile app
const isCapacitor = window.Capacitor !== undefined;
const platform = isCapacitor ? window.Capacitor.getPlatform() : 'web';
console.log('Platform detected:', platform);
console.log('Is Capacitor:', isCapacitor);

// Function to show notification modal
function showNotificationModal() {
    console.log('=== showNotificationModal called ===');
    var modalElement = document.getElementById('notificationPermissionModal');
    console.log('Modal element found:', modalElement !== null);
    
    if (modalElement) {
        try {
            console.log('Creating Bootstrap modal instance...');
            var notificationModal = new bootstrap.Modal(modalElement);
            console.log('Modal instance created, showing...');
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

    // Handle "Enable Notifications" button
    document.getElementById('enableNotificationBtn').addEventListener('click', async function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Requesting...';

        try {
            if (isCapacitor) {
                // Mobile app (Capacitor) - Use PushNotifications plugin
                console.log('Starting Capacitor notification flow for platform:', platform);
                await handleCapacitorNotifications(btn);
            } else {
                // Web browser - Use Notification API
                console.log('Starting web notification flow');
                await handleWebNotifications(btn);
            }
        } catch (error) {
            console.error('Error enabling notifications:', error);
            
            // Show specific error message for iOS vs others
            let errorTitle = 'Error';
            let errorText = error.message || 'Failed to enable notifications. Please try again.';
            
            if (platform === 'ios' && error.message.includes('timeout')) {
                errorTitle = 'iOS Setup Required';
                errorText = 'iOS push notifications require additional setup. Please contact your administrator.';
            }
            
            Swal.fire({
                icon: 'error',
                title: errorTitle,
                text: errorText,
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

    // Capacitor Mobile App Notification Handler - Simplified Working Approach
    async function handleCapacitorNotifications(btn) {
        console.log('Using simplified working approach from previous CI4 app...', 'Platform:', platform);
        
        // Check if PushNotifications is available
        if (!window.Capacitor.Plugins || !window.Capacitor.Plugins.PushNotifications) {
            throw new Error('PushNotifications plugin not available. Please ensure @capacitor/push-notifications is installed.');
        }

        const PushNotifications = window.Capacitor.Plugins.PushNotifications;

        try {
            console.log('Step 1: Request permissions (simplified approach)...');
            
            // Request permissions directly
            const permission = await PushNotifications.requestPermissions();
            console.log('Permission result:', permission);
            
            if (permission.receive !== 'granted') {
                btn.disabled = false;
                btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Permission Required',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>Push notification permission is required.</strong></p>
                            <p>Current status: <code>${permission.receive}</code></p>
                            
                            <div style="background: #e3f2fd; padding: 10px; border-radius: 4px; margin: 10px 0;">
                                <strong>Please enable notifications:</strong>
                                <ol style="margin: 5px 0;">
                                    <li>Go to device Settings</li>
                                    <li>Find this app in the app list</li>
                                    <li>Tap on Notifications</li>
                                    <li>Turn on "Allow Notifications"</li>
                                    <li>Return to this app and try again</li>
                                </ol>
                            </div>
                        </div>
                    `,
                    confirmButtonText: 'OK'
                });
                return;
            }

            console.log('Step 2: Set up listeners (before registering)...');
            
            // Set up success listener
            const registrationListener = PushNotifications.addListener('registration', async (token) => {
                console.log('[Token Received] →', token.value);
                
                try {
                    console.log('Saving token to backend...');
                    await saveTokenToBackend(token.value, platform, btn);
                } catch (error) {
                    console.error('[Token Save Error] →', error);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Save Failed',
                        text: 'Failed to save notification token: ' + error.message,
                        confirmButtonText: 'OK'
                    });
                } finally {
                    registrationListener.remove();
                }
            });

            // Set up error listener
            const errorListener = PushNotifications.addListener('registrationError', (error) => {
                console.error('[Registration Error] →', error);
                
                btn.disabled = false;
                btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
                
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>Push notification registration failed.</strong></p>
                            <p>Error: ${error.error || 'Unknown error'}</p>
                            
                            ${platform === 'ios' ? `
                                <div style="background: #fff3e0; padding: 10px; border-radius: 4px; border-left: 4px solid #ff9800; margin: 10px 0;">
                                    <strong>🍎 iOS - Missing APNS Certificate</strong>
                                    <p style="margin: 5px 0;">This error typically means:</p>
                                    <ul style="margin: 5px 0;">
                                        <li>No APNS certificate uploaded to Firebase Console</li>
                                        <li>Bundle ID mismatch between app and Firebase</li>
                                        <li>Certificate expired or invalid</li>
                                    </ul>
                                    
                                    <strong>Quick Fix:</strong>
                                    <ol style="margin: 5px 0; font-size: 13px;">
                                        <li>Go to Firebase Console → Project Settings</li>
                                        <li>Click "Cloud Messaging" tab</li>
                                        <li>Upload APNS certificate for iOS app</li>
                                        <li>Ensure Bundle ID matches exactly</li>
                                    </ol>
                                </div>
                            ` : ''}
                        </div>
                    `,
                    confirmButtonText: 'OK'
                });
                
                errorListener.remove();
            });

            console.log('Step 3: Register for push notifications...');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registering...';
            
            // Register (this should trigger one of the listeners above)
            await PushNotifications.register();
            
            console.log('Registration call completed, waiting for response...');
            
            // Set timeout for iOS specifically
            if (platform === 'ios') {
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Connecting to Apple...';
                
                setTimeout(() => {
                    // Check if still waiting after 10 seconds
                    if (btn.innerHTML.includes('Connecting to Apple')) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'iOS Registration Timeout',
                            html: `
                                <div style="text-align: left;">
                                    <p><strong>iOS push notification setup timed out.</strong></p>
                                    
                                    <div style="background: #ffebee; padding: 15px; border-radius: 4px; border-left: 4px solid #f44336; margin: 10px 0;">
                                        <strong>🎯 ROOT CAUSE: Missing APNS Certificate</strong>
                                        <p style="margin: 8px 0;">Your iOS app cannot connect to Apple's push notification servers because:</p>
                                        <ul style="margin: 5px 0; color: #d32f2f;">
                                            <li><strong>No APNS certificate uploaded to Firebase</strong></li>
                                            <li>Bundle ID mismatch</li>
                                            <li>Certificate configuration error</li>
                                        </ul>
                                    </div>
                                    
                                    <div style="background: #e3f2fd; padding: 10px; border-radius: 4px; margin: 10px 0;">
                                        <strong>🔧 SOLUTION:</strong>
                                        <ol style="margin: 5px 0;">
                                            <li><strong>Generate APNS certificate</strong> in Apple Developer Portal</li>
                                            <li><strong>Upload to Firebase Console</strong> → Project Settings → Cloud Messaging</li>
                                            <li><strong>Verify Bundle ID</strong> matches in all locations</li>
                                            <li><strong>Test again</strong> on real iOS device</li>
                                        </ol>
                                    </div>
                                </div>
                            `,
                            confirmButtonText: 'OK'
                        });
                        
                        // Clean up listeners
                        registrationListener.remove();
                        errorListener.remove();
                    }
                }, 10000); // 10 second timeout
            }
            // Add timeout for iOS registration
            const REGISTRATION_TIMEOUT = 15000; // 15 seconds
            let registrationTimer = null;
            let isRegistrationComplete = false;
            let currentStep = 'initializing';
            let stepDetails = {};

            // Set up error timeout for iOS
            registrationTimer = setTimeout(() => {
                if (!isRegistrationComplete) {
                    console.error('Registration timeout - no response after', REGISTRATION_TIMEOUT, 'ms');
                    console.error('Process stuck at step:', currentStep);
                    console.error('Step details:', stepDetails);
                    
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
                    
                    // Collect debug information
                    const debugInfo = {
                        platform: platform,
                        isCapacitor: isCapacitor,
                        userAgent: navigator.userAgent,
                        timestamp: new Date().toISOString(),
                        capacitorVersion: window.Capacitor?.version || 'unknown',
                        pluginAvailable: !!(window.Capacitor?.Plugins?.PushNotifications),
                        permissions: 'timeout-during-process',
                        timeoutAfterSeconds: REGISTRATION_TIMEOUT / 1000,
                        step: 'timeout-occurred',
                        currentStep: currentStep,
                        stepDetails: stepDetails,
                        stuckAt: `Process timed out while executing: ${currentStep}`
                    };
                    
                    if (platform === 'ios') {
                        Swal.fire({
                            icon: 'error',
                            title: 'iOS Registration Timeout',
                            html: `
                                <div style="text-align: left;">
                                    <p><strong>Push notification registration timed out after ${REGISTRATION_TIMEOUT/1000} seconds.</strong></p>
                                    
                                    <div style="background: #ffebee; padding: 10px; border-radius: 4px; border-left: 4px solid #f44336; margin: 10px 0;">
                                        <strong>🎯 Process stuck at:</strong> <code>${debugInfo.currentStep}</code><br>
                                        <strong>Details:</strong> ${debugInfo.stuckAt}
                                    </div>
                                    
                                    <details style="margin: 10px 0;">
                                        <summary style="cursor: pointer; font-weight: bold; color: #1976d2;">� Step Details (Tap to expand)</summary>
                                        <div style="background: #f5f5f5; padding: 10px; margin: 5px 0; border-radius: 4px; font-family: monospace; font-size: 11px;">
                                            <pre>${JSON.stringify(debugInfo.stepDetails, null, 2)}</pre>
                                        </div>
                                    </details>
                                    
                                    <details style="margin: 10px 0;">
                                        <summary style="cursor: pointer; font-weight: bold; color: #1976d2;">🐛 Full Debug Information (Tap to expand)</summary>
                                        <div style="background: #f5f5f5; padding: 10px; margin: 5px 0; border-radius: 4px; font-family: monospace; font-size: 10px; max-height: 200px; overflow-y: auto;">
                                            <pre>${JSON.stringify(debugInfo, null, 2)}</pre>
                                        </div>
                                    </details>
                                    
                                    ${debugInfo.currentStep.includes('permission') ? `
                                        <div style="background: #fff8e1; padding: 10px; border-radius: 4px; border-left: 4px solid #ffc107; margin: 10px 0;">
                                            <strong>⚠️ Permission Issue:</strong>
                                            <ul style="margin: 5px 0;">
                                                <li>iOS permission dialog may not be appearing</li>
                                                <li>System-level permission restrictions</li>
                                                <li>App not properly configured for notifications</li>
                                            </ul>
                                        </div>
                                    ` : debugInfo.currentStep === 'waiting-for-response' ? `
                                        <div style="background: #ffebee; padding: 15px; border-radius: 4px; border-left: 4px solid #f44336; margin: 10px 0;">
                                            <strong>🎯 IDENTIFIED ISSUE: APNS Certificate Missing</strong>
                                            <p style="margin: 8px 0;">The process is stuck waiting for Apple's push notification servers to respond. This means:</p>
                                            <ul style="margin: 5px 0; color: #d32f2f;">
                                                <li><strong>Missing APNS certificates in Firebase Console</strong></li>
                                                <li>Bundle ID mismatch between iOS app and Firebase</li>
                                                <li>APNS certificate not uploaded to Firebase project</li>
                                            </ul>
                                            <div style="background: #fff; padding: 10px; margin: 10px 0; border-radius: 4px;">
                                                <strong>🔧 Required Fix:</strong>
                                                <ol style="margin: 5px 0;">
                                                    <li>Generate APNS certificate in Apple Developer Portal</li>
                                                    <li>Upload certificate to Firebase Console → Cloud Messaging</li>
                                                    <li>Verify Bundle IDs match exactly</li>
                                                    <li>Test again on real iOS device</li>
                                                </ol>
                                            </div>
                                        </div>
                                    ` : debugInfo.currentStep.includes('register') || debugInfo.currentStep.includes('waiting') ? `
                                        <div style="background: #fff3e0; padding: 10px; border-radius: 4px; border-left: 4px solid #ff9800; margin: 10px 0;">
                                            <strong>🍎 APNS Connection Issue:</strong>
                                            <ul style="margin: 5px 0;">
                                                <li>Missing APNS certificates in Firebase</li>
                                                <li>Incorrect Bundle ID configuration</li>
                                                <li>Development vs Production certificate mismatch</li>
                                                <li>Network connectivity to Apple servers</li>
                                            </ul>
                                        </div>
                                    ` : `
                                        <div style="background: #e3f2fd; padding: 10px; border-radius: 4px; border-left: 4px solid #2196f3; margin: 10px 0;">
                                            <strong>🔧 Setup Issue:</strong>
                                            <ul style="margin: 5px 0;">
                                                <li>Capacitor plugin configuration</li>
                                                <li>Event listener setup problems</li>
                                                <li>iOS app entitlements missing</li>
                                            </ul>
                                        </div>
                                    `}
                                </div>
                            `,
                            width: '95%',
                            confirmButtonText: 'Copy Debug Info',
                            showCancelButton: true,
                            cancelButtonText: 'Close'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Copy debug info to clipboard
                                const debugText = `iOS Push Notification Debug Info:\n${JSON.stringify(debugInfo, null, 2)}`;
                                if (navigator.clipboard) {
                                    navigator.clipboard.writeText(debugText);
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Copied!',
                                        text: 'Debug information copied to clipboard',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Timeout',
                            html: `
                                <div style="text-align: left;">
                                    <p>Push notification registration timed out.</p>
                                    <details style="margin: 10px 0;">
                                        <summary style="cursor: pointer; font-weight: bold;">Debug Info</summary>
                                        <pre style="background: #f5f5f5; padding: 10px; font-size: 12px;">${JSON.stringify(debugInfo, null, 2)}</pre>
                                    </details>
                                </div>
                            `,
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }, REGISTRATION_TIMEOUT);

            // Request permission
            console.log('Requesting push notification permission...');
            let permStatus;
            
            try {
                currentStep = 'checking-permissions';
                stepDetails = { action: 'PushNotifications.checkPermissions()' };
                console.log('Step 1: Checking current permissions...');
                
                permStatus = await PushNotifications.checkPermissions();
                
                stepDetails = { ...stepDetails, result: permStatus };
                console.log('Step 1 Complete - Current permission status:', permStatus);
            } catch (permCheckError) {
                stepDetails = { ...stepDetails, error: permCheckError.message || permCheckError };
                console.error('Step 1 Failed - Error checking permissions:', permCheckError);
                clearTimeout(registrationTimer);
                throw new Error(`Permission check failed: ${permCheckError.message || permCheckError}`);
            }

            if (permStatus.receive === 'prompt' || permStatus.receive === 'prompt-with-rationale') {
                try {
                    currentStep = 'requesting-permissions';
                    stepDetails = { action: 'PushNotifications.requestPermissions()', currentStatus: permStatus.receive };
                    console.log('Step 2: Requesting permissions...');
                    
                    permStatus = await PushNotifications.requestPermissions();
                    
                    stepDetails = { ...stepDetails, result: permStatus };
                    console.log('Step 2 Complete - Permission after request:', permStatus);
                } catch (permRequestError) {
                    stepDetails = { ...stepDetails, error: permRequestError.message || permRequestError };
                    console.error('Step 2 Failed - Error requesting permissions:', permRequestError);
                    clearTimeout(registrationTimer);
                    throw new Error(`Permission request failed: ${permRequestError.message || permRequestError}`);
                }
            } else {
                currentStep = 'permissions-already-set';
                stepDetails = { action: 'skipped', reason: 'permissions already granted or denied', status: permStatus.receive };
                console.log('Step 2 Skipped - No permission request needed, current status:', permStatus.receive);
            }

            if (permStatus.receive !== 'granted') {
                clearTimeout(registrationTimer);
                
                // Show detailed permission error
                const permissionInfo = {
                    platform: platform,
                    permissionStatus: permStatus,
                    timestamp: new Date().toISOString(),
                    userAgent: navigator.userAgent,
                    step: 'permission-denied'
                };
                
                console.log('Step 3 Failed - Permission denied:', permissionInfo);
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Permission Denied',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>Push notification permission was denied or unavailable.</strong></p>
                            <p>Current status: <code>${permStatus.receive}</code></p>
                            
                            <details style="margin: 15px 0;">
                                <summary style="cursor: pointer; font-weight: bold; color: #ff9800;">📱 Permission Details (Tap to expand)</summary>
                                <div style="background: #fffbf0; padding: 10px; margin: 5px 0; border-radius: 4px;">
                                    <pre style="font-family: monospace; font-size: 11px; margin: 0;">${JSON.stringify(permissionInfo, null, 2)}</pre>
                                </div>
                            </details>
                            
                            <div style="background: #e3f2fd; padding: 10px; border-radius: 4px; margin: 10px 0;">
                                <strong>To enable notifications:</strong>
                                <ol style="margin: 5px 0;">
                                    <li>Go to device Settings</li>
                                    <li>Find this app in the app list</li>
                                    <li>Tap on Notifications</li>
                                    <li>Turn on "Allow Notifications"</li>
                                    <li>Return to this app and try again</li>
                                </ol>
                            </div>
                        </div>
                    `,
                    width: '90%',
                    confirmButtonText: 'Copy Permission Info',
                    showCancelButton: true,
                    cancelButtonText: 'Open Settings',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(JSON.stringify(permissionInfo, null, 2));
                        }
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Try to open app settings (may not work on all platforms)
                        if (window.Capacitor?.Plugins?.App?.openSettings) {
                            window.Capacitor.Plugins.App.openSettings();
                        }
                    }
                });
                
                throw new Error('Push notification permission was denied. Please enable it in your device settings.');
            }
            
            currentStep = 'permissions-verified';
            stepDetails = { status: 'permissions-granted', permissionStatus: permStatus };
            console.log('Step 3 Complete - Permissions granted, proceeding to registration...');

            // Listen for registration success (set up before register call)
            currentStep = 'setting-up-success-listener';
            stepDetails = { action: 'PushNotifications.addListener(registration)' };
            console.log('Step 4a: Setting up registration success listener...');
            
            const registrationListener = await PushNotifications.addListener('registration', async (token) => {
                console.log('Step 5 Complete - Push registration success, token:', token.value);
                isRegistrationComplete = true;
                clearTimeout(registrationTimer);
                
                try {
                    console.log('Step 6: Saving token to backend...');
                    // Save token to backend
                    await saveTokenToBackend(token.value, platform, btn);
                    console.log('Step 6 Complete - Token saved successfully');
                } catch (error) {
                    console.error('Step 6 Failed - Error saving token:', error);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
                } finally {
                    // Remove the listener after processing
                    registrationListener.remove();
                }
            });

            console.log('Step 4a Complete - Registration success listener set up');
            
            // Listen for registration error (set up before register call)
            currentStep = 'setting-up-error-listener';
            stepDetails = { action: 'PushNotifications.addListener(registrationError)' };
            console.log('Step 4b: Setting up registration error listener...');
            
            const errorListener = await PushNotifications.addListener('registrationError', (error) => {
                console.error('Step 5 Failed - Push registration error:', error);
                isRegistrationComplete = true;
                clearTimeout(registrationTimer);
                errorListener.remove();
                
                // Collect detailed error information
                const errorInfo = {
                    platform: platform,
                    error: error,
                    errorMessage: error.error || 'Unknown error',
                    timestamp: new Date().toISOString(),
                    capacitorVersion: window.Capacitor?.version || 'unknown',
                    userAgent: navigator.userAgent,
                    step: 'registration-error'
                };
                
                console.log('Detailed error info:', errorInfo);
                
                let errorMessage = 'Failed to register for push notifications';
                if (platform === 'ios') {
                    errorMessage = 'iOS push notification registration failed';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>${errorMessage}</strong></p>
                            <p>Error: ${errorInfo.errorMessage}</p>
                            
                            <details style="margin: 15px 0;">
                                <summary style="cursor: pointer; font-weight: bold; color: #d32f2f;">🔍 Technical Details (Tap to expand)</summary>
                                <div style="background: #ffebee; padding: 10px; margin: 5px 0; border-radius: 4px; border-left: 4px solid #f44336;">
                                    <pre style="font-family: monospace; font-size: 11px; margin: 0; white-space: pre-wrap;">${JSON.stringify(errorInfo, null, 2)}</pre>
                                </div>
                            </details>
                            
                            ${platform === 'ios' ? `
                                <div style="background: #fff3e0; padding: 10px; border-radius: 4px; border-left: 4px solid #ff9800; margin: 10px 0;">
                                    <strong>iOS-specific issues:</strong>
                                    <ul style="margin: 5px 0 0 0;">
                                        <li>Missing APNS certificates in Firebase</li>
                                        <li>Incorrect Bundle ID configuration</li>
                                        <li>Missing aps-environment entitlement</li>
                                        <li>Development vs Production certificate mismatch</li>
                                    </ul>
                                </div>
                            ` : ''}
                        </div>
                    `,
                    width: '90%',
                    confirmButtonText: 'Copy Error Details',
                    showCancelButton: true,
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const errorText = `Push Notification Error Details:\n${JSON.stringify(errorInfo, null, 2)}`;
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(errorText);
                            Swal.fire({
                                icon: 'info',
                                title: 'Copied!',
                                text: 'Error details copied to clipboard. Share this with your administrator.',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    }
                });
                
                btn.disabled = false;
                btn.innerHTML = '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
            });

            console.log('Step 4b Complete - Registration error listener set up');

            // Register for push notifications
            currentStep = 'calling-register';
            stepDetails = { action: 'PushNotifications.register()' };
            console.log('Step 5: Setting up event listeners complete, registering for push notifications...');
            
            try {
                await PushNotifications.register();
                
                currentStep = 'waiting-for-response';
                stepDetails = { action: 'waiting for APNS/FCM response', platform: platform };
                console.log('Step 5 Complete - Registration call made, waiting for response...');
            } catch (registerError) {
                stepDetails = { ...stepDetails, error: registerError.message || registerError };
                console.error('Step 5 Failed - Registration call failed:', registerError);
                clearTimeout(registrationTimer);
                throw new Error(`Registration call failed: ${registerError.message || registerError}`);
            }
            
            // For iOS, show additional info
            if (platform === 'ios') {
                console.log('iOS registration initiated - waiting for APNS response...');
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Connecting to Apple...';
            }

        } catch (error) {
            console.error('Capacitor notification error:', error);
            if (registrationTimer) {
                clearTimeout(registrationTimer);
            }
            
            // Enhanced error information for mobile debugging
            const generalErrorInfo = {
                platform: platform,
                error: error.message || error.toString(),
                errorType: error.constructor.name,
                stack: error.stack,
                timestamp: new Date().toISOString(),
                capacitorVersion: window.Capacitor?.version || 'unknown',
                pluginAvailable: !!(window.Capacitor?.Plugins?.PushNotifications),
                userAgent: navigator.userAgent
            };
            
            console.log('Complete error context:', generalErrorInfo);
            
            // Show detailed error popup for mobile
            Swal.fire({
                icon: 'error',
                title: 'Push Notification Error',
                html: `
                    <div style="text-align: left;">
                        <p><strong>An error occurred while setting up push notifications.</strong></p>
                        <p>Error: ${error.message || 'Unknown error'}</p>
                        
                        <details style="margin: 15px 0;">
                            <summary style="cursor: pointer; font-weight: bold; color: #d32f2f;">🛠️ Full Error Details (Tap to expand)</summary>
                            <div style="background: #ffebee; padding: 10px; margin: 5px 0; border-radius: 4px; max-height: 200px; overflow-y: auto;">
                                <pre style="font-family: monospace; font-size: 10px; margin: 0; white-space: pre-wrap;">${JSON.stringify(generalErrorInfo, null, 2)}</pre>
                            </div>
                        </details>
                        
                        <div style="background: #e8f5e8; padding: 10px; border-radius: 4px; margin: 10px 0;">
                            <strong>💡 Troubleshooting:</strong>
                            <ul style="margin: 5px 0;">
                                <li>Check your internet connection</li>
                                <li>Try closing and reopening the app</li>
                                <li>Restart your device</li>
                                <li>Contact support with error details</li>
                            </ul>
                        </div>
                    </div>
                `,
                width: '95%',
                confirmButtonText: 'Copy All Details',
                showCancelButton: true,
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fullErrorText = `Push Notification Complete Error Report:\n${JSON.stringify(generalErrorInfo, null, 2)}`;
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(fullErrorText);
                        Swal.fire({
                            icon: 'success',
                            title: 'Copied!',
                            text: 'Complete error details copied. Please share with technical support.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                }
            });
            
            throw error;
        }
    }

    // Web Browser Notification Handler
    async function handleWebNotifications(btn) {
        console.log('Handling web notifications...');
        
        // Check if browser supports notifications
        if (!('Notification' in window)) {
            throw new Error('This browser does not support notifications');
        }

        // Request permission
        const permission = await Notification.requestPermission();
        console.log('Web notification permission:', permission);

        if (permission === 'granted') {
            // Generate web token
            const webToken = 'web_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            console.log('Generated web token:', webToken);
            
            // Save token to backend
            await saveTokenToBackend(webToken, 'web', btn);
        } else if (permission === 'denied') {
            throw new Error('Notification permission was denied. Please enable it in your browser settings.');
        } else {
            // Permission dismissed
            closeNotificationModal();
        }
    }

    // Save token to backend
    async function saveTokenToBackend(deviceToken, platformType, btn) {
        try {
            console.log('Saving token to backend...', { deviceToken: deviceToken.substring(0, 30) + '...', platform: platformType });
            
            const response = await fetch('<?= base_url('api/device/register-token') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                body: JSON.stringify({
                    device_token: deviceToken,
                    platform: platformType,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                })
            });

            const data = await response.json();
            console.log('Backend response:', data);

            if (response.ok && data.success) {
                closeNotificationModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Enabled!',
                    text: 'Push notifications have been enabled successfully.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // Reload page to update the prompt status
                setTimeout(() => location.reload(), 2000);
            } else {
                // Show the actual error message from backend
                const errorMsg = data.messages?.error || data.message || 'Failed to register token';
                console.error('Backend error:', errorMsg);
                throw new Error(errorMsg);
            }
        } catch (error) {
            console.error('Error saving token to backend:', error);
            
            // Show error to user
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to save notification token. Please check console for details.',
                confirmButtonText: 'OK'
            });
            
            throw error;
        }
    }

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