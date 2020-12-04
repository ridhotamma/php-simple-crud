<?php 

	// connect to the database
	$conn = mysqli_connect('localhost', 'ridho', 'ridho2002', 'ninjas_pizza');

	// check connection
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}

?>