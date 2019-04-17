<?php
  /*Script to compute the average of students performance in all three terms*/
  session_start();
  function grade($score)
  {
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
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
  if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ) {
      if ( (isset($_GET['session'])) && (isset($_GET['class'])) && (isset($_GET['class2'])) ) {
        include 'includes/db.php';
        $class = $_GET['class'];
        $session = $_GET['session'];
        $class2 = $_GET['class2'];
        $school = "secondary";

        /*Array to hold data returned from db*/
        $data = array(array());

        /*Array to hold students registration Numbers*/
        $reg_array = array();

        /*Array to hold all subjects offered by students in that class*/
        $sub_array = array();

        /*Get all the subjects offered by students in that class*/
        $q = $db->prepare("select distinct subject from scores where session = ? and class = ? and class2 = ?");
        $q->bind_param('sss',$session,$class,$class2);
        $q->execute();
        $q->store_result();
        $q->bind_result($subjects);
        $x = 0;
        while ($q->fetch()) {
          $sub_array[$x] = $subjects;
          $x++;
        }
        $q->free_result();
        $q->close();

        /*Get the number of subjects offered by the class.*/
        $x = count($sub_array);

        /*Select the registration number of every class member*/
        $q = $db->prepare('select regno from accepted_students where current_class = ? and current_session = ? and school = ? and class2 = ?');
        $q->bind_param('ssss',$class,$session,$school,$class2);
        $q->execute();
        $q->store_result();
        $q->bind_result($regno);
        $y = 0;
        while ($q->fetch()) {
          $reg_array[$y] = $regno;
          ++$y;

          for($i = 0; $i < $x; $i++){
            /*variable to store the total student scored in subject*/
            $subject_total = 0;

            /*select scores of the student in subjects offered by his class*/
            $scq = $db->prepare("select total from scores where subject = ? and regno = ? and class = ? and session = ? and sclass = ?");
            $scq->bind_param('sssss', $sub_array[$i],$regno,$class,$session,$class2);
            $scq->execute();
            $scq->store_result();
            $scq->bind_result($total);

            if ($scq->num_rows > 0) {
              /*Variable to keep count of number of times student wrote subject*/
              $c = 0;
              while ($scq->fetch()) {
                $subject_total += $total;
                ++$c;
              }
              /*variable to store the average student scored in subject for that session*/
              $subject_average = $subject_total/$c;

              /*Assign average student score in subject to data array*/
              $index = $sub_array[$i];
              $data["$index"]["$regno"] = $subject_average;
            }
            $scq->free_result();
            $scq->close();
          }
        }
        $q->free_result();
        $q->close();
        unset($data["0"]);

        foreach ($data as $sub_key => $sub_value) {
          $total = 0;
          $c = 0;

          foreach ($sub_value as $reg_key => $score_value) {
            $total += $score_value;
            ++$c;
          }
          /*Calculate an save the class average in the given subject*/
          $classAverageInSubject = ($total/$c);

          /*sort the students scores in subject in ascending order*/
          arsort($sub_value);
          $p = 1;
          foreach ($sub_value as $reg_key => $score_value) {
            /*Compute the grade of student.*/
            $grade = grade($score_value);

            /*Insert everybodys score for the subject*/
            $q = $db->prepare("insert into promotional_scores1 (regno, session, class, class2, subject, total, grade, class_average,position) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $q->bind_param('sssssssss',$reg_key, $session, $class, $class2, $sub_key, $score_value, $grade, $classAverageInSubject, $p);
            $q->execute();
            $q->close();
            ++$p;
          }
        }
        $db->close();
        header("Location:compute-promotion-result1.php?session=$session&class=$class&class2=$class2");
        exit;
      }
    }
?>
