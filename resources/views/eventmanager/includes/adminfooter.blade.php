<!-- Essential javascripts for application to work-->

  
<!-- <link href="http://demos.codexworld.com/bootstrap-datetimepicker-add-date-time-picker-input-field/css/bootstrap-datetimepicker.css" rel="stylesheet"> -->
<script type="text/javascript" src="{{asset('assets/event_manager/js/plugins/bootstrap-datepicker.min.js')}}"></script>
<!-- <script src="{{asset('assets/event_manager/js/bootstrap-datetimepicker.min.js')}}"></script>  -->


<script src="{{asset('assets/event_manager/js/popper.min.js')}}"></script>
<script src="{{asset('assets/event_manager/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/event_manager/js/jquery-ui.min.js') }}"></script>
<script src="{{asset('assets/event_manager/js/script.js') }}"></script>

<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('assets/event_manager/js/plugins/pace.min.js')}}"></script>
<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="{{asset('assets/event_manager/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/event_manager/js/plugins/dataTables.bootstrap.min.js')}}"></script>

<script src="{{asset('assets/event_manager/js/sweetalert.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/event_manager/css/sweetalert.css')}}">
<script src="{{asset('assets/event_manager/js/main.js')}}"></script>
  
<!-- Timepicker css & js lib -->  
<script src="{{asset('assets/event_manager/js/jquery.timepicker.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('assets/event_manager/css/jquery.timepicker.min.css')}}">

<!-- Full celendar files -->
  <link rel="stylesheet" href="{{asset('assets/event_manager/css/fullcalendar.css')}}">
  <link rel="stylesheet" href="{{asset('assets/event_manager/css/jquery-ui.min.css')}}">
  <script src="{{asset('assets/event_manager/js/moment.min.js')}}"></script>
  <script src="{{asset('assets/event_manager/js/fullcalendar.min.js')}}"></script>
<!-- Ends here celendar -->


<script type="text/javascript">

$('.loader').hide();

$(document).ajaxStart(function(){
  // Show image container
  $(".loader").show();
});
$(document).ajaxComplete(function(){
  // Hide image container
  $(".loader").hide();
});

<?php 
  $eventId = !isset($eventId) ? '' : $eventId;
?>

var eventTable = $('#surveyTable').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: []}],  // add array column value which you do not want to sort
    "order": [[2, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("eventmanager.surveyajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

var eventTable = $('#eventMembers').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [2]}],  // add array column value which you do not want to sort
    "order": [[1, 'asc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("eventmanager.eventajaxmembers", $eventId) }}'
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
    'columnDefs': [ { orderable: false, targets: [0,5]}],
    "order": [[4, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("eventmanager.userajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});

var teamTable = $('#teamTable').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [0,4]}],
    "order": [[3, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("eventmanager.teamajaxdata") }}'
    },
    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        $(nRow).attr('id', "tr_"+iDataIndex);
    },
    "fnDrawCallback": function (o) {
      $('html,body').animate({scrollTop: 0}, 500);
    }
});
var eventTable = $('#eventTable').DataTable({
    'processing': true,
    'serverSide': true,
    'iDisplayLength': 10,
    'columnDefs': [ { orderable: false, targets: [0,4,5]}],
    "order": [[2, 'desc']],
    'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{ route("eventmanager.eventajaxdata") }}'
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
	            	teamTable.ajax.reload();userTable.ajax.reload();eventTable.ajax.reload();
	            	swal("Deleted!", obj.message, "success");
	            }else{
	                swal("Error Occured!",obj.message, "error");
	            }
	          }

	      });	
		}

	});
}

function delete_child(rowid, name, index){
  $("#tr_"+index).css("background","#c1c1c1");
  let affected_data_model = $("#parent_model").val();
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
                teamTable.ajax.reload();userTable.ajax.reload();eventTable.ajax.reload();
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
                  teamTable.ajax.reload();userTable.ajax.reload();eventTable.ajax.reload();
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
  if ($(this).hasClass('allChecked')) {
      $('input[type="checkbox"]').prop('checked', false);
  } else {
      $('input[type="checkbox"]').prop('checked', true);      
  }
  $(this).toggleClass('allChecked');
});


</script>
<!-- <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script>  CKEDITOR.replace( 'email_template' ); </script> -->

<script type="text/javascript" src="{{asset('assets/event_manager/js/plugins/chart.js')}}"></script>
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

      function fetchstates (country ,stateId = 0){
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


<script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
      left:'prev,next today',
      center:'title',
      right:''
    },
    events: "<?=url('/').'/event_manager/eventslistajax'?>",
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
      // alert('clicked on blank date box');
    },
    editable:true,

    eventClick:function(event)
    {
      // alert("clickec on particular Event: "+event.title + " \nStart Time: "+event.start+" \nEnds on: "+event.end);
    },

   });

    $('.ui-timepicker-input').keypress(function (event) {
        return isNumber(event, this)
    });

    $( "#user_email" ).autocomplete({
          source: function( request, response ) {              
              $.ajax({
                  url: "{{ route('eventmanager.emaillist') }}",
                  type: 'post',
                  dataType: "json",
                  data: {
                      "_token": "{{ csrf_token() }}",search: request.term, selectedIds: $("#blank-input").val()
                  },
                  success: function( data ) {
                      response( data );
                  }
              });
          },
          select: function (event, ui) {
              $('#user_email').val(ui.item.value); // display the selected text
              getEmailDataFilled( ui.item.value );
              return false;
          }
      });

  });

$( "#user_email" ).change(function() {
  var email = $( "#user_email" ).val();
  getEmailDataFilled( email );
});

  function getEmailDataFilled ( email ){
    $.ajax({
      url: "{{ route('eventmanager.getemailIdata') }}",
      type: 'post',
      data: {
          "_token": "{{ csrf_token() }}",email: email,
      },
      success: function( data ) {
        if ( data.length != 0 ) {
          $("input[name='fullname']").val(data.name).prop('readonly', true);
          $("select[name=country]").val(data.coutry_id).prop('disabled', true);
          fetchstates(data.coutry_id, data.state_id);
          $("select[name=state]").prop('disabled', true);
        }else{
          $("input[name='fullname']").val('').prop('readonly', false);
          $("select[name=country]").val('').prop('disabled', false);
          $("select[name=state]").val('').prop('disabled', false);
        }
      }
    });
  }

    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 58 || $(element).val().indexOf(':') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }  
  </script>