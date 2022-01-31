<?php
    //File constructing the page users are sent to when they select employee hub, to view/edit/remove existing employees in their company

    //Including the files that connect to the database, and that contain all our frequently used functions
    include('database.php');
    include('functions.php');

    session_start();

    if (!$_SESSION['user_name']) header("location:index.php"); //Send back if not logged in
    $loggedin_info = pullUserInf($_SESSION['user_name']); //Bring in logged in users info
    $employee_info = pullEmployees($loggedin_info[0]['comp_id']); //Bring in all employees and their info with the matching comp_id

    if(isset($_POST['saveChanges'])){ //If the save changes button was pressed for editing, *at top top since the function has a header, it has to be above print statements
        uploadEdits($_POST['updID'],$_POST['updFN'],$_POST['updLN'],$_POST['updEmail'],$_POST['updNum'],$_POST['orgNum']); //If edits submited, run function to upload them to the database
    }
    addEmpOpen($loggedin_info[0]['comp_id']); //Call function to display the button and form to add an employee, which will add an employee if submitted, pass comp ID

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TW Employee Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>

    <style>
        
        table.table,th.main,tr.table-success,td.table-success{
            width:450px;
            border:1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align:center;
        }
        table.del{
            width:250px;
            border:1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align:center;

        }
        button.btn1{
            position:absolute;
            bottom: 92%;
            right:3%;
        }
        table.empHub{
            line-height: 188%;
        }
        table.newEntry,table.mod,th.info{
            text-align:center
        }
        h2,h3{
            color: white;
        }

        h2{
            position:absolute;
            left:2.5%;
            top:15%;
        }
        button.btn2{
            position:absolute;
            left:2.5%;
            top: 22%;
        }
        table.table{
            position:absolute;
            left:2.5%;
            top:30%;
        }

        button.btn3{
            position:absolute;
            bottom: 85%;
            right:10%;
        }

        body.main{
        background:#5cb85c;
        }
        .name{
            color: #5cb85c;
	        font-size: 55px;
            text-align:center;

            }
        .center{
            margin: auto;
            width: 40%;
            length: 100%;
            padding: 100px;
        }
        a:link{
            color: black;
            background-color: transparent;
            text-decoration: none;
        }
        a:visited {
            color: black;
            background-color: transparent;
            text-decoration: none;
        }
        a:hover {
            color: green;
            background-color: transparent;
            text-decoration: underline;
        }
        a:active {
            color: green;
            background-color: transparent;
            text-decoration: underline;
        }
    </style>
    
    <body class='main'>

        <div class="p-3 mb-2 bg-light text-dark">
            <a href="userHome.php"><h1 class='name'>TW Employee Management</h1><a>
        </div>

        <h2>Employees for <?php echo $loggedin_info[0]['comp_name'];?></h2><br>
       
        <br><br>

        <table class='table table-striped table-dark'>     
            <thead>
                <th class='main'>Employee ID</th><th class='main'>Full Name</th><th>REMOVE</th>
            </thead>
            <?php
                for($x=0;$x<count($employee_info);$x++){//Loop through every employee
                    echo "\n\t\t\t<tr class='table-success'>"; 
                        echo "<td class='table-success'>";
                            echo $employee_info[$x]['emp_id'];
                        echo "</td><td class='table-success'><a href='#' onclick='EDopenModal(",$employee_info[$x]['phone_num'],")'/>"; //If user clicks on the name of an employee, run js function, passing the phone number (to use to search for that specific employee, as there are no duplicate numbers allowed)
                            echo $employee_info[$x]['lname'],", ",$employee_info[$x]['fname'];
                    echo "</a></td><td class='del'><button onclick='deOpenModal(",$employee_info[$x]['phone_num'],")'/>X</button></td></tr>";//If user clicks on x, run js function to open delete model, passing phone number to know which user to delete
                }
                echo "\n"
            ?>
        </table>

        <!-- Modal for employee data -->
        <div class="modal fade" id="empdata" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="empModal">Employee Data</h5><t><button class="btn btn-success" onclick="changeToForm()">Edit</button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- using id replace with data -->
                        <p id='empinf'>placeholder</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Close</button> 
                    </div>

                    </div>
            </div>
        </div>


        <!-- Modal for deleting employee -->
        <div class="modal fade" id="deModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="deModal">Delete Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- using id replace with data -->
                        <p id='deModalBody'>placehold</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delReq()">Delete</button>
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Close</button> 
                    </div>

                    </div>
            </div>
        </div>
       
       <?php 
        logOutButton();//Display logout button?>

        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        
        <script>

            var gloPhoneNum; //Storing specific users number after its passed in once
            var gloDelPhoneNum; //Storing specific users number after its passed in once amongst delete functions

            function LCopenModal() { //Open logout modal
                var logoutCon = new bootstrap.Modal(document.getElementById('logoutCon'));
                logoutCon.show();
            }
            
            function aeOpenModal(){//Open Add Employee modal
                var aeBody = new bootstrap.Modal(document.getElementById('aeModal'));
                aeBody.show();
                
            }

            function deOpenModal(phone_num){ //Delete employee modal
                var deModal = new bootstrap.Modal(document.getElementById('deModal'));
                deModal.show();
                gloDelPhoneNum=phone_num;
                var body = document.getElementById("deModalBody");

                var qhttp = new XMLHttpRequest(); //Ajax
                qhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // this.responseText is the response
                    body.innerHTML = this.responseText;
                    }
                };
                qhttp.open("GET", "empDelConf.php?phone_num="+phone_num); //Deletion confirmation from another page, passing phone number to specify and use that employees info
                qhttp.send();

            }

            function EDopenModal(empPhone){ //Open employee data modal
                var empdata= new bootstrap.Modal(document.getElementById('empdata'));
                empdata.show();
                gloPhoneNum=empPhone;
                var body = document.getElementById("empinf");

                var xhttp = new XMLHttpRequest(); //Ajax
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // this.responseText is the response
                    body.innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "empLookup.php?empPhone="+empPhone);//Looking up employee via another page, passing phone number to identify the specific employee we're looking for
                xhttp.send();

            }
            function changeToForm(){ // Function used when users clicks to edit employee info, in order to change the modals content into a form, switching the body to what is returned from requestion (php)
                var body = document.getElementById("empinf");

                var yhttp = new XMLHttpRequest(); //Ajax
                yhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // this.responseText is the response
                    body.innerHTML = this.responseText;
                    }
                };
                yhttp.open("GET", "toForm.php?gloPhoneNum="+gloPhoneNum);
                yhttp.send();
            }
            
            function delReq(){ //Function to implement 'delEmp.php' which will occur when user confirms deletion
                var body = document.getElementById("deModalBody");

                var dhttp = new XMLHttpRequest(); //Ajax
                dhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // this.responseText is the response
                    body.innerHTML = this.responseText;
                    }
                };
                dhttp.open("GET", "delEmp.php?gloDelPhoneNum="+gloDelPhoneNum);
                dhttp.send();

                window.location.reload() //Refresh page after deletion complete
            }

        </script>
        
    <body>
</html>