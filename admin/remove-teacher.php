<?php
  session_start();
  error_reporting(0);
  include('includes/config.php');
  if( strlen($_SESSION['alogin'])==0 ){
    header('location:index.php');
  }
  else{
    
  $pid= $_GET['teacher_id'];
if($_SERVER['HTTP_REFERER'] == "http://rhimoniacademy.com/sch/admin/manage-teachers.php"){
    $name=$_POST['name'];
    $gender=$_POST['gender'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $address=$_POST['address'];

    $sql="DELETE from teachers where teacher_id =:pid ";

    $query = $dbh->prepare($sql);
    $query->bindParam(':pid',$pid,PDO::PARAM_STR);
    if (!$query->execute()) {
    	print_r(error_get_last());
    	print_r($dbh->errorInfo());
    	exit;
    }
    else {
    	$_SESSION['tr'] = 1;
      header("Location:manage-teachers.php");
      exit;
    }
  }
  else {
    header("Location:manage-teachers.php");
    exit;
  }
 }
 ?>
