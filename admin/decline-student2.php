<?php
  session_start();
  if ( isset($_SESSION['alogin'] ) ){
    if (isset($_GET['stud_id'])) {
      include 'includes/db.php';
      $reg_no = $_GET['stud_id'];
      $q = $db->prepare('update primary_applicants set status = ? where regno = ?');
      $status = 'declined';
      $q->bind_param('ss', $status, $reg_no);
      $q->execute();
      $q->close();
      $db->close();
      header("Location:applicants2.php?status=declined");
      exit;
    }
    else {
      header('Location:applicants2.php');
      exit;
    }
  }
  else {
    session_destroy();
    header('Location:index.php');
    exit;
  }
?>
