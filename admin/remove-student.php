<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors','on');
  include('includes/db.php');
  if( strlen($_SESSION['alogin'])==0 ){
    header('location:index.php');
  }
  else{
    if(isset($_GET['id']) && isset($_GET['school'])){
      $url = $_SERVER['HTTP_REFERER'];
      $id= $_GET['id'];
      $q = $db->prepare("select passport from accepted_students where  regno = ?");
      $q->bind_param('s',$id);
      $q->execute();
      $q->bind_result($assport);
      $q->fetch();
      $q->close();

      if($_GET['school'] == 'primary'){
        unlink("../studs/primary passports/$passport");
      }
      elseif ($_GET['school'] == 'secondary') {
        unlink("../studs/secondary passports/$passport");
      }

      $q = $db->prepare("delete from accepted_students where regno = ?");
      $q->bind_param('s', $id);
      if ($q->execute()) {
        $_SESSION['msg'] = "student removed succesfully";
      }
      else {
        $_SESSION['msg'] = "Oops! Something went wrong. student not removed";
      }

      $q->close();
      $db->close();
      header("Location:$url");
      exit;
    }
    else {
      header("Location:$url");
      exit;
    }
 }
 ?>
