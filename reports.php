<?php

require_once "config.php";
require_once "mysqli.php";
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$twig->getExtension('core')->setTimezone('Europe/Moscow');
$template = $twig->loadTemplate('reports.html');

date_default_timezone_set('Europe/Moscow');

// period length (in days)
if(isset($_GET['days']) && !empty($_GET['days']) )
{
    $pl = intval($_GET['days']);
} else {
	$pl = 30;	
}

// start date (first client joined)
$query = "SELECT datetime
			FROM clients
			ORDER by datetime ASC
			LIMIT 1";
$result = $conn->query($query);
if (!$result) die($conn->error);

$result->data_seek($j);
$row = $result->fetch_row();
// startdate
$startdate = strtotime($row[0]);
$now = time();
// total days difference
$tdays = ceil( ($now - $startdate) / (60*60*24) );;
// total periods
$tp = ceil($tdays / $pl);
$row = "";

// run the queries
for ($i = 0 ; $i < $tp ; ++$i)
{
	$date1 = date("Y-m-d H:i:s",$startdate + ((60*60*24)*$pl*$i));
	$date2 = date("Y-m-d H:i:s",$startdate + ((60*60*24)*$pl*($i+1)));
	$query = "SELECT COUNT(IF(status_id = 2, 1, NULL)) AS regtotal,
				COUNT(status_id) AS ctotal
				FROM clients
	            WHERE datetime >= '$date1' AND
	            datetime < '$date2'";
	$result = $conn->query($query);
	if (!$result) die($conn->error);
	$row[] = $result->fetch_array(MYSQLI_ASSOC);
	$row[$i]["startdate"] = $date1;
	$row[$i]["enddate"] = $date2;
}

echo $twig->render('reports.html', array(
	'clients' => $row,
	'days' => $pl
));

$result->close();
$conn->close();

?>