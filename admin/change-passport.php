<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors','on');
  if (isset($_SESSION['alogin'])) {
    $url = $_SERVER['HTTP_REFERER'];
    if (isset($_POST['psp_sb'])) {
      if ($_FILES['psp_btn']['error'] > 0) {
  			$_SESSION['passport'] = "There is something wrong with the file you uploaded.";
	      header("Location:$url");
	      exit;
	    }
	    elseif ( ($_FILES['psp_btn']['type'] != 'image/png') && ($_FILES['psp_btn']['type'] != 'image/jpg') && ($_FILES['psp_btn']['type'] != 'image/jpeg') ) {
	    	$_SESSION['passport'] = "You can only upload jpg and png files.";
	      header("Location:$url");
	      exit;
	    }
	    else{
        $name = $_POST['in'];
        if ($_POST['school'] == "sec") {
          $path = "../student-portal/secondary passports/";
        }
        else {
          $path = "../student-portal/primary passports/";
        }
        $file = $path.$name;
        if (unlink($file)) {
          $fname = $_POST['name'];
          $imageType = $_FILES['psp_btn']['type'];
  	      $image = $_FILES['psp_btn']['tmp_name'];

  	      if ($imageType == 'image/jpg' || $imageType == 'image/jpeg') {
  	        $imageType = 'jpg';
  	      }
  	      elseif ($imageType == 'image/png') {
  	        $imageType = 'png';
  	      }
  	      $passport = $fname."".date('Ymdhis').".".$imageType;
  	      $loc = $path.$passport;
  	      if (move_uploaded_file($image, $loc)) {
            $id = $_GET['id'];
            include 'includes/db.php';
            $q = $db->prepare("update accepted_students set passport = ? where regno = ?");
            $q->bind_param('ss',$passport,$id);
            if ($q->execute()) {
              $_SESSION['passport'] = "Passport has been changed succesfully.";
            }
            else {
              $_SESSION['passport'] = "Oops...Something went wrong, please try again. 1";
              unlink($loc);
            }
            $q->close();
            $db->close();
            header("Location:$url");
            exit;
          }
          else {
            $_SESSION['passport'] = "Oops...Something went wrong, please try again. 2";
          }
        }
        else {
          $_SESSION['passport'] = "Oops...Something went wrong, please try again. 3";
        }
      }
    }
    else {
      header("Location:$url");
      exit;
    }
  }
  else {
    header("Location:logout.php");
    exit;
  }

?>
