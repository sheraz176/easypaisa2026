
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

    <script src="{{asset('assets/vendors/js/tagify.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/tagify-data.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/quill.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/select2-active.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/proposal-create-init.min.js')}}"></script>

    <script>
       $(document).ready(function() {
           var i = 1;
           $("#add_row").click(function() {
               b = i - 1;
               $("#addr" + i)
                   .html($("#addr" + b).html())
                   .find("td:first-child")
                   .html(i + 1);
               $("#tab_logic").append('<tr id="addr' + (i + 1) + '"></tr>');
               i++;
           });
           $("#delete_row").click(function() {
               if (i > 1) {
                   $("#addr" + (i - 1)).html("");
                   i--;
               }
               calc();
           });
           $("#tab_logic tbody").on("keyup change", function() {
               calc();
           });
           $("#tax").on("keyup change", function() {
               calc_total();
           });
       });

       function calc() {
           $("#tab_logic tbody tr").each(function(i, element) {
               var html = $(this).html();
               if (html != "") {
                   var qty = $(this).find(".qty").val();
                   var price = $(this).find(".price").val();
                   $(this)
                       .find(".total")
                       .val(qty * price);
                   calc_total();
               }
           });
       }

       function calc_total() {
           total = 0;
           $(".total").each(function() {
               total += parseInt($(this).val());
           });
           $("#sub_total").val(total.toFixed(2));
           tax_sum = (total / 100) * $("#tax").val();
           $("#tax_amount").val(tax_sum.toFixed(2));
           $("#total_amount").val((tax_sum + total).toFixed(2));
       }
   </script>


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
