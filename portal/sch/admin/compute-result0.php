<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');

  if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ) {
    if ( (isset($_GET['session'])) && (isset($_GET['term'])) && (isset($_GET['class'])) && (isset($_GET['class2'])) ) {
      include 'includes/db.php';
      $class2 = $_GET['class2'];
      $class = $_GET['class'];
      $session = $_GET['session'];
      $term = $_GET['term'];
      $q = $db->prepare('select distinct regno from scores where class = ? and class2 = ? and session = ? and term = ?');
      $q->bind_param('ssss', $class, $class2, $session, $term);
      $q->execute();
      $q->store_result();
      $n = $q->num_rows;
      if ($n > 0){
        $q->bind_result($regno);
        $average = array();
        $sgtotal = array();
        $class_total = 0;
        while ($q->fetch()) {
          $q1 = $db->prepare('select total from scores where regno = ? and session = ? and term = ? and class = ? and class2 = ?');
          $q1->bind_param('sssss', $regno, $session, $term, $class, $class2);
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
          $average["$regno"] = $stotal/$noso;
          $class_total += $average["$regno"];
        }
        $class_average = $class_total / $n;
        arsort($average);
        $q->free_result();
        $q->close();
        $p = 0;
        foreach ($average as $key => $value) {
          ++$p;

          $q0 = $db->prepare("insert into result (regno, session, term, class, sclass, total, average, position, class_average) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $q0->bind_param('sssssssss', $key, $session, $term, $class, $class2, $sgtotal["$key"], $value, $p, $class_average);
          if (!$q0->execute()) {
            header("Location:dashboard.php");
            exit;
          }
          $q0->close();
        }
        $db->close();
        if($term == 3){
            header("Location:compute-promotion1.php?session=$session&class=$class&class2=$class2");
            exit;
        }
        header("Location:class-result.php?term=$term&session=$session&class=$class&class2=$class2");
        exit;
      }
      else {
        $q->free_result();
        $q->close();
        $db->close();
        $_SESSION['ns'] = 1;
        header('Location:no-student.php');
        exit;
      }
    }
    else {
      header('Location:select-class2.php');
      exit;
    }
  }
  else {
    header('Location:logout.php');
    exit;
  }
?>
