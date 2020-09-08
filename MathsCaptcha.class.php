<?php
class MathsCaptcha{
    
    private $operations=array("+","-","x",":");
    private $firstPosition;
    private $operation="";
    private $secondPosition;
    private $result;
    private $resulthash;
    
    
    
    function __construct($input=null){
        if($input!=null){
            $this->init($input);   
        }
    }
    
    function init($wishedOperation=null){
        if($wishedOperation==null){
            $operationIndex=random_int(0,count($this->operations)-1);
            
            $this->operation=$this->operations[$operationIndex];
        }else{
            $this->operation=$wishedOperation;
        }
        
        switch($this->operation){
            case "+":
                $this->createAddition();
                break;
            case "-":
                $this->createSubtraction();
                break;
            case "x":
                $this->createMultiplication();
                break;
            case ":":
                $this->createDivision();
                break;
                
        }
    }
    
    function evaluate($forminput,$existingHash){
        if(md5($forminput)==$existingHash){
            return true;
        }
        return false;
    }
    
    function getFirstPosition(){
        return $this->firstPosition;
    }
    function getSecondPosition(){
        return $this->secondPosition;
    }
    function getResult(){
        return $this->result;
    }
    
    function getResultHash(){
        return $this->resulthash;
    }
    
    function getMaths(){
        return $this->firstPosition." ".$this->operation." ".$this->secondPosition." = ";
    }
    
    private function createAddition(){
        $this->firstPosition=random_int(1,10);
        $this->secondPosition=random_int(1,10);
        $this->result=$this->firstPosition+$this->secondPosition;
        $this->resulthash=md5($this->result);
    }
    private function createSubtraction(){
        $one=random_int(1,10);
        $two=random_int(1,10);
        if($one>$two){
            $this->firstPosition=$one;
            $this->secondPosition=$two;
        }else{
            $this->firstPosition=$two;
            $this->secondPosition=$one;
        }
        
        $this->result=$this->firstPosition-$this->secondPosition;
        $this->resulthash=md5($this->result);
    }
    
    private function createMultiplication(){
        $this->firstPosition=random_int(2,10);
        $this->secondPosition=random_int(2,10);
        $this->result=$this->firstPosition*$this->secondPosition;
        $this->resulthash=md5($this->result);
    }
    
    private function createDivision(){
        $captcha = new MathsCaptcha("x");
        $this->firstPosition=$captcha->getResult();
        $this->secondPosition=$captcha->getFirstPosition();
        $this->result=$captcha->getSecondPosition();
        $this->resulthash=md5($this->result);
    }
    
}