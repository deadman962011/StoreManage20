




<script src="http://127.0.0.1/cdn/jquery/jquery.dataTables.min.js"></script>
<script src="http://127.0.0.1/cdn/store-manage/dataTables.bootstrap.min.js"></script>
<script src="http://127.0.0.1/cdn/datatables-responsive/dataTables.responsive.js"></script>
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
