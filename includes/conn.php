<?php
	$conn = new mysqli('localhost', 'dazzleli_root', 't20wI@dazzleli', 'dazzleli_votesystem');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>