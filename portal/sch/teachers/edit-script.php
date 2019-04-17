<?php
  session_start();
  function grade($score){
    if ( (!($score > 100)) && (!($score < 70)) ) {
      return "A";
    }
    elseif ( (!($score < 60)) && ($score < 70) ) {
      return "B";
    }
    elseif ( (!($score < 50)) && ($score < 60) ) {
      return "C";
    }
    elseif ( (!($score < 45)) && ($score < 50) ) {
      return "D";
    }
    elseif ( (!($score < 40)) && ($score < 45) ) {
      return "E";
    }
    else {
      return "F";
    }
  }
  if (isset($_SESSION['login']) && (!empty($_SESSION['login']))) {
    if (isset($_POST['ss_btn'])) {
      include 'includes/db.php';
      $subject = $_POST['subject'];
      $term = $_POST['term'];
      $regno = $_POST['regno'];
      $session = $_POST['session'];
      $class = $_POST['class'];
      $class2 = $_POST['class2'];
      $as1 = $_POST['as1'];
      $as2 = $_POST['as2'];
      $ts1 = $_POST['ts1'];
      $ts2 = $_POST['ts2'];
      $exam = $_POST['exam'];
      $total = $_POST['total'];
      $grade = grade($total);
      $q = $db->prepare("update scores set as1 = ?, as2 = ?, ts1 = ?, ts2 = ?, exam = ?, total = ?, grade = ? where session = ? and term = ? and class = ? and class2 = ? and subject = ? and regno = ?");
      $q->bind_param('sssssssssssss',$as1,$as2,$ts1,$ts2,$exam,$total,$grade,$session,$term,$class,$class2,$subject,$regno);
      $q->execute();
      $q->close();

      $q = $db->prepare("select total from scores where session = ? and term = ? and class = ? and class2 = ? and subject = ?");
      $q->bind_param('sssss',$session,$term,$class,$class2,$subject);
      $q->execute();
      $q->store_result();
      $n = $q->num_rows;
      if ($n > 0) {
        $ctotal = 0;
        $q->bind_result($stotal);
        while ($q->fetch()) {
          $ctotal += $stotal;
        }
        $caverage = $ctotal/$n;
        $q->free_result();
        $q->close();

        $q = $db->prepare("update scores set class_average = ? where session = ? and term = ? and class = ? and class2 = ? and subject = ?");
        $q->bind_param('ssssss',$caverage,$session,$term,$class,$class2,$subject);
        $q->execute();
      }
      $q->close();
      $db->close();
      header("Location:enter-scores.php?subject=$subject&class=$class&class2=$class2&term=$term");
      exit;
    }
    else {
      if (!(empty($_SERVER['HTTP_REFERER']))) {
        $url = $_SERVER['HTTP_REFERER'];
      }
      else {
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
