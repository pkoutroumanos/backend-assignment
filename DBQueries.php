<?php
interface DBQueries{

  public function retrieveByMmsi($mmsi);

  public function retrieveByLatLon($minLon,$maxLon,$minLat,$maxLat);

  public function retrieveByTimeStamp($minTimestamp,$maxTimestamp);

  public function retrieveByIpaddress($ipaddress);

  public function updateWhereIp($count,$ipaddress);

  public function insertAddress($ipaddress);

}

?>
