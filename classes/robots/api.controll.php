<?php
namespace robotwar\Robots;

include("{$_SERVER['DOCUMENT_ROOT']}/Classes/Robots/robots.php");
use robotwar\Settings\Connection;

if(isset($_POST['action'])){
    if($_POST['action'] == 'robotlist'){
        $robot = new Robots();
        $list = $robot ->getRobotList();
    }    
    
    if($_POST['action'] == 'robot_add'){
        $robot = new Robots();
        $robot->setNev($_POST['nev']);
        $robot->setTipus($_POST['tipus']);
        $robot->getRobotTipusEro($_POST['tipus']);
        if($robot->addNewRobot()){
            $res = array(
                    'response' => 1,
                    'message' => 'Rögzítés sikeres!'
                );
        }else{
            $res = array(
                    'response' => 0,
                    'message' => 'Hiba! A rögzítés sikertelen!',
                ); 
        }                
        echo json_encode($res);          
    }
    
    if($_POST['action'] == 'robot_del'){
        $robot = new Robots();
        $robot->setAzonosito($_POST['azonosito']);
        if($robot->deleteRobot()){
            $res = array(
                    'response' => 1,
                    'message' => 'Törlés sikeres!'
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

    if($_POST['action'] == 'robot_mod'){
        $robot = new Robots();
        $robot->setAzonosito($_POST['azonosito']);
        $robot->setNev($_POST['nev']);
        $robot->setTipus($_POST['tipus']);
        $robot->getRobotTipusEro($_POST['tipus']);
        if($robot->updateRobot()){            
            $res = array(
                    'response' => 1,
                    'message' => 'Módosítás sikeres!'
                );
        }else{
            $res = array(
                    'response' => 0,
                    'message' => 'Hiba! A módosítás sikertelen!'
                );
        }
        echo json_encode($res); 
    }
}