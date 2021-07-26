
function crossover() {

    //arr = [];
    //var unassignedTeamUsersUrl = $('#unassignedTeamUsersUrl').attr('url');

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////CROSSOVER FUNCTIONALITY///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
    /*var DataArr = ['Chaperone', 'Jade Rabbit', 'Wardcliff Coil',
                'Tractor Cannon', 'Sweet Business', 'Thorn',
                'Graviton Lance', 'Wavesplitter', 'Telesto',
                'Black Splindle', 'Polaris Lance', 'Ace of Spades'];*/
    /*var DataArr = [];
    $.ajax({
        type:'GET',
        url : unassignedTeamUsersUrl,
        data:"",
        success:function(ItemsList){
            //alert(ItemsList);
            var result = $.parseJSON(ItemsList);
            $.each(result, function(i, e){
                DataArr.push(e.name);
            });

            console.log(DataArr);
      }

    });*/

    //var DataArr = [];
    //populateItems(DataArr, '#items');

    //add btn
    var addUserSelected = [];
    
    $('#selected option').each(function() {
        addUserSelected.push($(this).val());
    });

    $('#crossover-btn-add').click(function() {
            
        var count = $('#selected option').length;
        var selected = $('select#items').val();
        if(count==teamSize){
            swal("Error!","You cannot add more than "+teamSize+" users in a team.", "error");
            return false;
        }else{
            var totCnt = selected.length + count;
            if(totCnt > teamSize){
               swal("Error!","You cannot add more than "+teamSize+" users in a team.", "error");
               return false; 
            }
        }

        let userlist = "";
        if(selected!=""){
            var userExistUrl = $("#userExistUrl").attr('url'); var token = $('input[name="_token"]').val();
            var team_id = $("#team_id").val();
            $.ajax({
              type:'POST',
              url: userExistUrl,
              data: {"_token": token, "users":selected, "team_id":team_id},
              success:function(data){            
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(key,value) {
                  //alert(value);
                  userlist += value+",";
                }); 
                if(userlist!=""){
                    swal("Error Occured!", userlist + " already exist in other team(s)", "error");
                }else{
                    $("#items option:selected").each(function() {
                        addUserSelected.push($(this).val());
                    });

                    $("#selected_users").val(addUserSelected);
                    //alert(addUserSelected);
                    $("#items option:selected").remove();
                    generateOptionElements(selected, '#selected');
                }
              }

            });
        }


    });
    
    //remove btn
    $('#crossover-btn-remove').click(function() {
        addUserSelected = [];
        var selected = $('select#selected').val(); 

        $('#selected option:selected').remove();
        $('#items option').each(function() {
            selected.push($(this).val());
        });
        
        $('#items option').remove();
        selected.sort();  

        $('#selected option').each(function() {
            addUserSelected.push($(this).val());
        });
        $("#selected_users").val(addUserSelected);
        generateOptionElements(selected, '#items');
    });

    //add all btn
   /* $('#crossover-btn-add-all').click(function() {
        var selected = [];
        $('#items option').each(function() {
            selected.push($(this).val());
        });

        $('#items option').remove();
        
        generateOptionElements(selected, '#selected');
    });*/

    //remove all btn
    /*$('#crossover-btn-remove-all').click(function() {
        var selected = [];
        $('#items option').each(function() {
            selected.push($(this).val());
        });

        $('#selected option').each(function() {
            selected.push($(this).val());
        });
        
        $('#items option').remove();
        $('#selected option').remove();
        selected.sort();

        generateOptionElements(selected, '#items');
    });*/
    
    //populate items box with arr
    function populateItems(arr, targetMultiSelect) {
        arr.sort();
        generateOptionElements(arr, targetMultiSelect);
    }
    
    //temporarily add a new item to the crossover
   /* $('#add-new-item-btn').click(function() {
        if ($('#new-item-input').val() !== '') {
            var selected = [];
            selected.push($('#new-item-input').val().trim());
    
            $('#selected option').each(function() {
                selected.push($(this).val()); 
            });
    
            selected.sort();
            $('#selected').empty();
    
            generateOptionElements(selected, '#selected');
    
            $('#new-item-input').val('');
        }
    });*/
    
    //reset demo
    /*$('#reset-btn').click(function() {
        $('#items').empty();
        $('#selected').empty();
        populateItems(DataArr, '#items');
    });*/
    
    
///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////MINI FUNCTIONS TO AVOID REPEAT CODE///////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
        
//create option elements
    function generateOptionElements(arr, targetMultiSelect) {
        for (var i = 0; i < arr.length; i++) {
            $(targetMultiSelect).append('<option value="'+arr[i]+'">'+arr[i]+'</option>');
        }
    }
};




