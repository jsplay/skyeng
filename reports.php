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
// converting start date into unix timestamp
$startdate = strtotime($row[0]);
$now = time();
// total days difference
$tdays = ceil( ($now - $startdate) / (60*60*24) );;
// total periods
$tp = ceil($tdays / $pl);
$row = "";

// get the data for each period
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
	
	// total registered clients
	$rdata[] = $row[$i]["regtotal"];
	// total clients
	$tdata[] = $row[$i]["ctotal"];
	// conversion
	if ($row[$i]["regtotal"] != 0) {
		$cdata[] = number_format((($row[$i]["regtotal"] / $row[$i]["ctotal"] ) * 100), 2);
	} else {
		$cdata[] = 0;
	}
	// periods
	$pdata[] = $i+1;
}

echo $twig->render('reports.html', array(
	'clients' => $row,
	'days' => $pl,
	'pdata' => json_encode($pdata, JSON_NUMERIC_CHECK),
	'rdata' => json_encode($rdata, JSON_NUMERIC_CHECK),
	'tdata' => json_encode($tdata, JSON_NUMERIC_CHECK),
	'cdata' => json_encode($cdata, JSON_NUMERIC_CHECK)
));

$result->close();
$conn->close();

?>