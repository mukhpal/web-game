<!-- Essential javascripts for application to work-->

<script src="{{asset('assets/admin/js/popper.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/script.js') }}"></script>

<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('assets/admin/js/plugins/pace.min.js')}}"></script>
<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="{{asset('assets/admin/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/plugins/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script> 

<script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/admin/css/sweetalert.css')}}">
<script src="{{asset('assets/admin/js/main.js')}}"></script>

@stack('after_scripts')


<script type="text/javascript">

<?php 
  $eventId = !isset($eventId) ? '' : $eventId;
?>

var eventTable = $('#eventTable').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [0]}],  // add array column value which you do not want to sort
    "order": [[3, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("admin.eventajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

var userTable = $('#userTable').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [0,5,6]}],
    "order": [[4, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("admin.userajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

var eventMembers = $('#eventMembers').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [2]}],  // add array column value which you do not want to sort
    "order": [[1, 'asc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("admin.eventajaxmembers", $eventId) }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

var surveyTable = $('#surveyTable').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: []}],  // add array column value which you do not want to sort
    "order": [[2, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("admin.surveyajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

var eventmanagerTable = $('#eventmanagerTable').DataTable({
	  'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [0,6]}], // add array column value which you do not want to sort
    "order": [[5, 'desc']],
	  'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("admin.eventmanagerajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

var cropsTable = $('#cropsTable').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [0,5]}], // add array column value which you do not want to sort
    "order": [[4, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("admin.cropajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

function delete_row(rowid, name, index){

  $("#tr_"+index).css("background","#c1c1c1");

	let affected_data_model = $("#data_model").val();
	swal({
	  title: "Are you sure?",
	  text: "You will not be able to recover "+name+"!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: "Yes, delete it!"
	}, function (isConfirm) {
		if (isConfirm) {
		  $.ajax({
	          type:'POST',
	          url:'{{ route("admin.deleterow") }}',
	          data:{"_token": "{{ csrf_token() }}", "rowid":rowid, "affected_data_model":affected_data_model},
	          success:function(data){
	            let obj = JSON.parse(data);
	            if(obj.code==200){
	            	location.reload(true);
	            	swal("Deleted!", obj.message, "success");
	            }else{
	             swal("Error Occured!",obj.message, "error");
	            }
	          }

	      });	
		}

	});
}


$("#goBtt").click(function(){

    var selectedRowIds = [];
    $.each($("input[name='ids[]']:checked"), function(){            
        selectedRowIds.push($(this).val());
    });
    let actiontype = $("#actionDropdown").val(); let affected_data_model = $("#data_model").val();
    if(actiontype==""){
    	swal("Please select dropdown action.");
    	return false;
    }else{
    	let checkboxLength = $("input[name='ids[]']:checked").length;
    	if(checkboxLength==0){
    	  swal("Please check atleast one checkbox.");
    	  return false;
    	}
    }
    swal({
	  title: "Are you sure you want to perform this action?",
	  text: "",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: "Yes, do it!"
	}, function (isConfirm) {
		if (isConfirm) {
		  $.ajax({
	          type:'POST',
	          url:'{{ route("admin.updatebulkrows") }}',
	          data:{"_token": "{{ csrf_token() }}", "rowids":selectedRowIds, "actiontype":actiontype, "affected_data_model":affected_data_model},
	          success:function(data){
	            let obj = JSON.parse(data);
              $('input[type="checkbox"]').prop('checked', false);
              $('#actionDropdown').prop('selectedIndex',"");
	            if(obj.code==200){
	            	eventmanagerTable.ajax.reload(); eventTable.ajax.relod();
	            	swal("Done!", obj.message, "success");
	            }else{
	                swal("Error Occured!",obj.message, "error");
	            }
	          }

	      });	
		}else{
      $('input[type="checkbox"]').prop('checked', false);
      $('#actionDropdown').prop('selectedIndex',"");
    }

	});


});


//var allPages = userTable.fnGetNodes();
      
$('body').on('click', '#checkAll', function () {
  if($(this).hasClass('allChecked')) {
      $('input[type="checkbox"]').prop('checked', false);
  }else {
      $('input[type="checkbox"]').prop('checked', true);      
  }
  $(this).toggleClass('allChecked');
});


</script>
<!-- <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script>  CKEDITOR.replace( 'email_template' ); </script> -->

<script type="text/javascript" src="{{asset('assets/admin/js/plugins/chart.js')}}"></script>
    <script type="text/javascript">
      var data = {
      	labels: ["January", "February", "March", "April", "May"],
      	datasets: [
      		{
      			label: "My First dataset",
      			fillColor: "rgba(220,220,220,0.2)",
      			strokeColor: "rgba(220,220,220,1)",
      			pointColor: "rgba(220,220,220,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(220,220,220,1)",
      			data: [65, 59, 80, 81, 56]
      		},
      		{
      			label: "My Second dataset",
      			fillColor: "rgba(151,187,205,0.2)",
      			strokeColor: "rgba(151,187,205,1)",
      			pointColor: "rgba(151,187,205,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(151,187,205,1)",
      			data: [28, 48, 40, 19, 86]
      		}
      	]
      };
      var pdata = [
      	{
      		value: 300,
      		color: "#46BFBD",
      		highlight: "#5AD3D1",
      		label: "Complete"
      	},
      	{
      		value: 50,
      		color:"#F7464A",
      		highlight: "#FF5A5E",
      		label: "In-Progress"
      	}
      ]
      
      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);
      
      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);



     function fetchstates (country ,stateId=0){
        var url = "<?=url('/').'/event_manager/loadstates/'?>"+country+"/"+stateId;
        $.ajax({
          type: "GET",
          url: url,
          success: function(result){
            $("#state_tab").html(result);
          }
        });
      }
      
    </script>