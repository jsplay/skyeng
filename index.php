<?php

require_once "config.php";
require_once "mysqli.php";
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$twig->getExtension('core')->setTimezone('Europe/Moscow');
$template = $twig->loadTemplate('index.html');

// showing all clients
$query  = "SELECT *
			FROM clients
			LEFT JOIN client_status
			ON clients.status_id = client_status.status_id
			ORDER BY clients.id ASC";

$result = $conn->query($query);
if (!$result) die($conn->error);

$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j)
{
	$result->data_seek($j);
	$row[] = $result->fetch_array(MYSQLI_ASSOC);
}

// Get all possible clients statuses
$query  = "SELECT * FROM client_status";
$result = $conn->query($query);
if (!$result) die($conn->error);

$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j)
{
	$result->data_seek($j);
	$srow[] = $result->fetch_array(MYSQLI_ASSOC);
}

echo $twig->render('index.html', array(
	'clients' => $row,
	'statuses' => $srow
));

$result->close();
$conn->close();

?>