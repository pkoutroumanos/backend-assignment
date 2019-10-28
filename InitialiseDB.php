<?php

require_once ('DBConnector.php');
require_once ('DBQueriesImpl.php');

$dbConnector = new DBConnector('localhost', 'root', '', '');
$con = $dbConnector->getConnectionWithDB();
$schemaName="mydb";
//drop table if exists ipcount;
//drop schema if exists mydb1;
//--drop table if exists vessel;
$initiaseDBSchemaQuery = "
drop schema if exists $schemaName;
 CREATE SCHEMA $schemaName;
use $schemaName;
CREATE TABLE `ipcount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(255) NOT NULL,
  `requstscount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE `vessel` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `mmsi` int(11) NOT NULL,
    `status` int(11) NOT NULL,
    `stationId` int(11) NOT NULL,
    `speed` int(11) NOT NULL,
    `lon` float NOT NULL,
    `lat` float NOT NULL,
    `course` int(11) NOT NULL,
    `heading` int(11) NOT NULL,
    `rot` varchar(255) NOT NULL,
    `timestamp` int(11) NOT NULL,
    PRIMARY KEY (`id`)
);";

$data = file_get_contents('ship_positions.json');
//Convert JSON string into PHP array format
$data_array = json_decode($data, true);
$initialiseDataQuery = '';
foreach($data_array as $row) {
    //Build multiple insert query
    $initialiseDataQuery .= "INSERT INTO `vessel` set
          `mmsi`  = '".$row["mmsi"]."',
          `status`  = '".$row["status"]."',
          `stationId`   = '".$row["stationId"]."',
          `speed` = '".$row["speed"]."',
          `lon`    = '".$row["lon"]."',
          `lat`    = '".$row["lat"]."',
          `course`    = '".$row["course"]."',
          `heading`    = '".$row["heading"]."',
          `rot`    = '".$row["rot"]."',
          `timestamp`    = '".$row["timestamp"]."';";
 }
 //Execute Mutliple query
 if(!mysqli_multi_query($con,$initiaseDBSchemaQuery.$initialiseDataQuery)) {
   echo "Something wrong at DB initialisation! Please try again.\n";
 } else {
   echo "initialized data\n";
 }

 mysqli_close($con);

?>
