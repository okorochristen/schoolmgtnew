<?php
  session_start();
  if (isset($_SESSION['login']) && (!empty($_SESSION['login']))) {
    if ( (isset($_GET['session'])) && (isset($_GET['term'])) && (isset($_GET['class'])) && (isset($_GET['class2'])) && (isset($_GET['subject'])) && (isset($_GET['regno'])) ) {
      include 'includes/db.php';
      $session = $_GET['session'];
      $term = $_GET['term'];
      $class = $_GET['class'];
      $subject = $_GET['subject'];
      $regno = $_GET['regno'];
      $class2 = $_GET['class2'];
      $q = $db->prepare("delete from scores2 where session = ? and term = ? and class = ? and subject = ? and regno = ? and class2 = ?");
      $q->bind_param('ssssss',$session,$term,$class,$subject,$regno,$class2);
      $q->execute();
      $q->close();

      $q = $db->prepare("select total from scores2 where session = ? and term = ? and class = ? and class2 = ? and subject = ?");
      $q->bind_param('sssss',$session,$term,$class,$class2,$subject);
      $q->execute();
      $q->store_result();
      $n = $q->num_rows;
      $ctotal = 0;
      $q->bind_result($stotal);
      while ($q->fetch()) {
        $ctotal += $stotal;
      }
      $caverage = $ctotal/$n;
      $q->free_result();
      $q->close();

      $q = $db->prepare("update scores2 set class_average = ? where session = ? and term = ? and class = ? and class2 = ? and subject = ?");
      $q->bind_param('ssssss',$caverage,$session,$term,$class,$class2,$subject);
      $q->execute();
      $q->close();
      $db->close();
      $_SESSION['allow'] = 1;
      header("Location:enter-scores2.php?subject=$subject&class=$class&class2=$class2&term=$term");
      exit;
    }
    else {
      if (!(empty($_SERVER['HTTP_REFERER']))) {
        $url = $_SERVER['HTTP_REFERER'];
      } else {
        $url = "dashboard.php";
      }
      header("Location:$url");
      exit;
    }
  }
  else {
    header("Location:logout.php");
    exit;
  }
?>