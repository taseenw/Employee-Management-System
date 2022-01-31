<?php
    //File ran as a request from employeHub.php, to replace the modals body with the confirmation message, INCLUDING the specific employees details

    include('functions.php'); //Including functions file so we can call them in here

    $empInfo=pullSingleEmployee($_GET['phone_num']); //Function to pull the specific employees info
?>

<!-- Going to be sent to main page-->
<p><b>Confirm Deletion of: </b><i><?php echo $empInfo[0]['fname']," ",$empInfo[0]['lname']?></i></p>
<p>*This is permanent and irreversible*</p>