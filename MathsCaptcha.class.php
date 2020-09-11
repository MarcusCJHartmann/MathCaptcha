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
	
	function getSVGMaths(){
		$first=$this->getNumberAsSVG($this->firstPosition);
		$operation=$this->getOperationAsSVG($this->operation);
		$second=$this->getNumberAsSVG($this->secondPosition);
		$equ=$this->getOperationAsSVG("=");
		return $first." ".$operation." ".$second." ".$equ." ";
	}
	
	private function getOperationAsSVG($op){
		switch($op){
			case "+":
			return "<span>".str_replace(PHP_EOL,"",trim(file_get_contents(__DIR__."/svg/plus.svg")))."</span>";
			break;
			case "-":
			return "<span>".str_replace(PHP_EOL,"",trim(file_get_contents(__DIR__."/svg/minus.svg")))."</span>";
			break;
			case "x":
			return "<span>".str_replace(PHP_EOL,"",trim(file_get_contents(__DIR__."/svg/by.svg")))."</span>";
			break;
			case ":":
			return "<span>".str_replace(PHP_EOL,"",trim(file_get_contents(__DIR__."/svg/div.svg")))."</span>";
			break;
			case "=":
			return "<span>".str_replace(PHP_EOL,"",trim(file_get_contents(__DIR__."/svg/eq.svg")))."</span>";
			break;
		}
	}
	private function getNumberAsSVG($number){
	
		$str="$number";
		$strArgs=str_split($str);

		$svgArgs=array();
		foreach($strArgs as $key=> $number){
			$svgArgs[]="<span>".str_replace(PHP_EOL,"",trim(file_get_contents(__DIR__."/svg/".$number.".svg")))."</span>";
		}

		
		$svgString=implode(PHP_EOL,$svgArgs);
		return $svgString;
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