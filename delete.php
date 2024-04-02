<?php include 'core/init.php';

$id = $_GET['id'];
delete_data($con,$id);
// delete_data1($con,$id);
header('location:home.php');
