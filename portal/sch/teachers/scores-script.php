<?php
  ob_start();
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
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
  if ( (isset($_SESSION['login'])) && (!empty($_SESSION['login']) ) ){
    if (isset($_POST['ss_btn'])) {
      if ((!isset($_POST['class'])) || (!isset($_POST['class2'])) || (!isset($_POST['session'])) || (!isset($_POST['term'])) || (!isset($_POST['subject']))) {
        header('Location:enter-student-scores.php');
        exit;
      }
      else {
        include 'includes/db.php';
        $staff = $_SESSION['login'];
        $term = $_REQUEST['term'];
        $class = $_REQUEST['class'];
        $class2 = $_REQUEST['class2'];
        $session = $_REQUEST['session'];
        $subject = $_REQUEST['subject'];
        $ctotal = 0;
        $regs = array();
        $c = 0;
        $q = $db->prepare("select distinct regno from accepted_students where current_class = ? and class = ? and current_session = ?");
        $q->bind_param('sss',$class,$class2,$session);
        $q->execute();
        $q->bind_result($regnos);
        $q->store_result();
        $ns = $q->num_rows;
        $q1 = $db->prepare("select total from scores where regno = ? and session = ? and term = ? and class = ? and subject = ? and class2 = ?");
        while ($q->fetch()) {
          $regs[$c] = $regnos;
          $c++;
          $q1->bind_param("ssssss", $regnos, $session, $term, $class, $subject, $class2);
          $q1->execute();
          $q1->store_result();
          $n = $q1->num_rows;
          if ($n > 0) {
            $q1->bind_result($stotal);
            $q1->fetch();
          }
          else {
            $stotal = 0;
            $k1 = $regnos."as1";
            if ( (empty($_POST["$k1"])) || (!preg_match("/^[0-9]*$/",$_POST["$k1"])) ) {
              $as1 = 0;
            }
            else {
              $as1 = $_POST["$k1"];
            }
            $k2 = $regnos."as2";
            if ( (empty($_POST["$k2"])) || (!preg_match("/^[0-9]*$/",$_POST["$k2"])) ) {
              $as2 = 0;
            }
            else {
              $as2 = $_POST["$k2"];
            }
            $k3 = $regnos."ts1";
            if ( (empty($_POST["$k3"])) || (!preg_match("/^[0-9]*$/",$_POST["$k3"])) ) {
              $ts1 = 0;
            }
            else {
              $ts1 = $_POST["$k3"];
            }
            $k4 = $regnos."ts2";
            if ( (empty($_POST["$k4"])) || (!preg_match("/^[0-9]*$/",$_POST["$k4"])) ) {
              $ts2 = 0;
            }
            else {
              $ts2 = $_POST["$k4"];
            }
            $k5 = $regnos."exam";
            if ( (empty($_POST["$k5"])) || (!preg_match("/^[0-9]*$/",$_POST["$k5"])) ) {
              $exam = 0;
            }
            else {
              $exam = $_POST["$k5"];
            }
            $stotal = $as1 + $as2 + $ts1 + $ts2 + $exam;
          }
          $ctotal += $stotal;
        }
        $q->free_result();
        $q->close();
        $caverage = $ctotal / $ns;

        //update class average of students whose scores have been Entered before now.
        $q1 = $db->prepare('update scores set class_average = ? where session = ? and term = ? and class = ? and subject = ? and class2 = ?');
        $q1->bind_param('ssssss', $caverage, $session, $term, $class, $subject, $class2);
        $q1->execute();
        $q1->close();
        $q1 = $db->prepare('select count(total) from scores where regno = ? and session = ? and term = ? and class = ? and subject = ? and class2 = ?');
        $q0 = $db->prepare('insert into scores (regno, session, term, class, class2, subject, as1, as2, ts1, ts2, exam, total, grade, class_average, staffid) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $al = count($regs);

        for ($i = 0; $i < $al; $i++) {
          $regnos = $regs[$i];
          $q1->bind_param('ssssss', $regnos, $session, $term, $class, $subject, $class2);
          $q1->execute();
          $q1->store_result();
          $q1->bind_result($n);
          $q1->fetch();

          //Enter exam records of the students whose exam has not been recorded.
          if($n < 1){
            $stotal = 0;
            $k1 = $regnos."as1"; $k2 = $regnos."as2"; $k3 = $regnos."ts1"; $k4 = $regnos."ts2"; $k5 = $regnos."exam";
            if ( (!empty($_POST["$k1"])) || (!empty($_POST["$k2"])) || (!empty($_POST["$k3"])) || (!empty($_POST["$k4"])) || (!empty($_POST["$k5"]))) {
              echo "we  d enter.";
              if ( (empty($_POST["$k1"])) || (!preg_match("/^[0-9]*$/",$_POST["$k1"])) ) {
                $as1 = 0;
              }
              else {
                $as1 = $_POST["$k1"];
              }
              if ( (empty($_POST["$k2"])) || (!preg_match("/^[0-9]*$/",$_POST["$k2"])) ) {
                $as2 = 0;
              }
              else {
                $as2 = $_POST["$k2"];
              }
              if ( (empty($_POST["$k3"])) || (!preg_match("/^[0-9]*$/",$_POST["$k3"])) ) {
                $ts1 = 0;
              }
              else {
                $ts1 = $_POST["$k3"];
              }

              if ( (empty($_POST["$k4"])) || (!preg_match("/^[0-9]*$/",$_POST["$k4"])) ) {
                $ts2 = 0;
              }
              else {
                $ts2 = $_POST["$k4"];
              }

              if ( (empty($_POST["$k5"])) || (!preg_match("/^[0-9]*$/",$_POST["$k5"])) ) {
                $exam = 0;
              }
              else {
                $exam = $_POST["$k5"];
              }
              $stotal = $as1 + $as2 + $ts1 + $ts2 + $exam;
              $grade = grade($stotal);
              $q0->bind_param('sssssssssssssss', $regnos, $session, $term, $class, $class2, $subject, $as1, $as2, $ts1, $ts2, $exam, $stotal, $grade, $caverage, $staff);
              $q0->execute();
              $q0->store_result();
            }
          }
        }
        $q0->close();
        $db->close();
        $_SESSION['allow'] = 1;
        header("Location:enter-scores.php?class=$class&class2=$class2&subject=$subject&term=$term");
      }
    }
    else {
      header('Location:enter-scores.php');
      exit;
    }
  }
  else {
    header('Location:logout.php');
    exit;
  }
?>
