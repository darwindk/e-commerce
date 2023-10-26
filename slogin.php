<?php

$servername = "localhost";
$username = "id21124130_darwin";
$password = "Darwin@6"; 
$dbname = "id21124130_yes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $EventID = $_POST["EventID"];
    $Eventname = $_POST["Eventname"];
     $date = $_POST["date"];
    $time = $_POST["time"];
     $Eventprice = $_POST["Eventprice"];
    $createdby = $_POST["createdby"];

    $sql = "INSERT INTO login(EventID,Eventname,date,time,Eventprice,createdby) VALUES ('EventID','Eventname','date','time','Eventprice','createdby')";
    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close(); 
}
?>
