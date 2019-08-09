<?php
  show_source("level-3.php");  
  $file_name = $_GET["path"];
  if(!preg_match("/^[a-zA-Z0-9-s_]+.txt$/m", $file_name)) {
        echo "regex failed";
  }else {
	echo $file_name;
        echo exec("cat " . $file_name);
      }
?>
