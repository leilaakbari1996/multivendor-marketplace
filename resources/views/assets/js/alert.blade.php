<script src="{{ asset('admin/src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
<script>
    window.LaravelFlash = {
        success: @json(session('success')),
        error:   @json(session('error')),
        warning: @json(session('warning')),
        info:    @json(session('info')),
    };
</script>
<script src="{{ asset('admin/custom/js/alert.js') }}"></script>
