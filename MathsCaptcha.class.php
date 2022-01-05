<?php
class MathsCaptcha{
    
    private $operations=array("+","-","x",":");
    private $firstPosition;
    private $operation="";
    private $secondPosition;
    private $result;
    private $resulthash;
    
    function __construct($wishedOperation=null){
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

    function getCaptcha(){

        ob_start();
        ?>
        <div style="display:inline-block;">
        <?php
        echo $this->getSVGMaths();
        ?>
        <input type="text" name="_captcha_solution" value="-" style="width:40px;font-size:1em;border:0px;background:#ccc;text-align:center;" onclick="if(this.value=='-'){select()}" required>
        </div>
        <input type="hidden" name="_captcha_hash" value="<?php echo $this->resulthash ?>">
        <?php
        echo ob_get_clean();
    }
    
    static function verify($forminput,$existingHash){
        return password_verify($forminput,$existingHash);
    }
    
    private function getFirstPosition(){
        return $this->firstPosition;
    }
    private function getSecondPosition(){
        return $this->secondPosition;
    }
    private function getResult(){
        return $this->result;
    }
    
    function getResultHash(){
        return $this->resulthash;
    }
    
    private function getMaths(){
        return $this->firstPosition." ".$this->operation." ".$this->secondPosition." = ";
    }
	
	private function getSVGMaths(){
		$first=$this->getNumberAsSVG($this->firstPosition);
		$operation=$this->getOperationAsSVG($this->operation);
		$second=$this->getNumberAsSVG($this->secondPosition);
		$equ=$this->getOperationAsSVG("=");
		return "<div style='display:inline-block;'>".$first."".$operation."".$second."".$equ." </div>";
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
		
		$svgString=implode("",$svgArgs);
		return $svgString;
	}
    
    private function createAddition(){
        $this->firstPosition=random_int(1,10);
        $this->secondPosition=random_int(1,10);
        $this->result=$this->firstPosition+$this->secondPosition;
        $this->resulthash=password_hash($this->result, PASSWORD_DEFAULT );
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
        $this->resulthash=password_hash($this->result, PASSWORD_DEFAULT );
    }
    
    private function createMultiplication(){
        $this->firstPosition=random_int(2,5);
        $this->secondPosition=random_int(2,5);
        $this->result=$this->firstPosition*$this->secondPosition;
        $this->resulthash=password_hash($this->result, PASSWORD_DEFAULT );
    }
    
    private function createDivision(){
        $captcha = new MathsCaptcha("x");
        $this->firstPosition=$captcha->getResult();
        $this->secondPosition=$captcha->getFirstPosition();
        $this->result=$captcha->getSecondPosition();
        $this->resulthash=password_hash($this->result, PASSWORD_DEFAULT );
    }
}