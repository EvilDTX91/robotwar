function addRobot(){  
    var name = $('#recipient-name').val();
    var type = $('#robotTypeSelect').find(":selected").val();
    $.ajax({
            url: 'classes/robots/api.controll.php',
            type: 'POST',
            data: {
                    nev: name,
                    tipus: type,
                    action: 'robot_add'
                },
            success: function(data){
                var res = JSON.parse(data);
                alert(res.message);
                $('#robotWarModal').modal('toggle');                
                location.reload();     
            }
    })
}

function robotAddOpen(){  
    robotTypeList();
    $('#saveModalButton').attr('onClick', 'addRobot();');
}

function robotMod(id){    
    var name = $('#recipient-name').val();
    var type = $('#robotTypeSelect').find(":selected").val();
    $.ajax({
            url: 'classes/robots/api.controll.php',
            type: 'POST',
            data: {
                    azonosito: id,
                    nev: name,
                    tipus: type,
                    action: 'robot_mod'
                },
            success: function(data){
                var res = JSON.parse(data);
                alert(res.message);
                $('#robotWarModal').modal('toggle');
                location.reload();   
            }
    })
}

function robotModOpen(id){
    var name = $('#nev_' + id).val();
    var type = $('#tipus_' + id).val();
    $('#recipient-name').val(name);
    $('#recipient-type').val(type);    
    robotTypeList();
    $('select option[value="'+type+'"]').attr("selected",true);    
    $('#saveModalButton').attr('onClick', 'robotMod('+id+');');
}

function robotDel(id){
    if(window.confirm("Biztos hogy törli a robotot?")){
        $('#tr_'+id).remove(); 
        $.ajax({
            url: 'classes/robots/api.controll.php',
            type: 'POST',
            data: {
                    azonosito: id,
                    action: 'robot_del'
                },
            success: function(data){
                var res = JSON.parse(data);
                alert(res.message);
                location.reload();   
            }
        })
    }
}

function robotBattle(){
    var n = $( "input:checked" ).length;
    if(n == 2){        
        var checkedValue = $('#form-check:checked').val();
        
        var robots = [];
        $(':checkbox:checked').each(function(i){
          robots[i] = $(this).val();
        });
        
        $.ajax({
                url: 'classes/robots/api.controll.php',
                type: 'POST',
                data: {
                    action: 'robot_battle',
                    robots: robots,
                },
                success: function(data){
                    var res = JSON.parse(data);
                    if(res.response == 0){
                        alert(res.message);                        
                    }else{
                        showWinnerData(res);                        
                        alert("A győztes " + res.nev + "!");
                    }
                }
        })
    }else{
        if(n < 2){
            alert("A harchoz két robot kijelölése szükséges!");
        }else{
            alert("A harcban két robot vehet részt!");            
        }
    }
}

function showWinnerData(data){
    $('.winner_robot_div').removeClass('hidden');
    var message = "Győztes robot adatai:<br/><br/>Azonosító: " + data.azonosito + "<br/>Név: " + data.nev + "<br/>Típus: " + data.tipus_nev + "<br/>Erő: " + data.ero + "<br/>Létrehozva: " + data.letrehozva
    $('#winner_p').html(message);
}

function selectRow(id){
    var chkbox = $('#check_' + id).is(":checked");
    if(chkbox){
        $('#check_' + id).prop('checked', false);
    }else{
        $('#check_' + id).prop('checked', true);        
    }
}

function robotGetStrongerDataApi($robot1, $robot2){
    if($robot1 > 0 && $robot2 > 0){
        $.ajax({
            url: 'classes/robots/api.getStrongerRobotData.php',
            type: 'POST',
            data: {
                robot1: $robot1,
                robot2: $robot2
            },
            success: function(data){                
            }
        })
    }
}

function robotTypeList(){
    $.ajax({
        url: 'classes/robots/api.controll.php',
        type: 'POST',
        data: {action: 'get_robot_types'},
        success: function(data){
            var obj = JSON.parse(data);
            $('#robotTypeSelect').empty();
            var dropdown = document.getElementById('robotTypeSelect');
            for (i = 0; i < obj.length; i++) {
                option = document.createElement('option');
                option.text = obj[i].tipus;
                option.value = i+1;
                dropdown.add(option);
            } 
        }
    })
}