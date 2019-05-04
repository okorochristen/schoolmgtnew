<?php
include 'includes/db.php';
    $styl = mysqli_query($db, "SELECT MAX(total) as cc FROM scores");
    while($fetch = mysqli_fetch_array($styl)){
        $result = $fetch['cc'];
    }
  

    // $av = mysqli_query($db, "SELECT AVG(total) as ab FROM scores");
    // while($fetch = mysqli_fetch_array($av)){
    //     $result2 = $fetch['ab'];
    // }
    // echo $result2;
    
    
?>