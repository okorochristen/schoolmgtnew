<?php
  session_start();
  error_reporting(0);
  include('includes/config.php');
  if( strlen($_SESSION['alogin'])==0 ){
    header('location:index.php');
  }
  else{
    
  $id= $_GET['id'];
if($_SERVER['HTTP_REFERER'] == "http://rhimoniacademy.com/sch/admin/view_subj.php"){
    $name=$_POST['subject'];
    $gender=$_POST['class'];
    
    $sql="DELETE from subjects where id =:id ";

    $query = $dbh->prepare($sql);
    $query->bindParam(':id',$id,PDO::PARAM_STR);
    if (!$query->execute()) {
    	print_r(error_get_last());
    	print_r($dbh->errorInfo());
    	exit;
    }
    else {
    	$_SESSION['tr'] = 1;
      header("Location:view_subj.php");
      exit;
    }
  }
  else {
    header("Location:view_subj.php");
    exit;
  }
 }
 ?>
