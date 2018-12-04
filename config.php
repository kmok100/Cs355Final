<?php
	$servername = "mars.cs.qc.cuny.edu";
  //First 2 letters of last name, then first 2 letters of first name, then last 4 of qc id
	$username = "";
  //qc id
	$password = "";
  //same as username
	$dbname = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
?>