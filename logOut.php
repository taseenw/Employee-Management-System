<?php
  //File used once a user logs out, in order to delete and unset the session and its variables, and send the user back to the homepage

  session_start();
  session_unset();
  session_destroy();
  header("location: index.php");

?>
