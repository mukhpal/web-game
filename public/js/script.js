var userTable = $('#userTable').DataTable({
	'processing': true,
    'serverSide': true,
    "iDisplayLength": 10,
    'columnDefs': [ { orderable: false, targets: [0,3,5]}],
	'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
    'ajax': {
        'url':'{{URL::to("/userajaxdata")}}'
    }
});

function delete_row(rowid){
	let affected_data_model = $("#data_model").val();
	swal({
	  title: "Are you sure?",
	  text: "You will not be able to recover this user!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: "Yes, delete it!",
	  cancelButtonText: "No, cancel please!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	}, function (isConfirm) {
		if (isConfirm) {
		  $.ajax({
	          type:'POST',
	          url:'{{url("/deleterow")}}',
	          data:{"_token": "{{ csrf_token() }}", "rowid":rowid, "affected_data_model":affected_data_model},
	          success:function(data){
	            let obj = JSON.parse(data);
	            if(obj.code==200){
	            	userTable.ajax.reload();
	            	swal("Deleted!", obj.message, "success");
	            }else{
	                swal("Error Occured!",obj.message, "error");
	            }
	          }

	      });	
		}else{
			swal("Cancelled", "Your user is safe :)", "error");
		}

	});
}

$("#goBtt").click(function(){

    var selectedRowIds = [];
    $.each($("input[name='user_ids[]']:checked"), function(){            
        selectedRowIds.push($(this).val());
    });
    let actiontype = $("#actionDropdown").val(); let affected_data_model = $("#data_model").val();
    if(actiontype==""){
    	swal("Please select dropdown action.");
    	return false;
    }else{
    	let checkboxLength = $("input[name='user_ids[]']:checked").length;
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
	  confirmButtonText: "Yes, do it!",
	  cancelButtonText: "No, cancel please!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	}, function (isConfirm) {
		if (isConfirm) {
		  $.ajax({
	          type:'POST',
	          url:'{{url("/updatebulkrows")}}',
	          data:{"_token": "{{ csrf_token() }}", "rowids":selectedRowIds, "actiontype":actiontype, "affected_data_model":affected_data_model},
	          success:function(data){
	            let obj = JSON.parse(data);
	            if(obj.code==200){
	            	userTable.ajax.reload();
	            	swal("Done!", obj.message, "success");
	            }else{
	                swal("Error Occured!",obj.message, "error");
	            }
	          }

	      });	
		}else{
			swal("Cancelled", "Your performed action is calcelled :)", "error");
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