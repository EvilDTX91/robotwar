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
                var d = JSON.stringify(data);
                $('#robotWarModal').modal('toggle');
                alert(d);
            }
    })
}

function robotAddOpen(){
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
                var d = JSON.stringify(data);
                $('#robotWarModal').modal('toggle');
                alert(d);
            }
    })
}

function robotModOpen(id){
    var name = $('#nev_' + id).val();
    var type = $('#tipus_' + id).val();
    $('#recipient-name').val(name);
    $('#recipient-type').val(type);    
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
                var d = JSON.stringify(data);
                alert(d);
            }
        })
    }
}