<?php
session_start();

$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // If session expired on output.php load create new session.
    session_unset();
    session_destroy();
    session_start();
}

$_SESSION['discard_after'] = $now;

  // create short variable names
  $id = NULL;
  $ageSelect=trim($_POST['ageSelect']);
  $sexSelect=trim($_POST['sexSelect']);
  $locationEntry = trim($_POST['locationEntry']);
  $date=date('m \/ d \/ y').'&nbsp;&nbsp;&nbsp;—&nbsp;&nbsp;&nbsp;'.date('H : i : s');


 if (!$ageSelect || !$sexSelect || !$locationEntry) //Check if all inputs have value. Fallback for disabled JS.
  {
     $_SESSION['fieldscomplete'] = false; //Set session variable for use in index.php
     header('Location: ../index.php'); //Return user to homepage
     exit;
  } else { //Connect to database if all fields complete and process entry
    $_SESSION['fieldscomplete'] = true; 
  
  @ $db = new mysqli('$host', '$username', '$passwd', '$dbname');

   if (mysqli_connect_errno()) 
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

  //Check input against God mode credentials
  $permissionprepare = $db->prepare("SELECT * from $tblname
                                      WHERE $agerow = ? 
                                      AND $sexrow = ?
                                      AND $locationrow = ?");
  $permissionprepare->bind_param("sss", $_POST['ageSelect'], $_POST['sexSelect'], $_POST['locationEntry']);
  $permissionprepare->execute();
  $permissionresult = $permissionprepare->get_result();

  if (!$permissionresult) {
    printf("Errormessage: %s\n", $db->error);
  } elseif ($permissionresult->num_rows > 0) { //If God mode credentials exist. No entry, view output.php allowed.
      $row = $permissionresult->fetch_assoc();
      $_SESSION['elshaddai'] = true;
      $_SESSION['loggedin'] = true;
      header('Location: ../output.php');
      exit;
  } else { //If credentials do not match insert entry into database and send user to output.php.
    $_SESSION['loggedin'] = true;
    $insertprepare = $db->prepare("INSERT INTO $tblname VALUES (?, ?, ?, ?, ?)");
    $insertprepare->bind_param("sssss", $id, $ageSelect, $sexSelect, $locationEntry, $date);
    $insertprepare->execute();
    header('Location: ../output.php');
      exit;
    if(!$insertresult) {
      printf("Errormessage: %s\n", $db->error);
    }
  }

  $permissionresult->free();
  $insertresult->free();
  $db->close();
}
  ?>