<?php
  session_start();
  if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
    if (!empty($_GET['class'] && !empty($_GET['class2'])) && !empty($_GET['term']) && !empty($_GET['session'])) {
      include 'includes/db.php';

      $class = $_GET['class'];
      $class2 = $_GET['class2'];
      $term = $_GET['term'];
      $session = $_GET['session'];

      $q = $db->prepare("delete from result where class = ? && sclass = ? && term = ? && session = ?");
      $q->bind_param('ssss',$class,$class2,$term,$session);
      $q->execute();
      $q->close();

      if($term == 3){
        $q = $db->prepare("delete from promotional_scores1 where session = ? and class = ? and class2 = ?");
        $q->bind_param('sss',$session,$class,$class2);
        $q->execute();
        $q->close();

        $q = $db->prepare("select regno, average from promotional_result1 where session = ? and class = ? and class2 = ?");
        $q->bind_param('sss',$session,$class,$class2);
        $q->execute();
        $q->store_result();
        $q->bind_result($regno, $average);
        while ($q->fetch()) {
          $q0 = $db->prepare("select current_session from accepted_students where regno = ?");
          $q0->bind_param('s',$regno);
          $q0->execute();
          $q0->bind_result($current_session);
          $q0->fetch();
          $q0->free_result();
          $q0->close();
          $session_array = explode("/",$current_session);
          $s1 = $session_array[0];
          $s2 = 1;
          $s2 = $s1 - $s2;
          $newsession = $s2."/".$s1;

          $q0 = $db->prepare("update accepted_students set current_session = ? where regno = ?");
          $q0->bind_param('ss',$newsession,$regno);
          $q0->execute();
          $q0->close();

          if ($average >= 50) {
            $q0 = $db->prepare("select current_class from accepted_students where regno = ?");
            $q0->bind_param('s',$regno);
            $q0->execute();
            $q0->bind_result($current_class);
            $q0->fetch();
            $q0->free_result();
            $q0->close();
            --$current_class;

            $q0 = $db->prepare("update accepted_students set current_class = ? where regno = ?");
            $q0->bind_param('ss',$current_class,$regno);
            $q0->execute();
            $q0->close();

            if ($current_class == 6) {
              $q0 = $db->prepare("update accepted_students set status = ? where regno = ?");
              $status = "1";
              $q0->bind_param('ss',$status,$regno);
              $q0->execute();
              $q0->close();
            }
          }
        }
        $q->close();

        $q = $db->prepare("delete from promotional_result1 where session = ? and class = ? and class2 = ?");
        $q->bind_param('sss',$session,$class,$class2);
        $q->execute();
        $q->close();
      }
      $db->close();
      $_SESSION['msg'] = "Result was reset Successfully.";



      header("Location:view-secondary-result.php?class=$class&class2=$class2&term=$term&session=$session");
      exit;
    }
    else {
      $url = $_SERVER['HTTP-REFERER'];
      header("Location:$url");
      exit;
    }

  } else {
    header("Location:logout.php");
    exit;
  }

?>
