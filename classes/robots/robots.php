<?php

namespace robotwar\robots;

use robotwar\settings\Connection;

class Robots{
    private $connectionDriver;
    private $azonosito;
    private $nev;
    private $tipus;
    private $ero;    
    private $robot_types = array(
         '0' => 'Brawler',
         '1' => 'Rouge',
         '2' => 'Assault',
    );

    private $robot_power = array(
         '0' => '1',
         '1' => '2',
         '2' => '3',
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
    
    public function getRobotPower($robot_types){
        if(!empty($robot_types)){    
            return $robot_power[$robot_types];
        }else{
            return false;
        }        
    }


    public function getRobotList(){
        $this->setConnectionDriver(new Connection);
        $sql_sel = "SELECT *
                        FROM robots";
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
                                    '" . $this->tipus . "',
                                    '" . $this->ero . "'";

            if($this->getConnectionDriver()->getConnection()->query($sql_ins)) {
                echo "</br>Új robot hozzáadva!</br>";
            }else{
                echo "Error: " . $sql . "<br>" . mysqli_error($connect);
            } 
        }else{
            return false;
        }       
    }
        
    public function deleteRobot(){
        if(!empty($this->azonosito)){           
            $this->setConnectionDriver(new Connection);            
            $sql_upd = "UPDATE robots
                            SET statusz = 0
                            WHERE azonosito = " . $this->azonosito;
            $this->getConnectionDriver()->getConnection()->query($sql_ins);            
        }        
    }
    
    public function updateRobot(){
        if(!empty($this->azonosito)){           
            $this->setConnectionDriver(new Connection);            
            $sql_upd = "UPDATE robots
                            SET nev = ".$this->nev."
                                tipus = ".$this->tipus."
                                ero = ".$this->ero."
                            WHERE azonosito = " . $this->azonosito;
            $this->getConnectionDriver()->getConnection()->query($sql_ins);            
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
