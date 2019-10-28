<?php
require_once ('DBConnector.php');
require_once ('DBQueriesImpl.php');
require_once ('VesselsTrack.php');
require_once ('JsonResponse.php');

class VesselsTrackImpl implements VesselsTrack {
    /*
    */
    function getVesselsByMmsi($mmsiArray) {
        $dbConnector = new DBConnector('localhost', 'root', '', 'mydb');
        $con = $dbConnector->getConnectionWithDB();
        $dbQueries = new DBQueriesImpl($con);
        $jsonResponse = new JsonResponse();
        try{
          foreach ($mmsiArray as $key => $value) {
              $mmsi = $value;
              $result = $dbQueries->retrieveByMmsi($mmsi);
              if (mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_array($result);
                  $response[$key] = $jsonResponse->initialiseResponse($row['mmsi'], $row['status'], $row['stationId'], $row['speed'], $row['lon'], $row['lat'], $row['course'], $row['heading'], $row['rot'], $row['timestamp']);
              }
          }
          return $jsonResponse->returnJsonResponse($response,200,true,"");
        } catch(Exception $e) {
            return $jsonResponse->returnJsonResponse($response,500,false,"internal error");
        } finally {
          $dbConnector->killConnectionWithDB($con);
        }
    }

    /*
    */
    function getVesselsByLatLon($minLon, $maxLon, $minLat, $maxLat) {
        $dbConnector = new DBConnector('localhost', 'root', '', 'mydb');
        $con = $dbConnector->getConnectionWithDB();
        $dbQueries = new DBQueriesImpl($con);
        $jsonResponse = new JsonResponse();
        try{
          $result = $dbQueries->retrieveByLatLon($minLon, $maxLon, $minLat, $maxLat);
          if (mysqli_num_rows($result) > 0) {
              $arrayResult = array();
              while ($row = mysqli_fetch_array($result, true)) {
                  $arrayResult[] = $row;
              }
              for ($i = 0;$i < sizeof($arrayResult);$i++) {
                  $response[$i] = $jsonResponse->initialiseResponse($arrayResult[$i]['mmsi'], $arrayResult[$i]['status'], $arrayResult[$i]['stationId'], $arrayResult[$i]['speed'], $arrayResult[$i]['lon'], $arrayResult[$i]['lat'], $arrayResult[$i]['course'], $arrayResult[$i]['heading'], $arrayResult[$i]['rot'], $arrayResult[$i]['timestamp']);
              }
              return $jsonResponse->returnJsonResponse($response,200,true,"");
          }
        } catch(Exception $e) {
            return $jsonResponse->returnJsonResponse($response,500,false,"internal error");
        } finally {
            $dbConnector->killConnectionWithDB($con);
        }
    }
    /*

    */
    function retrieveByTimeStamp($minTimestamp, $maxTimestamp) {
        $dbConnector = new DBConnector('localhost', 'root', '', 'mydb');
        $con = $dbConnector->getConnectionWithDB();
        $dbQueries = new DBQueriesImpl($con);
        $jsonResponse = new JsonResponse();
        try {
            $result = $dbQueries->retrieveByTimeStamp($minTimestamp, $maxTimestamp);
            if (mysqli_num_rows($result) > 0) {
                $arrayResult = array();
                while ($row = mysqli_fetch_array($result, true)) {
                    $arrayResult[] = $row;
                }
                for ($i = 0;$i < sizeof($arrayResult);$i++) {
                    $response[$i] = $jsonResponse->initialiseResponse($arrayResult[$i]['mmsi'], $arrayResult[$i]['status'], $arrayResult[$i]['stationId'], $arrayResult[$i]['speed'], $arrayResult[$i]['lon'], $arrayResult[$i]['lat'], $arrayResult[$i]['course'], $arrayResult[$i]['heading'], $arrayResult[$i]['rot'], $arrayResult[$i]['timestamp']);
                }
                return $jsonResponse->returnJsonResponse($response,200,true,"");
            }
        } catch(Exception $e) {
            return $jsonResponse->returnJsonResponse($response,500,false,"internal error");
        } finally {
          $dbConnector->killConnectionWithDB($con);
        }
    }
}
?>
