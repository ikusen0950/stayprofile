<?= $this->include('layout/header.php') ?>


<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar  pt-5 ">

            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch ">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">

                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6 d-none d-lg-flex">

                            <!--begin::Item-->
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                <a href="/saul-html-pro/index.html" class="text-gray-500 text-hover-primary">
                                    <i class="ki-duotone ki-home fs-3 text-gray-500 me-n1"></i>
                                </a>
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                            </li>
                            <!--end::Item-->


                            <!--begin::Item-->
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                Apps </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                            </li>
                            <!--end::Item-->


                            <!--begin::Item-->
                            <li class="breadcrumb-item text-gray-700">
                                Calendar </li>
                            <!--end::Item-->


                        </ul>
                        <!--end::Breadcrumb-->

                        <!--begin::Title-->
                        <h1
                            class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 lh-0">
                            Calendar
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->

                    <!--begin::Actions-->
                    <a href="#" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create_app">
                        Create Project</span>
                    </a>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">


            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">
                            Calendar
                        </h2>

                        <div class="card-toolbar">
                            <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add Event
                            </button>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->

    </div>
    <!--end::Content wrapper-->


    <!--begin::Footer-->
    <?= $this->include('layout/footer.php') ?>
    <!--end::Footer-->