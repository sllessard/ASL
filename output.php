<?php
session_start();
$_SESSION['current_rows'] = 0; //Reset number of rows displayed for use in ajaxData.php
if (!isset ($_SESSION['loggedin']) && $_SESSION['loggedin'] == false) {
  header('Location: index.php'); //Return user to landing if their session is expired. New entry required to view output.php

  $now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // If session expired on output.php load create new session.
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['discard_after'] = $now;
}

  @ $db = new mysqli('$host', '$username', '$passwd', '$dbname');

  //Get date and time of table creation for displaying on page.
   $creationquery = "select CREATE_TIME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tblname'";
  $creationresult = $db->query($creationquery);
  $creationTime = $creationresult->fetch_assoc();
  $when = $creationTime['CREATE_TIME'];
  $creationresult->free();
  $db->close();
?>
<!Doctype html>
<html lang="en" <?php if ($_SESSION['elshaddai'] == true) { //Check if user has God mode access
  echo 'id="leeloominai"'; }?>>
<head>
    <?php
      include 'includes/head.php';
      if ($_SESSION['elshaddai'] == true) { 
        echo '<title>a / s / l : GOD MODE</title>'; //God mode title.
      } else {
        echo '<title>a / s / l :</title>';
      }
       ?>
  </head>
</head>
<body>
  <main>
    <header class="resultsHeader">
      <h1><a href="index.php">a / s / l :</a></h1>
      <?PHP include_once 'includes/header.php';
        if ($_SESSION['elshaddai'] == true) { //God mode header?>
          <div class="gMode">
            <h2>††† GΩÐ MΩÐƸ †††</h2>
            <p>YOU CAN SEE THEM<br/>BUT THEY CAN’T SEE YOU.</p>
          </div>
        <?php } ?>
    </header>
    <div class="inputOutput" id="results">
      <?php include 'includes/ajaxdata.php'; //ajaxdata checks database for any entries not displayed and updates
       echo '<time class="creationDate">'.date("m \/ d \/ y", strtotime($when)).'&nbsp;&nbsp;&nbsp;—&nbsp;&nbsp;&nbsp;'.date("H : i : s", strtotime($when)).'&nbsp;&nbsp;&nbsp;—&nbsp;&nbsp;&nbsp;۞</time>'; //Table creation output
       ?>
    </div> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  setInterval( function(){
    $.get('includes/ajaxdata.php',function(data) {
      $('#results').prepend($(data));
    });
  }, 1000)
</script>
</body>
</html>