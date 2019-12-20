<?php

echo "<h1>PDO demo!</h1>";
$username = 'krd37';
$password = 'ynHTDUCWz';
$hostname = 'sql1.njit.edu';
$dsn = "mysql:host=$hostname;dbname=$username";
try {
    $db = new PDO($dsn, $username, $password);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
?>

