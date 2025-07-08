<?php
session_id("session3");
date_default_timezone_set("Asia/Dhaka");
$date = new DateTime();

// Modify the date it contains
$day = 'tuesday';
$date->modify('next'.' '.$day);

// Output
echo $date->format('d-m-Y');


$monday = new DateTime('monday');

// clone start date
$endDate = clone $monday;

// Add 7 days to start date
$endDate->modify('+7 days');

// Increase with an interval of one day
$dateInterval = new DateInterval('P1D');

$dateRange = new DatePeriod($monday, $dateInterval, $endDate);

foreach ($dateRange as $day) {
    echo $day->format('Y-m-d')."<br />";
}

function getSundays($y,$m){ 
    $date = "$y-$m-01";
    $first_day = date('N',strtotime($date));
    $first_day = 7 - $first_day + 1;
    $last_day =  date('t',strtotime($date));
    $days = array();
    for($i=$first_day; $i<=$last_day; $i=$i+7 ){
        $days[] = $i;
    }
    return  $days;
}

$days = getSundays(2019,12);
print_r($days);

date_default_timezone_set("Asia/Dhaka");
        $today = date("d/m/Y");
        echo $today;

echo '<br>';
echo '<br>';

require_once './classes/Server.php';
$server = new Server();
$x = $server->average_ratingPoint();
while ($row = $x->fetch_assoc()){
    echo $row['avarage'];
}


?>
<br>
<br>
<br>
<br>
<?php

if(isset($_POST['date'])){

    $date = $_POST['date'];

    echo $date;

}




?>
<form method="POST">
    <input type="date" name="date">
    <input type="submit">
</form>