<?php
    //File ran as a request from employeHub.php, in order to delete the employee with the matching phone number that was passed

    include('functions.php'); //Including functions file so we can call them in here

    $empInfo=pullSingleEmployee($_GET['gloDelPhoneNum']); //Function to pull the specific employees info
    delEmployee($empInfo);//Call to function to delete the user, passing in its details
?>
<!-- Going to be sent to main page-->
<b>Deletion Complete</b>