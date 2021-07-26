(function( $ ){
	var $unlock = $('#unlock').val();
	resetUnlock( $unlock );
	//overview questions form submissions
    $(".submit_btn").on('click', function(){

    	var activeQues = $(".activeQus").attr('id');
    	var skip = 1;
    	if( activeQues == 'question1'){
    		var $ans1 = $('.ans1').find(":selected").val();	
    		if($ans1 > 0){
    			skip = 0;
    		}
    	}

    	if( activeQues == 'question2'){
    		var $ans2 = $('.ans2').find(":selected").val();	
    		if($ans2 > 0){
    			skip = 0;
    		}
    	}

    	if( activeQues == 'question3'){
    		var $ans3 = $('.ans3').find(":selected").val();	
    		if($ans3 > 0){
    			skip = 0;
    		}
    	}

    	if(skip == 0){
	    	$.confirm({
			    title: 'Confirm!',
			    content: 'Are you sure?',
			    buttons: {
			        confirm: function () {
			            submitQues();
			        },
			        cancel: function () {
			        }
			    }
			});
    	}else{
    		alert('Please choose your answer first');
    	}
	});
	
	function submitQues (){
		$.ajax({
          	type: "POST",
          	url: $("#crimeinvestigation").data('url'),
          	data: $("#crimeinvestigation").serialize(),
          	success: function (result) {
          		if(result.lifes == 0){
          			resetLifes( result.lifes );
          			//game over
          			ciGameOverPop( result.teamname, result.html );
          		}else{
          			if(result.unlock == 3){
          				addNotiMenu();
          			}

          			if(result.unlock == 4){
						//Game result display
						var teamnamewithrank = result.teamname+" ( "+result.teamrank+" )";
						CiCaseSolved ( teamnamewithrank, result.html );
						  
	          		}else{
	          			if(result.unlock != $unlock){
		          			resetUnlock(result.unlock);
		          			unlockById(result.unlock);
		          		}
		          		if(result.ansbit == 1){
							goodjobmodel(result.msg);
							hintTimer ( result.hintMinutes, result.hintSeconds, $("input[name=encId]").val() );
		          		}else if(result.ansbit == 2){
							//update life on page
							resetLifes( result.lifes );
							CiIncorrectAns();
		          		}else{
							badluckmodel(result.msg);
						}
	          		}
          		}
          	}
        });
	}


	$(function () {
		$('.selectpicker').selectpicker();
	});

	// Set Time Out for Remaning Lifes
	(function ( $ ) {
		$.fn.addClassAndRemove = function(classAdd, timeAdd, timeRemove) {
		  let element = this;
		  let addIt = function(){
			   element.addClass(classAdd);
			};
		  let removeIt = function(){
			   element.removeClass(classAdd);
			};
		  setTimeout(function() { addIt(); setTimeout(removeIt, timeRemove); }, timeAdd);
		  return this;
		};
	}( jQuery ));
	
})( jQuery );

	