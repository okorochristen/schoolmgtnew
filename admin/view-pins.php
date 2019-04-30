<?php session_start(); ?>
<?php if ( (isset($_SESSION['alogin'])) && (!empty($_SESSION['alogin'])) ): include 'includes/db.php';?>

  <!DOCTYPE HTML>
  <html>
  <head>
  <title>View Secondary Pins</title>
  <!--<link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">-->
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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="css/table-style.css" />
  <link rel="stylesheet" type="text/css" href="css/basictable.css" />
  <script type="text/javascript" src="jquery.dataTables.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="sum().js"></script>
<scr$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
  <script type="text/javascript">
  
      $(document).ready(function() {
        $('#table').basictable();

        $('#table-breakpoint').basictable({
          breakpoint: 768
        });

        $('#table-swap-axis').basictable({
          swapAxis: true
        });

        $('#table-force-off').basictable({
          forceResponsive: false
        });

        $('#table-no-resize').basictable({
          noResize: true
        });

        $('#table-two-axis').basictable();

        $('#table-max-height').basictable({
          tableWrapper: true
        });
      });
  </script>
  <!-- //tables -->
  <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <!-- lined-icons -->
  <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <!-- //lined-icons -->
  </head>
  <style>
    @media (max-width:600px){
    .smally{
        margin-top:50px!important;
        margin-left:45px!important;
        width:90%!important;
    }
    .botton{
      margin-bottom:30px;
    }
}
.smally{
    margin-top:80px;
    margin-left:230px;
    width:90%;
}
.smally h3{
  padding-bottom:40px;
}
  </style>
  <body>
    <div class="container smally">
    <?php if ( isset($_GET['session']) && isset($_GET['class']) && isset($_GET['term']) && isset($_GET['class2']) ):
      $session = $_GET['session'];
      $term = $_GET['term'];
      $class = $_GET['class'];
      $class2 = $_GET['class2'];
      $q = $db->prepare("select regno, pin from result_checker where session = ? and term = ? and class = ?  and class2 = ? order by regno desc");
      $q->bind_param('ssss', $session, $term, $class, $class2);
      $q->execute();
      $q->store_result();
      $n = $q->num_rows;

      $q0 = $db->prepare("select class from classes where id = ?");
      $q0->bind_param('s', $class);
      $q0->execute();
      $q0->bind_result($cl);
      $q0->fetch();
      $q0->free_result();
      $q0->close();
    ?>
       <!--/content-inner-->
       <?php if ($n > 0):
         $c = 0;
         $q->bind_result($r,$p);

         if ($term == 1) {
           $ad = "st";
         }
         elseif ($term == 2) {
           $ad = "nd";
         }
         else {
           $ad = "rd";
         }
       ?>
       <h4 style="text-transform:uppercase">Result Pins for <?php echo $cl.$class2.", $term$ad term $session accademic session"; ?></h4>
       <table id="example" class="display" style="width:100%">
         <thead>
           <tr>
             <th>#</th>
             <th>Name</th>
             <th>Regno</th>
             <th>Pin</th>
           </tr>
         </thead>
         <tbody>
           <?php while ($q->fetch()):
             $c++;
             $q0 = $db->prepare("select fname from accepted_students where regno = ?");
             $q0->bind_param("s",$r);
             $q0->execute();
             $q0->bind_result($name);
             $q0->fetch();

             $q0->free_result();
             $q0->close();
           ?>
             <tr>
               <td><?php echo $c; ?></td>
               <td><?php echo $name; ?></td>
               <td><?php echo $r; ?></td>
               <td><?php echo $p; ?></td>
             </tr>
           <?php endwhile; ?>
           <?php $q->close(); ?>
         </tbody>
       </table>
       <?php else: ?>
         <h3 class="text-center" style="text-transform:uppercase">Pins haven't been generated or no students in <?php echo $cl." ".$class2; ?></h3>
       <?php endif; ?>
  <?php $db->close(); ?>

<?php else: ?>
  <h3 class="text-center ">View List of Pins Generated for Primary School Students</h3>
  <form class="form-group" role="form">
      <div class="row">

   <div class="form-group col-md-3">
     <label for="session">Academic Session</label>
     <?php
       $q = $db->prepare("SELECT distinct session from result order by session desc");
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
     <label for="class">Class:</label>
     <?php
       $q = $db->prepare("SELECT class, id from classes");
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
   <button type="submit" class="btn btn-info input-sm col-md-3 botton">Submit</button>
   <a href="dashboard.php"class="btn btn-info input-sm col-md-3">Back</a>
   </div>
 </form>
 </div>
<?php endif; ?>
</div>
        <script>
            $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
                } );
            } );
            
            
        </script>



<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <?php include('includes/sidebarmenu.php');?>
  </body>
</html>
<?php else:
  header("Location:logout.php");
  exit;
?>
<?php endif; ?>
