<?php
  session_start();
  if ( isset($_SESSION['alogin'])  ){
    if (isset($_GET['stud_id'])) {
      if (isset($_POST['cl'])) {
        $cl = $_POST['cl'];
        include 'includes/db.php';
        $school = "primary";
        $regno = $_GET['stud_id'];
        $q = $db->prepare('select fname,start_session,gender,dob,religion,state,lga,nationality,class_app,address,parent,parent_num,passport from students where regno = ?');
        $q->bind_param('s', $regno);
        $q->execute();
        $q->store_result();
        $q->bind_result($fname, $start_session, $gender, $dob, $religion, $state, $lga, $nationality, $class_app, $address, $parent, $parent_num, $passport);
        $q->fetch();
        $q->free_result();
        $q->close();

        $q1 = $db->prepare('INSERT INTO accepted_students (regno, fname, start_class, current_class, class, start_session, current_session, gender, dob, religion, state, lga, nationality, address, parent, parent_num, passport, school) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $q1->bind_param('ssssssssssssssssss', $regno, $fname, $class_app, $class_app, $cl, $start_session, $start_session, $gender, $dob, $religion, $state, $lga,  $nationality, $address, $parent, $parent_num, $passport, $school);
        if(!$q1->execute()){
          $error = "Sorry, a problem was encountered, please try again.";
          exit;
        }
        $q1->close();
        $source = '../studs/secondary applicants/'.$passport;
        $destination = '../studs/secondary passports/'.$passport;

        if(!copy($source, $destination)){
          echo "couldnt transfer images.";
          exit;
        }

        $q2 = $db->prepare('update students set status = ? where regno = ?');
        $status = 'accepted';
        $q2->bind_param('ss', $status, $regno);
        $q2->execute();

        $q2->close();
        $db->close();
        header("Location:applicants.php?status=accepted");
        exit;
      }
      else {
        header("Location:dashboard.php");
        exit;
      }
    }
    else {
      header('Location:application-list.php');
      exit;
    }
  }
  else {
    session_destroy();
    header('Location:login.php');
    exit;
  }
?>
