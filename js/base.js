function addRobot(){
    alert("Új robotka!");
}

function robotMod(id){
    alert("Mod Robot ID: " + id);
}

function robotDel(id){
    if(window.confirm("Biztos hogy törli a robotot?")){
        $('#tr_'+id).remove(); 
        $.ajax({
            url: 'classes/robots/api.controll.php',
            type: 'POST',
            data: {
                    azonosito: id,
                    action: 'robot_torles'
                },
            success: function(data){
                var d = JSON.stringify(data);
                alert(d);
            }
        })
    }
}