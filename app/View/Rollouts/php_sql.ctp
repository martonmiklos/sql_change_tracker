<?php 
echo nl2br(htmlspecialchars('
<?php
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
'));
foreach ($changes as $id => $change) {
	echo nl2br('

		$sql = "'.$change.'";
		if ($conn->query($sql) === TRUE) {
			echo "Query #'.$id.' => OK";
		} else {
			echo "Error during SQL query: '.$change.': " . $conn->error;
		}
		');
}

echo htmlspecialchars('$conn->close();');

?>