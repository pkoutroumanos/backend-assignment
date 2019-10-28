<?php
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
require_once('RequestLimiter.php');
require_once('VesselsTrackImpl.php');
require_once('JsonResponse.php');

//$log = new Logger('requestLogger');
//$log->pushHandler(new StreamHandler('path/to/applicationServer/logFolder/requests.log', Logger::WARNING));
$requestLimiter = new RequestLimiter();
$vesselTrackHelper = new VesselsTrackImpl();
$jsonResponse = new JsonResponse();

header("Content-Type:application/json");
//mmsi Request
if (isset($_GET['mmsi']) && $_GET['mmsi'] != "") {

    if($requestLimiter->isEligibleForRequest($_SERVER['REMOTE_ADDR'])){
      $mmsiArray = explode(",", $_GET['mmsi']);
      echo $vesselTrackHelper-> getVesselsByMmsi($mmsiArray);
    }else
      echo $jsonResponse->returnJsonResponse(null,400,false,"too many requests");
    //$log->warning('remote ip'+$_SERVER['REMOTE_ADDR']+'reuested for resource getVesselsByMmsi at:'time());
}

else if (isset($_GET['minLon']) && isset($_GET['maxLon']) && isset($_GET['maxLat']) && isset($_GET['minLat']) && $_GET['minLon'] != "" && $_GET['maxLon'] != "" && $_GET['maxLat'] != "" &&
$_GET['minLat'] != "") {

  if($requestLimiter->isEligibleForRequest($_SERVER['REMOTE_ADDR']))
    echo $vesselTrackHelper-> getVesselsByLatLon($_GET['minLon'],$_GET['maxLon'],$_GET['minLat'],$_GET['maxLat']) ;
  else
    echo $jsonResponse->returnJsonResponse(null,400,false,"too many requests");
  //$log->warning('remote ip'+$_SERVER['REMOTE_ADDR']+'reuested for resource getVesselsByLatLon at:'time());
}

else if (isset($_GET['minTimestamp']) && isset($_GET['maxTimestamp']) && $_GET['minTimestamp'] != "" && $_GET['maxTimestamp'] != "") {

   if($requestLimiter->isEligibleForRequest($_SERVER['REMOTE_ADDR']))
      echo $vesselTrackHelper-> retrieveByTimeStamp($_GET['minTimestamp'],$_GET['maxTimestamp']) ;
   else
      echo $jsonResponse->returnJsonResponse(null,400,false,"too many requests");
  //$log->warning('remote ip'+$_SERVER['REMOTE_ADDR']+'reuested for resource retrieveByTimeStamp at:'time());
}

?>
