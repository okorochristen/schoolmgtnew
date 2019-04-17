<?php
  session_start();
  if ( isset($_SESSION['login']) && strlen($_SESSION['login']) > 0 ) {
    if ( isset($_GET['regno']) && isset($_GET['class']) && isset($_GET['session']) ) {

      include 'includes/db.php';
      $status = "PROMOTED";
      $regno = $_GET['regno'];
      $class = $_GET['class'];
      $session = $_GET['session'];
      $Y = date('Y');
      $ny = $Y + 1;
      $newsession = "$Y/$ny";

      $q = $db->prepare("update promotional_result2 set status = ? where regno = ? and class = ? and session = ?");
      $q->bind_param('ssss',$status, $regno, $class, $session);
      $q->execute();
      $q->close();

      $newclass = $class + 1;
      $q = $db->prepare("update accepted_students set current_session = ?, current_class = ? where regno = ?");
      $q->bind_param('sss',$newsession, $newclass, $regno);
      $q->execute();
      $q->close();
      $db->close();
      $url = $_SERVER['HTTP_REFERER'];
      header("Location:$url");
      exit;
    }
    else {
      $url = $_SERVER['HTTP_REFERER'];
      header("Location:$url");
      exit;
    }
  }
  else {
    header("Location:logout.php");
    exit;
  }
?>
