<?php session_start(); error_reporting(E_ALL); ini_set('display_errors', 'on');?>
<?php if ((isset($_SESSION['alogin'])) && (!empty($_SESSION['alogin']))):
    include 'includes/db.php';

    $q = $db->prepare('SELECT class, id from classes');
    $q->execute();
    $q->store_result();
    $q->bind_result($class, $classid);

    $q1 = $db->prepare('SELECT distinct session from result order by session desc');
    $q1->execute();
    $q1->store_result();
    $q1->bind_result($session);
?>

  <!DOCTYPE HTML>
  <html>
  <head>
  <title>Generate Pin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
  <!-- Custom CSS -->
  <link href="css/style.css" rel='stylesheet' type='text/css' />
  <link rel="stylesheet" href="css/morris.css" type="text/css"/>
  <!-- Graph CSS -->
  <link href="css/font-awesome.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="js/jquery-2.1.4.min.js"></script>
  <!-- //jQuery -->
  <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <!-- lined-icons -->
  <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <!-- //lined-icons -->
  </head>
  <style>
  @media screen and (max-width: 600px) {
    .small{
        padding-left:60px!important;
        position:relative;
    }
    .small h3{
      padding-left:12px;
    }
}
</style>
  <body>
    <div class="small container col-md-offset-3 col-md-6" style="padding-top: 90px">
      
      <h3>GENERATE PIN FOR SECONDARY RESULT CHECKING</h3><br>
      <div class="row">

        <div class="container col-md-12 col-md-offset-6">
        <form class="" action="generate-script.php" method="post" role="form">
           <div class="form-group">
             <label for="session">SESSION:</label>
             <select class="form-control" name="session" required>
              <option value="">Select Session</option>
               <?php while ($q1->fetch()): ?>
                 <option value="<?php echo $session; ?>"><?php echo $session; ?></option>
               <?php endwhile; $q1->close(); ?>
             </select>
           </div>
           <div class="form-group">
             <label for="class">CLASS:</label>
             <select class="form-control" name="class" id="class" required>
              <option value="">Select Class</option>
               <?php while ($q->fetch()): ?>
                 <option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
               <?php endwhile; $q->close(); ?>
             </select>
           </div>
           <div class="form-group">
             <label for="term">SUB-CLASS</label>
             <select class="form-control" name="class2" id="class2" required>
               <option value="">Select sub-class</option>
               <option value="a">A</option>
               <option value="b">B</option>
               <option value="c">C</option>
               <option value="d">D</option>
               <option value="e">E</option>
             </select>
           </div>
           <div class="form-group">
             <label for="term">TERM:</label>
             <select class="form-control" name="term" id="term" required>
              <option value="">Select Term</option>
               <option value="1">1st</option>
               <option value="2">2nd</option>
               <option value="3">3rd</option>
             </select>
           </div>
           <a href="dashboard.php" class="btn btn-info btn-md">BACK</a>
           <button type="submit" class="btn btn-success btn-md">GENERATE</button>
        </form>
        </div>
      </div>
    </div>
    <?php include('includes/sidebarmenu.php');?>
  </body>
  </html>

<?php else:
  header("Location:logout.php");
  exit;
?>

<?php endif; ?>
