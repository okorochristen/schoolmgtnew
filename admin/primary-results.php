<?php session_start(); ?>
<?php if ( (isset($_SESSION['alogin'])) && (!empty($_SESSION['alogin'])) ): include 'includes/db.php';?>

  <!DOCTYPE HTML>
  <html>
  <head>
  <title>Result Checker</title>
  <link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
  <!-- tables -->
  <link rel="stylesheet" type="text/css" href="css/table-style.css" />
  <link rel="stylesheet" type="text/css" href="css/basictable.css" />
  <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
  <!-- //tables -->
  <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <!-- lined-icons -->
  <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <!-- //lined-icons -->
  </head>
  <body>
    <div class="container" style="margin:50px; padding-left:250px">
  <h3 class="text-center">Primary Results</h3>
  <form action="view-primary-result.php" method="post">
      <div class="row">
        <div class="form-group col-md-3">
          <label for="class">Class:</label>
          <?php
            $q = $db->prepare("SELECT class, id from pri_class");
            $q->execute();
            $q->bind_result($class, $classid);
          ?>
          <select class="form-control" name="class" required>
            <option value="">Select class</option>
            <?php while($q->fetch()): ?>
              <option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
            <?php endwhile; ?>
            <?php $q->free_result(); $q->close(); ?>

          </select>
        </div>
       <div class="form-group col-md-3">
         <label for="session">Accademic Session</label>
         <?php
           $q = $db->prepare("SELECT distinct session from scores order by session desc");
           $q->execute();
           $q->bind_result($session);
         ?>
         <select class="form-control" name="session" required>
           <option value="">Select session</option>
           <?php while($q->fetch()): ?>
             <option value="<?php echo $session; ?>"><?php echo $session; ?></option>
           <?php endwhile; ?>
           <?php $q->free_result(); $q->close(); ?>
         </select>
       </div>
       <div class="form-group col-md-3">
         <label for="class">Sub-Class</label>
         <select class="form-control" name="class2" required>
           <option value="">Select sub-class</option>
           <option value="a">A</option>
           <option value="b">B</option>
           <option value="c">C</option>
           <option value="d">D</option>
           <option value="e">E</option>
         </select>
       </div>
       <div class="form-group col-md-3">
         <label for="class">Term:</label>
         <select class="form-control" name="term" required>
           <option value="">Select term</option>
           <option value="1">1st</option>
           <option value="2">2nd</option>
           <option value="3">3rd</option>
         </select>
       </div>
   <div class="form-group col-md-6">
   <button type="submit" class="btn btn-info input-sm col-md-3">Continue</button>
   <a href="dashboard.php"class="btn btn-info input-sm col-md-3">Back</a>
   </div>
 </form>
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
