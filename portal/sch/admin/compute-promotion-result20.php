<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
  if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ) {
    if ( (isset($_GET['session'])) && (isset($_GET['class'])) ) {
      include 'includes/db.php';

      $class = $_GET['class'];
      $session = $_GET['session'];

      $q = $db->prepare('select distinct regno from promotional_scores2 where class = ? and session = ?');
      $q->bind_param('ss', $class, $session);
      $q->execute();
      $q->store_result();
      $n = $q->num_rows;
      if ($n > 0){
        $q->bind_result($regno);
        $average = array();
        $sgtotal = array();
        $class_total = 0;
        while ($q->fetch()) {
          $q1 = $db->prepare('select total from promotional_scores2 where regno = ? and session = ? and class = ?');
          $q1->bind_param('sss', $regno, $session, $class);
          $q1->execute();
          $q1->store_result();
          $noso = $q1->num_rows;
          $q1->bind_result($total);
          $stotal = 0;
          while ($q1->fetch()) {
            $stotal += $total;
          }
          $q1->free_result();
          $q1->close();
          $sgtotal["$regno"] = $stotal;
          $average["$regno"] = ($stotal/$noso);
          $class_total += $average["$regno"];
        }
        $class_average = $class_total / $n;
        arsort($average);
        $q->free_result();
        $q->close();
        $p = 0;
        foreach ($average as $key => $value) {
          ++$p;
          $q0 = $db->prepare("insert into promotional_result2 (regno, session, class, total, average, position, class_average) values (?, ?, ?, ?, ?, ?, ?)");
          $q0->bind_param('sssssss', $key, $session, $class, $sgtotal["$key"], $value, $p, $class_average);
          $q0->execute();
          $q0->close();
        }
        $db->close();
        header("Location:result-summary2.php?session=$session&class=$class");
        exit;
      }
      else {
        $q->close();
        $db->close();
        header('Location:dashboard.php');
        exit;
      }
    }
    else {
      header('Location:dashboard.php');
      exit;
    }
  }
  else {
    header('Location:logout.php');
    exit;
  }
?>
