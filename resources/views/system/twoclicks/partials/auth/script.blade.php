<!--begin::Javascript-->
<script>
    var hostUrl = "{{ asset('system/metronic8/demo34/assets/') }}/";
</script>
<!--begin::Global Javascript Bundle-->
<script src="{{ asset('system/metronic8/demo34/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('system/metronic8/demo34/assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript-->
<!--end::Custom Javascript-->
@stack('scripts')
<!--end::Javascript-->