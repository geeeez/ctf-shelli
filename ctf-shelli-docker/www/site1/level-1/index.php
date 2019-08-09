<?php
show_source("index.php");
if(isset($_GET['your_shell']) && strlen($_GET['your_shell']) <=4){

	echo(exec($_GET['your_shell']));
}
else{

	echo "your shell too long or none";
}

?>
