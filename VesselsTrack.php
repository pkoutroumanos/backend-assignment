<?php

interface VesselsTrack{

  public function getVesselsByMmsi($mmsi);

  public function getVesselsByLatLon($minLon,$maxLon,$minLat,$maxLat);

  public function retrieveByTimeStamp($minTimestamp,$maxTimestamp);

}
?>
