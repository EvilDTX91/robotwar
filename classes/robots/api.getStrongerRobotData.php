<?php
namespace robotwar\Robots;

include("{$_SERVER['DOCUMENT_ROOT']}/Classes/Robots/robots.php");
use robotwar\Settings\Connection;

//API híváshoz
//http://robotwar/classes/Robots/api.getStrongerRobotData.php?robot1=11&robot2=12
if((isset($_GET['robot1']) && is_numeric($_GET['robot1']) && isset($_GET['robot2']) && is_numeric($_GET['robot2']))
        || (isset($_POST['robot1']) && is_numeric($_POST['robot1']) && isset($_POST['robot2']) && is_numeric($_POST['robot2']))){
    if($_GET['robot1'] > 0 && $_GET['robot2'] > 0){
        $robot1 = $_GET['robot1'];
        $robot2 = $_GET['robot2'];
    }else{
        $robot1 = $_POST['robot1'];
        $robot2 = $_POST['robot2'];        
    }
    if($robot1 > 0 && $robot2 > 0){
        $robot = new Robots();
        $winner = $robot->fightRobots($robot1, $robot2);
        $robot->setAzonosito($winner);
        $winner_data = $robot->getRobot();
        if($winner_data){
            $res = $winner_data;
        }else{            
            $res = array(
                    'response' => 0,
                    'message' => 'Hiba! Az adatlekérés sikertelen!'
                );
        }
        echo json_encode($res);         
    }   
}else{         
    $res = array(
            'response' => 0,
            'message' => 'Hiba! Az adatlekérés sikertelen!'
        );
        echo json_encode($res);     
}
