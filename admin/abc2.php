<?php session_start(); ?>
<?php if (isset($_SESSION['alogin'])): ?>
  <?php if (isset($_GET['id']) && isset($_GET['class']) && isset($_GET['session'])):
    include 'includes/db.php';
    $id = $_GET['id'];
    $classid = $_GET['class'];
    $session = $_GET['session'];

    $q = $db->prepare("select fname from primary_applicants where regno = ?");
    $q->bind_param('s',$id);
    $q->execute();
    $q->bind_result($name);
    $q->fetch();
    $q->close();

    $q = $db->prepare("select count(id) from accepted_students where class = 'a' and school = 'primary' and current_class = ? and current_session = ?");
    $q->bind_param('ss',$classid, $session);
    $q->execute();
    $q->bind_result($na);
    $q->fetch();
    $q->close();

    $q = $db->prepare("select count(id) from accepted_students where class = 'b' and school = 'primary' and current_class = ? and current_session = ?");
    $q->bind_param('ss',$classid, $session);
    $q->execute();
    $q->bind_result($nb);
    $q->fetch();
    $q->close();

    $q = $db->prepare("select count(id) from accepted_students where class = 'c' and school = 'primary' and current_class = ? and current_session = ?");
    $q->bind_param('ss',$classid, $session);
    $q->execute();
    $q->bind_result($nc);
    $q->fetch();
    $q->close();

    $q = $db->prepare("select count(id) from accepted_students where class = 'd' and school = 'primary' and current_class = ? and current_session = ?");
    $q->bind_param('ss',$classid, $session);
    $q->execute();
    $q->bind_result($nd);
    $q->fetch();
    $q->close();

    $q = $db->prepare("select count(id) from accepted_students where class = 'e' and school = 'primary' and current_class = ? and current_session = ?");
    $q->bind_param('ss',$classid, $session);
    $q->execute();
    $q->bind_result($ne);
    $q->fetch();
    $q->close();
 ?>
      <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Select student class</title>
          <link rel="stylesheet" href="css/bootstrap.min.css">
          <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
          <script type="text/javascript" src="js/bootstrap.min.js"></script>
          <script type="text/javascript" src="js/sf.js"></script>
        </head>
        <body>
          <div class="container">
            <div class="panel panel-default" style="border: 1px solid black; padding:10px; margin-top:50px; border-radius:4px;">
              <div class="panel-heading" style="">
                <b>Select class for <?php echo $name; ?></b>
              </div>
              <hr>
              <div class="panel-body">
                <form class="" action="accept-student2.php?stud_id=<?php echo $id; ?>" method="post" id="clf">
                  <p>A <input type="radio" name="cl" value="A" onclick="sf()"> There are <?php echo $na; ?> students in this class already</p>
                  <p>B <input type="radio" name="cl" value="B" onclick="sf()"> There are <?php echo $nb; ?> students in this class already</p>
                  <p>C <input type="radio" name="cl" value="C" onclick="sf()"> There are <?php echo $nc; ?> students in this class already</p>
                  <p>D <input type="radio" name="cl" value="D" onclick="sf()"> There are <?php echo $nd; ?> students in this class already</p>
                  <p>E <input type="radio" name="cl" value="E" onclick="sf()"> There are <?php echo $ne; ?> students in this class already</p>
                </form>
              </div>
            </div>
          </div>
        </body>
      </html>
  <?php else:
    if (empty($_SERVER['HTTP_REFERER'])) {
      header("Location:dashboard.php");
      exit;
    }
    else {
      $url = $_SERVER['HTTP_REFERER'];
      header("Location:$url");
      exit;
    }
  ?>
  <?php endif; ?>
<?php else:
  header("Location:logout.php");
  exit;
?>
<?php endif; ?>
