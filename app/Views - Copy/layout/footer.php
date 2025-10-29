<!--begin::Footer-->
    <div id="kt_app_footer"
        class="app-footer  align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3 ">



        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1"><?= date('Y') ?>&copy;</span>
            <span class="me-1">Crafted with ❤️ by</span>
            <i class="ki-duotone ki-square-brackets fs-3 text-danger me-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>
            <a href="/" target="_blank" class="text-danger text-hover-danger">Short Script</a>
        </div>
        <!--end::Copyright-->

        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item"><a class="menu-link px-2">Version: 3.0.1</a></li>

            <li class="menu-item"><a class="menu-link px-2">Build: 25.11.2025.301</a></li>

        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Footer-->
</div>
<!--end:::Main-->


</div>
<!--end::Wrapper-->


</div>
<!--end::Page-->
</div>
<!--end::App-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
</div>
<!--end::Scrolltop-->


<!--begin::Javascript-->
<script>
var hostUrl = "/assets/";
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used for this page only)-->
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->

<!--begin::AOS Initialization-->
<script>
// Initialize AOS (Animate On Scroll) globally
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true,
            mirror: false,
            offset: 50,
            delay: 0
        });
    }
});
</script>
<!--end::AOS Initialization-->


<!--end::Javascript-->
</body>
<!--end::Body-->

</html>