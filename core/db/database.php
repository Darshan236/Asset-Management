<?php


    $host= 'localhost';
    $username = 'root';
    $password = 'mysql';
    $dbname = 'user';

    $con = mysqli_connect($host,$username,$password,$dbname) or die(mysqli_connect_error());
?>