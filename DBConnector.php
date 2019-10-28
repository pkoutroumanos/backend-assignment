<?php
class DBConnector{

  public $hostName;
  public $userName;
  public $passWord;
  public $dbName;
  public $connection;


  function __construct($hostName,$userName,$passWord,$dbName) {
    $this->hostName = $hostName;
    $this->userName = $userName;
    $this->passWord = $passWord;
    $this->dbName = $dbName;
  }

  function getConnectionWithDB(){
    try{
      $this->connection = mysqli_connect($this->hostName, $this->userName, $this->passWord, $this->dbName);
      return $this->connection;
    } catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  function killConnectionWithDB($connection) {
    try{
      mysqli_close($connection);
    } catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  function getConnection() {
    return $this->connection;
  }

  function setConnection($connection) {
    $this->connection= $connection;
  }

}
?>
