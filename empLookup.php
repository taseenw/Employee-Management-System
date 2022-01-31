<?php
    //File ran as a request from employeHub.php, to pull the employee's data (that matches with the passed phone number), and have their information replace the modals body

    include('functions.php'); //Including functions file so we can call them in here

    $empInfo=pullSingleEmployee($_GET['empPhone']); //Function to pull the specific employees info
?>

<!-- Going to be sent to main page-->
<table class='empHub'>
    <tr><th class='info'>Employee ID: </th><td><?php echo $empInfo[0]['emp_id'];?>
    <tr><th class='info'>First Name: </th><td><?php echo $empInfo[0]['fname'];?></td></tr>
    <tr><th class='info'>Last Name: </th><td><?php echo $empInfo[0]['lname'];?></td></tr>
    <tr><th class='info'>Email: </th><td><?php echo $empInfo[0]['emp_email'];?></td></tr>
    <tr><th class='info'>Phone #: </th><td><?php echo $_GET['empPhone'];?></td></tr>
</table>