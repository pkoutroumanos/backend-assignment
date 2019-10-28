<?php
class JsonResponse{

  function initialiseResponse($mmsiResult, $statusResult, $stationIdResult, $speedResult, $lonResult, $latResult, $courseResult, $headingResult, $rotResult, $timestampResult)
  {
      $response['mmsi']      = $mmsiResult;
      $response['status']    = $statusResult;
      $response['stationId'] = $stationIdResult;
      $response['speed']     = $speedResult;
      $response['lon']       = $lonResult;
      $response['lat']       = $latResult;
      $response['course']    = $courseResult;
      $response['heading']   = $headingResult;
      $response['rot']       = $rotResult;
      $response['timestamp'] = $timestampResult;

      return $response;
  }

  function returnJsonResponse($response,$code,$success,$message)
  {
      $json_response["code"]=$code;
      $json_response["success"]=$success;
      $json_response["message"]=$message;
      $json_response["payload"] = $response;
      $json_response = json_encode($json_response);
      return $json_response;
  }

}

?>
