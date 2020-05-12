

<?php
$servername = "localhost";
$username = "sec_user";
$password = "greenChair153";
$database = "conlang";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

?>
