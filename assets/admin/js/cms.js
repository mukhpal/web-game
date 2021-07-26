(function( $ ){
	$.ajaxSetup({
	  headers: {
		  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});
	
	IsEmail = function (email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(!regex.test(email)) {
		  return false;
		}else{
		  return true;
		}
	};

	isNumberPhone = function (evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
	  
		if (charCode > 31
		&& (charCode < 48 || charCode > 57)) {
		  return false;
		}
		return true;
	};
	
	$.validator.addMethod("dollarsscents", function(value, element) {
		return this.optional(element) || /^\d+(\.\d{0,2})?$/i.test(value);
	}, "Only two decimal places are allowed.");

	$.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[0-9a-zA-Z\s]+$/i.test(value);
	}, "Enter only alphanumeric");

	$.validator.addMethod("accept", function(value, element, param) {
		//return this.optional(element) || value.match(new RegExp("." + param + "$"));
		if( param ) { 
		var regex = /^[a-zA-Z\s']+$/;
		return this.optional(element) || ( regex.test( value ) );
		}
	});

	$.validator.addMethod("charapostrophe", function(value, element, param) {
		//return this.optional(element) || value.match(new RegExp("." + param + "$"));
		if( param ) { 
		var regex = /^[a-zA-Z]+$/;
		return this.optional(element) || ( regex.test( value ) );
		}
	});

	$.validator.addMethod("isEmail", function(value, element, param) {
		if( param ) { 
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return ( regex.test( value ) );
		}
	});


	deleteImage = function ( url, $currentObj ) { 
	swal({
		title: "Are you sure?",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: false
	  },
	  function(){ 
		swal.close();
		$.ajax({
			url     : url,
			type    : 'POST',
			data    : {},
			dataType: 'json',
			error:  function ( xhr, status, error ) { 
				swal( 'Error!', 'Unable to delete, please try again later.', 'error' );
			},
			success : function ( json ) { 
				if( json.status == 0 ){ 
				  swal( 'Error!', json.msg, 'error' );
				} else { 
				  swal( 'Deleted!', json.msg, 'success' );
				  $( $currentObj ).closest( '.img-wrap' ).remove();
				}
			}
		});
	  });
	};

	list = function ( obj ) { 

	  if( typeof obj == typeof undefined || !( typeof obj.listing_url != typeof undefined && obj.listing_url ) ) return false;
	  if( !( typeof obj.reorder != typeof undefined && obj.reorder ) ) obj.reorder = false;

	  $ajaxObj = {
				"url": obj.listing_url,
				"type": "POST",
				"error": function(){
				  swal( 'Error!', 'Unable to load, please try again later.', 'error' );
				}
			};
	  if( typeof obj.ajaxData != typeof undefined ) { 
		  $ajaxObj.data = obj.ajaxData;
	  }

	  var params = {
					"processing": true,
					"serverSide": true,
					"ajax": $ajaxObj,
					'oLanguage': {'sProcessing': '<div class="datatable_loading" style="display:block;">Loading&#8230;</div>'},
					"drawCallback": function( settings ) {
						var pagination = $( this ).closest( '.dataTables_wrapper' ).find( '.dataTables_paginate' );
						pagination.toggle( this.api( ).page.info( ).pages > 1 );
						if( typeof obj.drawCallback != typeof undefined ) { 
							obj.drawCallback( settings, this );
						}
					},
					"fnCreatedRow": function( nRow, aData, iDataIndex ) {
						$(nRow).attr('id', "tr_"+iDataIndex);
					},
					"fnDrawCallback": function (o) {
					  $('html,body').animate({scrollTop: 0}, 500);
					}
				};
	  if( obj.reorder ) { 
		params.rowReorder = { update: false, selector: 'td:nth-child(2)' };
	  }
	  if( typeof obj.order != typeof undefined && obj.order ) { 
		params.order = [ obj.order ];
	  }
	  
	  if( typeof obj.orderable != typeof undefined && obj.orderable ) { 
		params.columnDefs = [ obj.orderable ];
	  } else { 
		params.ordering = false;
	  }

	  var table = $( '#datatable' ).DataTable( params );

	  if( obj.reorder && typeof obj.reorder_url != typeof undefined && obj.reorder_url ) { 
		table.on('row-reorder', function ( e, diff, edit ) { 
			
			var reOrderData = { 'replace_ids':{} };
			if( diff.length > 0 ) { 
			  $upOrDown = diff[0].oldPosition - diff[0].newPosition == 1?'down':'up';
			  for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
				  var rowData = table.row( diff[i].node ).data( );

				  if( $upOrDown == 'down' ) {  
					var $newIndex = ( i == 0 )?ien-1:i-1;
				  } else { 
					var $newIndex = ( i == ien-1 )?0:i+1;
				  }

				  var replacedData = table.row( diff[$newIndex].node ).data( );

				  reOrderData.replace_ids[ rowData[ obj.idIndex ] ] = replacedData[ obj.orderIndex ];
			  }

			  $.ajax({
				  url     : obj.reorder_url,
				  type    : 'POST',
				  data    : reOrderData,
				  dataType: 'json',
				  error:  function ( xhr, status, error ) { 
					  swal( 'Error!', 'Unable to update order, please try again later.', 'error' );
				  },
				  success : function ( json ) { 
					  if( json.errors ){ 
						swal( 'Error!', json.errors, 'error' );
					  } else { 
						swal( 'Updated!', json.success, 'success' );
						table.ajax.reload( null, false );
					  }
				  }
			  });
			}

		});

	  }
	  
	  return table;
	};

	deleteOne = function( ids ){
		deleteRecords({
		  url: importantObj.delete_url,
		  ids: [ids],
		  listObj: listDTObj
		});
		return false;
	};

	deleteRecords = function ( _obj ) { 
		swal({
			title: "Are you sure?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete!",
			closeOnConfirm: false
		  },
		  function(){ 
			swal.close();
			$.ajax({
				url     : _obj.url,
				type    : 'POST',
				data    : {ids:_obj.ids},
				dataType: 'json',
				error:  function ( xhr, status, error ) { 
					swal( 'Error!', 'Unable to delete, please try again later.', 'error' );
				},
				success : function ( json ) { 
					if( json.status == 0 ){ 
					  swal( 'Error!', json.msg, 'error' );
					} else { 
					  swal( 'Deleted!', json.msg, 'success' );
					  _obj.listObj.draw();
					}
				}
			});
		  });
	};

	$( document ).ready(function(){
		/*$( '#apply-action' ).on('click', function(){
			var _selectedAction = $( '#action' ).val();
			if( !_selectedAction ) {
				swal({
					title: "Select an action",
					type: "warning"
				  });
				return false;
			}

			if( _selectedAction == 1 ) { 
				var $idsObj = $('input[name="ids[]"]:checked');
				if( $idsObj.length <= 0 ) { 
					swal({
						title: "Select at least one faq",
						type: "warning"
					  });
					return false;
				}

				var $ids = $idsObj.map(function(){
					return $(this).val();
				  }).get();

				deleteRecords({
					url: importantObj.delete_url,
					ids: $ids,
					listObj: listDTObj
				  });
				  return false;
			}

		});*/

		$('.alphabetsOnly').keydown(function (e) {
			// if (e.shiftKey || e.ctrlKey || e.altKey) {
			if ( e.altKey) {
				e.preventDefault();
			} else {
				var key = e.keyCode;
				console.log(key);
				/*if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					e.preventDefault();
				}*/
				if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90) || (key == 222) )) { 
				  e.preventDefault();
			  }
			}
		});

		$( document ).on( 'keydown', '.price', function (event) {

			if (event.shiftKey == true) {
				event.preventDefault();
			}
	  
			if ( !( (event.keyCode >= 48 && event.keyCode <= 57) || 
				(event.keyCode >= 96 && event.keyCode <= 105) || 
				event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
				event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110 ) ) { 
				event.preventDefault();
			}
	  
			if($(this).val().indexOf('.') !== -1 && ( event.keyCode == 190 || event.keyCode == 110 )) event.preventDefault(); 
			
			text = $( this ).val();
	  
			if ( 
			  ( text.indexOf( '.' ) == -1 ) &&
			  ( event.which == 110 || event.which == 190 ) &&
			  ( $( this ) [ 0 ].selectionStart >= 9 ) 
			) {
				  event.preventDefault();
			}
		  
			if ( 
			  ( text.indexOf( '.' ) != -1 ) &&
			  ( text.substring( text.indexOf( '.' ) ).length > 2 ) && 
			  ( event.which != 0 && event.which != 8 ) &&
			  ( $( this ) [ 0 ].selectionStart >= text.length - 2 ) 
			) {
				  event.preventDefault();
			}

		});

		$( document ).on('change', 'input[name="ids[]"]', function(){
			if( $( 'input[name="ids[]"]' ).length == $( 'input[name="ids[]"]:checked' ).length ) { 
				$( '#checkAll' ).prop( 'checked', true );
			} else { 
				$( '#checkAll' ).prop( 'checked', false );
			}
		});
	});
	
})( $ );
