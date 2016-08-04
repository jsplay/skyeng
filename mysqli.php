<?php

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

$conn->query("SET CHARACTER SET 'utf8'");
$conn->query("set character_set_client='utf8'");
$conn->query("set character_set_results='utf8'");
$conn->query("set collation_connection='utf8_general_ci'");
$conn->query("SET NAMES utf8");

?>