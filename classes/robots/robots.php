<?php

namespace robotwar\Robots;

include("{$_SERVER['DOCUMENT_ROOT']}/Classes/Settings/connection.php");
use robotwar\Settings\Connection;

class Robots{
    private $connectionDriver;
    private $azonosito;
    private $nev;
    private $tipus;
    private $ero;    
    private $robot_types = array(
         1 => 'Brawler',
         2 => 'Rouge',
         3 => 'Assault',
    );

    private $robot_power = array(
         1 => 1,
         2 => 2,
         3 => 3,
    );    
    
    function getAzonosito() {
        return $this->azonosito;
    }

    function getNev() {
        return $this->nev;
    }

    function getTipus() {
        return $this->tipus;
    }

    function getEro() {
        return $this->ero;
    }

    function setAzonosito($azonosito): void {
        $this->azonosito = $azonosito;
    }

    function setNev($nev): void {
        $this->nev = $nev;
    }

    function setTipus($tipus): void {
        $this->tipus = $tipus;
    }

    function setEro($ero): void {
        $this->ero = $ero;
    }
    
    public function getConnectionDriver(): Connection
    {
        return $this->connectionDriver;
    }

    public function setConnectionDriver(Connection $connectionDriver): void
    {
        $this->connectionDriver = $connectionDriver;
    }
    
    public function getAllRobotTypes(){          
        return $this->robot_types;
    }
    
    public function getAllRobotPower(){        
        return $this->$robot_power;
    }
    
    public function getRobotTypeName($robot_types){
        if(!empty($robot_types)){    
            return $this->robot_types[$robot_types];
        }else{
            return false;
        }        
    }
    
    public function getRobotTipusEro($robot_types){
        if(!empty($robot_types)){    
            $this->ero = $this->robot_power[$robot_types];
            return $this->ero;
        }else{
            return false;
        }        
    }


    public function getRobotList(){
        $this->setConnectionDriver(new Connection);
        $sql_sel = "SELECT *
                        FROM robots
                        WHERE statusz = 1";
        $result = $this->getConnectionDriver()->getConnection()->query($sql_sel);
        
        $res = $result->fetch_all(MYSQLI_ASSOC);
        
        foreach($res AS $r){
            $r['tipus'] = $this->getRobotTypeName($r['tipus']);
        }
        
        if(!empty($res)){
            return $res;
        }else{
            return false;
        }
    }
    
    public function getRobot() {       
        if(!empty($this->azonosito)){            
            $this->setConnectionDriver(new Connection);
            $sql_sel = "SELECT *
                            FROM robots
                            WHERE azonosito = " . $this->azonosito;
            $result = $this->getConnectionDriver()->getConnection()->query($sql_sel);

            $res = $result->fetch_all(MYSQLI_ASSOC);
        }        
    }
    
    public function addNewRobot(){
        if(!empty($this->nev) && !empty($this->tipus) && !empty($this->ero)){            
            $this->setConnectionDriver(new Connection);            

            $sql_ins = "INSERT INTO robots (nev, tipus, ero)
                            VALUES ('" . $this->nev . "',
                                    " . $this->tipus . ",
                                    " . $this->ero . ")";

            if($this->getConnectionDriver()->getConnection()->query($sql_ins)) {
                return true;
            }else{
                return false;
            } 
        }else{
            return false;
        }       
    }
        
    public function deleteRobot(){
        if(!empty($this->azonosito)){           
            $this->setConnectionDriver(new Connection);            
            $sql_del = "UPDATE robots
                            SET statusz = 0
                            WHERE azonosito = " . $this->azonosito;
                 
            if($this->getConnectionDriver()->getConnection()->query($sql_del)){
                return true;
            }else{
                return false;
            }
        }        
    }
    
    public function updateRobot(){
        if(!empty($this->azonosito)){           
            $this->setConnectionDriver(new Connection);            
            $sql_upd = "UPDATE robots
                            SET nev = '".$this->nev."',
                                tipus = ".$this->tipus.",
                                ero = ".$this->ero."
                            WHERE azonosito = " . $this->azonosito;

            if($this->getConnectionDriver()->getConnection()->query($sql_upd)){
                return true;
            }else{
                return false;
            }
        }        
    }
    
    public function fightRobots($r1, $r2){
        if(!empty($r1) && !empty($r2)){   
            $winner = 0;
            $this->azonosito = $r1;
            $robot1 = $this->getRobot();
            $this->azonosito = $r2;
            $robot1 = $this->getRobot();

            if($robot1['ero'] > $robot2['ero']){
                $winner = $robot1['azonosito'];
            }else if($robot1['ero'] < $robot2['ero']){
                $winner = $robot2['azonosito'];
            }else{
                if($robot1['letrehozva'] > $robot2['letrehozva']){
                    $winner = $robot1['azonosito'];                    
                }else{
                    $winner = $robot2['azonosito'];                                    
                }
            } 
            if($winner > 0){
                return $winner;
            }else{
                return false;
            }
        }       
    }
}
