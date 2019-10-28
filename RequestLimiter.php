<?php
require_once ('DBConnector.php');
require_once ('DBQueriesImpl.php');

class RequestLimiter {

    function isEligibleForRequest($ipaddress) {
        $dbConnector = new DBConnector('localhost', 'root', '', 'mydb');
        $con = $dbConnector->getConnectionWithDB();
        $dbQueries = new DBQueriesImpl($con);
        try{
          $numOfRequestByIp = $dbQueries->retrieveByIpaddress($ipaddress);
          if (mysqli_num_rows($numOfRequestByIp) > 0) {
              $requestCount = mysqli_fetch_array($numOfRequestByIp);
              if ($requestCount['requstscount'] <= 10) {
                  $requestCount['requstscount'] = $requestCount['requstscount'] + 1;
                  $dbQueries->updateWhereIp($requestCount['requstscount'], $ipaddress);
                  return true;
              } else
                  return false;
          } else{
            $dbQueries->insertAddress($ipaddress);
            return true;
          }
        } catch(Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        } finally {
          $dbConnector->killConnectionWithDB($con);
        }
    }
}
?>
