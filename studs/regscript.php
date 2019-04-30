<?php
  if (isset($_POST['sub_reg'])) {
    if ($_FILE['passport']['error'] > 0) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (($_FILES['passport']['type'] != 'image/png') && ($_FILES['passport']['type'] != 'image/jpg') && ($_FILES['passport']['type'] != 'image/jpeg')) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['surname'])) || (!preg_match("/^[a-zA-Z]*$/",$_POST['surname'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['f_name'])) || (!preg_match("/^[a-zA-Z]*$/",$_POST['f_name'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['othernames'])) || (!preg_match("/^[a-zA-Z\s]*$/",$_POST['othernames'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif (empty($_POST['dob'])) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['present_sch'])) || (!preg_match("/^[a-zA-Z\s]*$/",$_POST['present_sch'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['sch_addr'])) || (!preg_match("/^[a-zA-Z0-9\s]*$/",$_POST['sch_addr'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['duration'])) || (!preg_match("/^[a-zA-Z0-9\s]*$/",$_POST['duration'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['other_sch'])) || (!preg_match("/^[a-zA-Z\s]*$/",$_POST['other_sch'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif (empty($_POST['class'])) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif (empty($_POST['center'])) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['religion'])) || (!preg_match("/^[a-zA-Z]*$/",$_POST['religion'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['p_name'])) || (!preg_match("/^[a-zA-Z\s]*$/",$_POST['p_name'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['occupation'])) || (!preg_match("/^[a-zA-Z\s]*$/",$_POST['occupation'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['f_tribe'])) || (!preg_match("/^[a-zA-Z]*$/",$_POST['f_tribe'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['m_tribe'])) || (!preg_match("/^[a-zA-Z]*$/",$_POST['m_tribe'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( empty($_POST['state']) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( empty($_POST['class_app']) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['lga'])) || (!preg_match("/^[a-zA-Z\s]*$/",$_POST['lga'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['address'])) || (!preg_match("/^[a-zA-Z0-9\s]*$/",$_POST['address'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['fees'])) || (!preg_match("/^[a-zA-Z\s]*$/",$_POST['fees'])) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif ( (empty($_POST['phone'])) || (!preg_match("/^[0-9]*$/",$_POST['phone'])) || (strlen($_POST['phone']) != 11) ) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif (!(isset($_POST['terms']))) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    elseif (!(isset($_POST['sch_type']))) {
      //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
      header('Location:register.php');
      exit;
    }
    else {
      $imageType = $_FILES['passport']['type'];
      $passport = $_FILES['passport']['tmp_name'];
      if ($imageType == 'image/jpg' || $imageType == 'image/jpeg') {
        $imageType = 'jpg';
      }
      elseif ($imageType == 'image/png') {
        $imageType = 'png';
      }
      $imageName = $_POST['surname']."".$_POST['f_name'].date('Ymdhis').".".$imageType;
      $loc = "applicants/".$imageName;
      if (move_uploaded_file($passport, $loc)) {
        $fname = $_POST['f_name'];
        $surname = $_POST['surname'];
        $othernames = $_POST['othernames'];
        $dob = $_POST['dob'];
        $present_sch = $_POST['present_sch'];
        $sch_addr = $_POST['sch_addr'];
        $duration = $_POST['duration'];
        $other_sch = $_POST['other_sch'];
        $class = $_POST['class'];
        $center = $_POST['center'];
        $religion = $_POST['religion'];
        $sch_type = $_POST['sch_type'];
        $p_name = $_POST['p_name'];
        $occupation = $_POST['occupation'];
        $f_tribe = $_POST['f_tribe'];
        $m_tribe = $_POST['m_tribe'];
        $state = $_POST['state'];
        $lga = $_POST['lga'];
        $address = $_POST['address'];
        $fees = $_POST['fees'];
        $phone = $_POST['phone'];
        $class_app = $_POST['class_app'];
        $year = date('Y');
        include 'db.php';
        $q = $db->prepare('select number from track where year = ?');
        $q->bind_param('s', $year);
        $q->execute();
        $q->store_result();
        $n = $q->num_rows;

        if ($q > 0) {
          $q->bind_result($number);
          $q->fetch();
          $q->free_result();
          $q->close();
          ++$number;
          $q0 = $db->prepare('update track set number = ? where year = ?');
          $q0->bind_param('is', $number, $year);
          $q0->execute();
          $q0->close();
        }
        else {
          $q->free_result();
          $q->close();
          $number = 1;
          $q0 = $db->prepare('insert into track (year, number) values (?, ?)');
          $q0->bind_param('si', $year, $number);
          $q0->execute();
          $q0->close();
        }
        while (strlen($number) < 4) {
          $number = "0".$number;
        }
        $reg_no = "CMI".date('Y').$number;

        $q1 = $db->prepare('insert into registration (reg_no, sur_name, first_name, other_names, dob, present_school, present_school_address, duration, other_school, present_class, exam_center, religion, school_type, guardian, occupation, fathers_tribe, mothers_tribe, state_of_origin, lga, address, phone, who_will_pay_fees, passport, class_app, year) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $q1->bind_param('sssssssssssssssssssssssss', $reg_no, $surname, $fname, $othernames, $dob, $present_sch, $sch_addr, $duration, $other_sch, $class, $center, $religion, $sch_type, $p_name, $occupation, $f_tribe, $m_tribe, $state, $lga, $address, $phone, $fees, $imageName, $class_app, $year);

        if ($q1->execute()) {
          $q1->close();
          $db->close();
          $name = $surname." ".$fname." ".$oname;
          header("Location:succreg.php?name=$name&image=$imageName&center=$center&regno=$reg_no");
          exit;
        }
        else {
          //Delete applicants uploaded passport.
          unlink($loc);
          echo $q1->error;
          $q1->close();
          $db->close();
          //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
          header('Location:register.php');
          exit;
        }
      }
      else {
        //Do something like setting a session to alert the user that he/she has to fill every field in the form correctly.
        header('Location:register.php');
        exit;
      }
    }
  }
  else {
    header('Location:register.php');
    exit;
  }
?>
