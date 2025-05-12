
<script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/daterangepicker.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/circle-progress.min.js')}}"></script>
<script src="{{asset('assets/js/common-init.min.js')}}"></script>
<script src="{{asset('assets/js/dashboard-init.min.js')}}"></script>
<script src="{{asset('assets/js/theme-customizer-init.min.js')}}"></script>

    <script src="{{asset('admin/assets/js/toastr.min.js')}}"> </script>
    <script src="{{asset('admin/assets/js/toast.js')}}"> </script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


    <script>
        $(document).ready(function() {
            var success_message = "{{ Session::get('success') }}";
            if (success_message) {
                toastSuccess(success_message);
            }

            var error_message = "{{ Session::get('error') }}";
            if (error_message) {
                toastdanger(error_message);
            }

        });
        function toastSuccess(success_message) {
            toastr.remove();
            toastr.options.positionClass = "toast-top-right";
            toastr.success(success_message);
        }

        function toastdanger(error_message) {
            toastr.remove();
            toastr.options.positionClass = "toast-top-right";
            toastr.error(error_message);
        }
    </script>
<script>
    document.getElementById('logout-link').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });
</script>


@stack('scripts')
