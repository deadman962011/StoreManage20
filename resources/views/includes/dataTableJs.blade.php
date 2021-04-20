




<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
@if (app()->getLocale() =="ar")

<script>
$(document).ready(function() {
  $('#dataTable').dataTable({
    "language":{
            "url":"http://127.0.0.1/cdn/store-manage/Arabic.json"
    },
    resposive:true,
    scrollX:true,
    scrollCollapse:true
});
} );
</script>
@else
    
<script>
    $(document).ready(function() {
      $('#dataTable').dataTable({
        responsive:true,
        scrollX:true,
        scrollCollapse:true
      });
      });
    </script>
@endif
