<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
  if ( (isset($_SESSION['alogin'])) && (strlen($_SESSION['alogin']) >  0) ) {
    if ( (isset($_REQUEST['session'])) && (isset($_REQUEST['class'])) && (isset($_REQUEST['class2'])) ) {
      include 'includes/db.php';

      $class = $_REQUEST['class'];
      $session = $_REQUEST['session'];
      $class2 = $_REQUEST['class2'];
      $nyear = 1;
      $cyear = date('Y');
      $nyear += $cyear;
      $newsession = $cyear."/".$nyear;

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
          $q2 = $db->prepare("select current_class from accepted_students where regno = ? limit 1");
          $q2->bind_param('s',$regno);
          $q2->execute();
          $q2->store_result();
          $q2->bind_result($current_class);
          $q2->fetch();
          $q2->free_result();
          $q2->close();

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
          $q2 = $db->prepare("select current_class from accepted_students where regno = ?");
          $q2->bind_param('s',$key);
          $q2->execute();
          $q2->bind_result($current_class);
          $q2->fetch();
          $q2->free_result();
          $q2->close();

          if($value >= 50 ){
            $promote = "1";
            ++$current_class;
            if ($current_class > 6) {
              $q2 = $db->prepare("update accepted_students set status = ?, current_class = ? where regno = ?");
              $status = '0';
              $q2->bind_param('sss',$status, $current_class, $key);
              $q2->execute();
              $q2->close();
            }
            else {
              $q2 = $db->prepare("update accepted_students set current_class = ?, current_session = ? where regno = ?");
              $q2->bind_param('sss',$current_class, $newsession, $key);
              $q2->execute();
              $q2->close();
            }
          }
          else {
            $promote = "0";
            $q2 = $db->prepare("update accepted_students set current_session = ? where regno = ?");
            $q2->bind_param('ss',$newsession, $key);
            $q2->execute();
            $q2->close();
          }
          ++$p;
          $q0 = $db->prepare("insert into promotional_result1 (regno, session, class, class2, total, average, position, class_average, status) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $q0->bind_param('sssssssss', $key, $session, $class, $class2, $sgtotal["$key"], $value, $p, $class_average, $promote);
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
