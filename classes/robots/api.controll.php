<?php
namespace robotwar\Robots;

include("{$_SERVER['DOCUMENT_ROOT']}/Classes/Robots/robots.php");
use robotwar\Settings\Connection;

if(isset($_POST['action'])){
    if($_POST['action'] == 'robotlist'){
        $robot = new Robots();
        $list = $robot ->getRobotList();
    }    
    
    if($_POST['action'] == 'robot_torles'){
        $robot = new Robots();
        $robot->setAzonosito($_POST['azonosito']);
        if($robot->deleteRobot()){
            $res = array(
                    'response' => 1,
                    'message' => 'Siker!'
                );
        }else{
            $res = array(
                    'response' => 0,
                    'message' => 'Hiba! A törlés sikertelen!',
                    'id' => $_POST['azonosito']
                ); 
        }        
        
        echo json_encode($res);       
    }    
}