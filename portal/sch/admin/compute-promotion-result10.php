<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
  if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ) {
    if ( (isset($_GET['session'])) && (isset($_GET['class'])) && (isset($_GET['class2'])) ) {
      include 'includes/db.php';

      $class = $_GET['class'];
      $session = $_GET['session'];
      $class2 = $_GET['class2'];

      $q = $db->prepare('select distinct regno from promotional_scores1 where class = ? and session = ? and class2 = ?');
      $q->bind_param('sss', $class, $session, $class2);
      $q->execute();
      $q->store_result();
      $n = $q->num_rows;
      if ($n > 0){
        $q->bind_result($regno);
        $average = array();
        $sgtotal = array();
        $class_total = 0;
        while ($q->fetch()) {
          $q1 = $db->prepare('select total from promotional_scores1 where regno = ? and session = ? and class = ? and class2 = ?');
          $q1->bind_param('ssss', $regno, $session, $class, $class2);
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
          $q0 = $db->prepare("insert into promotional_result1 (regno, session, class, class2, total, average, position, class_average) values (?, ?, ?, ?, ?, ?, ?, ?)");
          $q0->bind_param('ssssssss', $key, $session, $class, $class2, $sgtotal["$key"], $value, $p, $class_average);
          $q0->execute();
          $q0->close();
        }
        $db->close();
        header("Location:result-summary1.php?&session=$session&class=$class&class2=$class2");
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
