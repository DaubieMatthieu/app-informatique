<?php

function db_connect() {
  $db_username = 'root';
  $db_password = '';
  $db_name     = 'infinite_sense';
  $db_host     = 'localhost';

  try
  {
    return $db = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_username, $db_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
  } catch (Exception $e)
  {
    return false;
  }
}
