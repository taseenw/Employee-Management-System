<?php
    //File called when user is requesting to edit employee details, returning a form with all possible information of the employee as the values, to be used as the modals body

    include('functions.php'); //Including functions file so we can call them in here

    $empInfo=pullSingleEmployee($_GET['gloPhoneNum']); //Function to pull the specific employees info
?>

<!-- Going to be sent to main page, replacing the info with a form enabling user to edit info *SUBMITTING OLD PHONE NUMBER TO KNOW WHICH USER TO CHANGE*-->
<form action='' method='POST'>
    <table class='mod'>
        <tr><th>Employee ID: </th><td><input type='number' value='<?php echo $empInfo[0]['emp_id'];?>' name='updID' required></td></tr>
        <tr><th>First Name: </th><td><input type='text' value='<?php echo $empInfo[0]['fname'];?>' name='updFN' required></td></tr>
        <tr><th>Last Name: </th><td><input type='text' value='<?php echo $empInfo[0]['lname'];?>' name='updLN' required></td></tr>
        <tr><th>Email: </th><td><input type='email' value='<?php echo $empInfo[0]['emp_email'];?>' name='updEmail' required></td></tr>
        <tr><th>Phone #: </th><td><input type='tel' pattern="[0-9]{10}" value='<?php echo $empInfo[0]['phone_num'];?>' name='updNum' required></td></tr>
        <input hidden type='text' value='<?php echo $empInfo[0]['phone_num'];?>' name='orgNum'>
    </table><br>
    <button type="submit" name='saveChanges' class="btn btn-success">Confirm Changes</button>
</form>