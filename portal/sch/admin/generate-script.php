<?php
  session_start();
  error_reporting(E_ALL);
  ini_set("display_errors","on");
  if ( (isset($_SESSION['alogin'])) && (!empty($_SESSION['alogin']))) {
    if ( (isset($_POST['session'])) && (isset($_POST['term'])) && (isset($_POST['class'])) && (isset($_POST['class2'])) ) {
      include 'includes/db.php';
      $session = htmlentities($_POST['session']);
      $term = htmlentities($_POST['term']);
      $class = htmlentities($_POST['class']);
      $class2 = htmlentities($_POST['class2']);
      $q = $db->prepare("select count(pin) from result_checker where session = ? and term = ? and class = ? and class2 = ?");
      $q->bind_param('ssss', $session, $term, $class, $class2);
      $q->execute();
      $q->bind_result($count);
      $q->fetch();
      $q->close();
      if ($count > 0) {
        $db->close();
        header("Location:view-pins.php?session=$session&term=$term&class=$class&class2=$class2");
        exit;
      }
      else {
        $school = "secondary";
        $q = $db->prepare("select distinct regno from accepted_students where current_class = ? and class = ? and school = ? and current_session = ?");
        $q->bind_param('ssss', $class, $class2, $school, $session);
        $q->execute();
        $q->store_result();
        $q->bind_result($regnos);
        while ($q->fetch()) {
          $pin = $regnos.$class.$term.$session.strtotime('1970-01-06 '.date('h:i:s'));
          $q0 = $db->prepare("insert into result_checker (session, class, class2, term, pin, regno) values (?, ?, ?, ?, ?, ?)");
          $q0->bind_param('ssssss',$session, $class, $class2, $term, $pin, $regnos);
          if (!$q0->execute()) {
            echo "Error---> $db->error";
            exit;
          }
          $q0->execute();
          $q0->close();
        }
        $q->free_result();
        $q->close();
        $db->close();
        header("Location:view-pins.php?session=$session&term=$term&class=$class&class2=$class2");
        exit;
      }
    }
    else {
      header("Location:generate.php");
      exit;
    }
  }
  else {
    header("Location:logout.php");
    exit;
  }
?>
