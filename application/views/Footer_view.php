<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<script type="text/javascript">
    //To disable back button
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>
<!--Data Table Default Style-->
<style>
    table.dataTable, table.table-bordered th:last-child, table.table-bordered td:last-child{
        border: 1px solid #000000;
    }
    table.dataTable thead{
        background-color: #337AB7;
        color: #FFFFFF;
    }
    table.dataTable thead tr th {
        background-color: #337AB7;
        color: #FFFFFF;
        border: 1px solid #000000;
        text-align: center;
        font-weight: bold;
        padding: 6px;
    }
    table.dataTable tbody tr td {
        border: 1px solid #000000;
        text-align: center;
        padding: 6px;
    }
    #MTD_S.dataTable tbody tr td:not(.client),  #RECON_S.dataTable tbody tr td:not(.client) {
        border: 1px solid #000000;
        text-align: right;
        padding: 6px;
    }
    #MTD_S.dataTable tbody tr td.category,  #RECON_S.dataTable tbody tr td.category {
        border: 1px solid #000000;
        text-align: center;
        padding: 6px;
    }
    #MTD_S.dataTable tbody tr td.client,  #RECON_S.dataTable tbody tr td.client {
        font-weight: bold;
    }
    .dataTables_filter{ 
        margin-right: 20px;
    }
    .dataTables_filter input[type=search]{ 
        height: 3rem;
    }
    .dataTables_info{
        margin-left: 10px;
    }
    div.dataTables_paginate{
        margin-right: 20px;
    }
    table.dataTable tfoot {
        display: table-header-group;
    }
    table.dataTable tfoot td, table.dataTable tfoot th {
        border: 1px solid #000000;
        text-align: Center;
        color: #000000;
    }
    input:invalid {
        color: #FF0000;
    }
</style>
<!--Data Tables Calls & Attributes-->
<script type="text/javascript">
    $(document).ready( function () {
        $('#MTD_S').DataTable({
            "ordering": false,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#RECON_S').DataTable({
            "ordering": false,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#AllotLog tbody').on( 'click', 'tr', function (){
            $(this).toggleClass('active');
        });
        $('#MissingEOB').DataTable({
            "ordering": true,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#QueryLog').DataTable({
            "ordering": true,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#PROD_S').DataTable({
            "ordering": true,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#Facility_List').DataTable({
            "ordering": true,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#Leads_List').DataTable({
            "ordering": true,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#Associate_List').DataTable({
            "ordering": true,
            "processing": true,
            "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#PT').DataTable({
             "processing": true,
             "lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "All"]]
        });
        $('#PM1').DataTable({
            "lengthChange": false, 
            "ordering": false,
            "info": false,
            "paging": false,
            "filter":false
        });
        $('#PM2').DataTable({
            "lengthChange": false, 
            "ordering": false,
            "info": false,
            "paging": false,
            "filter":false
        });
    });
</script> 
<!--RECON & MTD Page Dates-->
<script type="text/javascript">
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    //Create variable for last day of next month
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 2, 0);
    $(function (){
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date();
        $('#sdate').datetimepicker({  
            format: "YYYY-MM-DD",
            minDate: firstDay, 
            maxDate: lastDay
        });
    });
    $(document).ready(function() {
        $('#RECON_S').each(function() {
            var $table = $(this);
            $table.find('.parent').click(function() {
                $(this).nextUntil('.parent').toggle(); 
            });
            var $childRows = $table.find('tbody tr').not('.parent').hide();
            $table.find('button.hide').click(function() {$childRows.hide();});
            $table.find('button.show').click(function() {$childRows.show();});
        });
    }); 
    $(function () {
        var firstDay = new Date(date.getFullYear(), date.getMonth() - 2, 1);
        var lastDay = new Date();
        $('#mtdsdate').datetimepicker({  
            format: "YYYY-MM",
            minDate: firstDay, 
            maxDate: lastDay,
        });
    });
</script>
<!--//Export Table Fucntion-->
<script type="text/javascript">
    function Export(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';
        // Create download link element
        downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }
        else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            // Setting the file name
            downloadLink.download = filename;
            //triggering the function
            downloadLink.click();
        }
    }
</script>
</html>