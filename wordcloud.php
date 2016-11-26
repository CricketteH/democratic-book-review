<?php 

	$id = $_GET("id");
	
	$servername = 'localhost';
	$username = 'root';
	$password = 'root';
	$database = 'books';
	
	// Create connection
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	if ($mysqli->connect_errno) {
		echo('could not connect to database');
	}//if
	
	$query = "SELECT * from keyword WHERE Bookid = " . $id;

	$wordArray = [];
	
	$result = $mysqli->query($query);
	
	$i = 0;
	
	if($result->num_rows > 0){
		
		while ($word = $result->fetch_assoc()) {
			
			$wordArray[i] = [$word['Word'], $word['Num']];
			$i++;
		}
	} 
	
	$result->free();
	$mysqli->close();
	
	echo json_encode($wordArray);
?>