<?php
show_source("level-2.php");
function hwaf($value){
    $filter = "<|>|php|curl|0x|\\|python|gcc|less|root|etc|pass|http|ftp|cd|bash|tcp|udp|cat|×|fl|ag|flag|ph|hp|wget|type|ty||$[IFS]|sh";
    if (preg_match("/".$filter."/is",$value)==1){
	echo $value;  
        exit('Waf wang~wang');
    }
    else{
    	echo(exec($value));
    }
}

hwaf($_GET['your_shell']);
//[\w\d]+\.[\w\d]+
?>
