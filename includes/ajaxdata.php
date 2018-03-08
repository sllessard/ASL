<?php  
session_start();

  @ $db = new mysqli('$host', '$username', '$passwd', '$dbname');

  if (mysqli_connect_errno()) 
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

  $postquery = "SELECT * FROM $tblname ORDER BY entriesid DESC";
  $postresult = $db->query($postquery);
  $num_results = $postresult->num_rows;

  for ($i=$_SESSION['current_rows']; $i <$num_results; $i++) //current_rows initially set in output.php
  { //Output any rows not currently displayed on output.php
     $row = $postresult->fetch_assoc();
     echo '<div class="entryHeader">
            <time>'.stripslashes($row['date']).'</time>
            <p class="entryNumber">#'.htmlspecialchars($row['entriesid']).'</p>
          </div>';
     echo '<div class="entryOutput verticalDividers">
            <p>'.htmlspecialchars($row['age']).' / </p>
            <p>'.htmlspecialchars($row['sex']).' / </p>
            <p>'.htmlspecialchars($row['location']).'</p>
          </div>';
  }
  
  $_SESSION['current_rows'] = $num_results;

  $postresult->free();
  $db->close();
?> 