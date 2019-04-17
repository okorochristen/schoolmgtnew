<?php
  session_start();
  if ( isset($_SESSION['alogin'])  ){
    if (isset($_GET['stud_id'])) {
      if (isset($_POST['cl'])) {
        include 'includes/db.php';
        $cl = $_POST['cl'];
        $school = "primary";
        $regno = $_GET['stud_id'];
        $q = $db->prepare('select fname,start_session,gender,dob,religion,state,lga,nationality,class_app,address,parent,parent_num,passport from primary_applicants where regno = ?');
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
          echo $db->error;
          exit;
        }

        $q1->close();
        $source = '../studs/primary applicants/'.$passport;
        $destination = '../studs/primary passports/'.$passport;

        if(!copy($source, $destination)){
          echo "couldnt transfer images.";
          exit;
        }

        $q2 = $db->prepare('update primary_applicants set status = ? where regno = ?');
        $status = 'accepted';
        $q2->bind_param('ss', $status, $regno);
        $q2->execute();

        $q2->close();
        $db->close();
        header("Location:applicants2.php?status=accepted");
        exit;
      }
      else {
        header("Location:dashboard.php");
        exit;
      }
    }
    else {
      header('Location:applicants2.php');
      exit;
    }
  }
  else {
    session_destroy();
    header('Location:login.php');
    exit;
  }
?>
