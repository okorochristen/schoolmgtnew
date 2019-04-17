<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');

  if ( (isset($_SESSION['login'])) && (!empty($_SESSION['login']) ) ){
      if (isset($_REQUEST['class']) && isset($_REQUEST['class2']) && isset($_REQUEST['session']) && isset($_REQUEST['term']) && isset($_REQUEST['bhv_btn2'])) {
        include 'includes/db.php';

        $term = $_REQUEST['term'];
        $class = $_REQUEST['class'];
        $class2 = $_REQUEST['class2'];
        $session = $_REQUEST['session'];
        $school = "secondary";

        $regs = array();
        $c = 0;
        $q = $db->prepare("select distinct regno from accepted_students where current_class = ? and class = ? and current_session = ? and school = ?");
        $q->bind_param('ssss',$class,$class2,$session,$school);
        $q->execute();
        $q->bind_result($regnos);
        $q->store_result();

        if ($q->num_rows > 0) {
          $q0 = $db->prepare("insert into secondary_behaviour (regno, session, term, class, class2, punctuality, attendance, assignment, school_act, neatness, honesty, self_control, relationship, games, lab) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          while ($q->fetch()) {
            $f1 = $regnos."punctuality";
            $f2 = $regnos."attendance";
            $f3 = $regnos."assignment";
            $f4 = $regnos."school_act";
            $f5 = $regnos."neatness";
            $f6 = $regnos."honesty";
            $f7 = $regnos."self_control";
            $f8 = $regnos."relationship";
            $f9 = $regnos."games";
            $f10 = $regnos."lab";

            $punctuality = $_REQUEST["$f1"];
            $attendance = $_REQUEST["$f2"];
            $assignment = $_REQUEST["$f3"];
            $school_act = $_REQUEST["$f4"];
            $neatness = $_REQUEST["$f5"];
            $honesty = $_REQUEST["$f6"];
            $self_control = $_REQUEST["$f7"];
            $relationship = $_REQUEST["$f8"];
            $games = $_REQUEST["$f9"];
            $lab = $_REQUEST["$f10"];

            $q0->bind_param('sssssssssssssss', $regnos, $session, $term, $class, $class2, $punctuality, $attendance, $assignment, $school_act, $neatness, $honesty, $self_control, $relationship, $games, $lab);
            $q0->execute();
          }
          $q->close();
          $q->free_result();
          $q->close();
          $db->close();

          header("Location:enter-behaviourial-ratings.php?session=$session&term=$term&class=$class&class2=$class2");
          exit;
        }
        else {
          $_SESSION['msg'] = "No students found.";
          header("Location:select-class3.php");
          exit;
        }
      }
    else {
      header("Location:select-class3.php");
      exit;
    }
  }
  else {
    header('Location:logout.php');
    exit;
  }
?>
