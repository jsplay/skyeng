<?php

require_once "config.php";
require_once "mysqli.php";

if(isset($_POST['statusid']) && !empty($_POST['statusid']) && isset($_POST['clientid']) && !empty($_POST['clientid']) )
{
    $statusid = intval($_POST['statusid']);
    $clientid = intval($_POST['clientid']);
    
    $query = "UPDATE clients SET status_id=" . $statusid . " WHERE id=" . $clientid;

    $result = $conn->query($query);
    if (!$result) die($conn->error);
    else echo "ok";
} else if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['surname']) && !empty($_POST['surname']) && isset($_POST['phone']) && !empty($_POST['phone']) )
{
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = intval($_POST['phone']);
    // sanitizing
    $conn->real_escape_string($name);
    $conn->real_escape_string($surname);
    
    $query = "INSERT INTO clients (name, surname, phone) VALUES ('$name', '$surname', '$phone')";

    $result = $conn->query($query);
    if (!$result) die($conn->error);
    else echo "ok";
}

?>