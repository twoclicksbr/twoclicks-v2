<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
@include('system.twoclicks.partials.system.head')
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    @include('system.twoclicks.partials.system.theme')
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            @include('system.twoclicks.partials.system.header')
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Toolbar-->
                @include('system.twoclicks.partials.system.toolbar')
                <!--end::Toolbar-->
                <!--begin::Wrapper container-->
                <div class="app-container container-xxl">
                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Content-->
                            @yield('content')
                            <!--end::Content-->
                        </div>
                        <!--end::Content wrapper-->
                        <!--begin::Footer-->
                        @include('system.twoclicks.partials.system.footer')
                        <!--end::Footer-->
                    </div>
                    <!--end:::Main-->
                </div>
                <!--end::Wrapper container-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
    <!--begin::Drawers-->
    <!--begin::Activities drawer-->
    @include('system.twoclicks.partials.system.drawers.activities')
    <!--end::Activities drawer-->
    <!--begin::Chat drawer-->
    @include('system.twoclicks.partials.system.drawers.chat')
    <!--end::Chat drawer-->
    <!--begin::shooping drawer-->
    @include('system.twoclicks.partials.system.drawers.shooping')
    <!--end::shooping drawer-->
    <!--end::Drawers-->
    <!--begin::Scrolltop-->
    @include('system.twoclicks.partials.system.drawers.scrolltop')
    <!--end::Scrolltop-->
    <!--begin::Modals-->
    <!--begin::Modal - Upgrade plan-->
    @include('system.twoclicks.partials.system.modals.upgrade-plan')
    <!--end::Modal - Upgrade plan-->
    <!--begin::Modal - Invite Friends-->
    @include('system.twoclicks.partials.system.modals.invite_friends')
    <!--end::Modal - Invite Friend-->
    <!--begin::Modal - New Target-->
    @include('system.twoclicks.partials.system.modals.new_target')
    <!--end::Modal - New Target-->
    <!--begin::Modal - Create App-->
    @include('system.twoclicks.partials.system.modals.create_app')
    <!--end::Modal - Create App-->
    <!--begin::Modal - Users Search-->
    @include('system.twoclicks.partials.system.modals.users_search')
    <!--end::Modal - Users Search-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    @include('system.twoclicks.partials.system.script')
</body>
<!--end::Body-->

</html>
