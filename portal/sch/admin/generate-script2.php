<?php
  session_start();
  if ( (isset($_SESSION['alogin'])) && (!empty($_SESSION['alogin']))) {
    if ( (isset($_REQUEST['session'])) && (isset($_REQUEST['term'])) && (isset($_REQUEST['class'])) && (isset($_REQUEST['class2'])) ) {
      include 'includes/db.php';
      $session = htmlentities($_REQUEST['session']);
      $term = htmlentities($_REQUEST['term']);
      $class = htmlentities($_REQUEST['class']);
      $class2 = htmlentities($_REQUEST['class2']);
      $q = $db->prepare("select count(pin) from result_checker2 where session = ? and term = ? and class = ? and class2 = ?");
      $q->bind_param('ssss', $session, $term, $class, $class2);
      $q->execute();
      $q->bind_result($count);
      $q->fetch();
      $q->close();
      if ($count > 0) {
        $db->close();
        header("Location:view-pins2.php?session=$session&term=$term&class=$class&class2=$class2");
        exit;
      }
      else {
        $school = "primary";
        $q = $db->prepare("select distinct regno from scores2 where class = ? and class2 = ? and term = ? and session = ?");
        $q->bind_param('ssss', $class, $class2, $term, $session);
        $q->execute();
        $q->store_result();
        $q->bind_result($regnos);
        $q0 = $db->prepare('insert into result_checker2 (session, class, class2, term, pin, regno) values (?, ?, ?, ?, ?, ?)');
        while ($q->fetch()) {
          $pin = $regnos.$class.$term.$session.strtotime('1970-01-06 '.date('h:i:s'));
          $q0->bind_param('ssssss',$session, $class, $class2, $term, $pin, $regnos);
          $q0->execute();
        }
        $q0->close();
        $q->free_result();
        $q->close();
        $db->close();
        header("Location:view-pins2.php?session=$session&term=$term&class=$class&class2=$class2");
        exit;
      }
    }
    else {
      header("Location:generate2.php");
      exit;
    }
  }
  else {
    header("Location:logout.php");
    exit;
  }
?>
