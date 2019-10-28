<?php
require_once('DBQueries.php');

class DBQueriesImpl implements DBQueries  {

  public $connectionWithDB;

  function __construct($connectionWithDB) {
    $this->connectionWithDB=$connectionWithDB;
  }

  function retrieveByMmsi($mmsi){
    try{
      return mysqli_query( $this->connectionWithDB,"SELECT * FROM `vessel` WHERE mmsi=$mmsi");
    }catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  function retrieveByLatLon($minLon,$maxLon,$minLat,$maxLat){
    try{
      return mysqli_query( $this->connectionWithDB,"SELECT * FROM `vessel` WHERE lon>$minLon  and lon<$maxLon and lat>$minLat and lat<$maxLat");
    }
    catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  function retrieveByTimeStamp($minTimestamp,$maxTimestamp){
    $timestamp='timestamp';
    try{
      return mysqli_query( $this->connectionWithDB,"SELECT * FROM `vessel` WHERE $timestamp>$minTimestamp and $timestamp<$maxTimestamp");
    }
    catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  function retrieveByIpaddress($ipaddress){
    try{
      return mysqli_query( $this->connectionWithDB,"SELECT requstscount FROM `ipcount` WHERE ip='$ipaddress'");
    }
    catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  function updateWhereIp($count,$ipaddress){
    try{
      return mysqli_query( $this->connectionWithDB,"UPDATE ipcount SET requstscount = $count WHERE ip='$ipaddress'");
    }
    catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  function insertAddress($ipaddress){
    try{
      mysqli_query( $this->connectionWithDB,"INSERT INTO ipcount (ip, requstscount) VALUES ('$ipaddress', 1) ");
    }
    catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

}
?>
