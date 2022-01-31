<?php
    //File constructing the homepage managers access once they log in

    //Including the files that connect to the database, and that contain all our frequently used functions
    include('database.php');
    include('functions.php');

    session_start();
    if (!$_SESSION['user_name']) header("location:index.php"); //Send back if not logged in
    $loggedin_info = pullUserInf($_SESSION['user_name']); //Bring in logged in users info
    $allUsers = pullUsers($loggedin_info[0]['comp_id']);//Bring in all users in the same company, passing the comp id to match with users in database
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
            width:500px;
            border-collapse: collapse;
            padding: 5px;
            text-align:center;

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
            border:1px solid black;
        }

        th.main,tr.table-success,td.table-success{
            border:1px solid black;
        }

        button.btn1{
            position:absolute;
            bottom: 92%;
            right:3%;
        }
        table.empHub{
            line-height: 188%;
        }
        table.newAccount{
            text-align:center;
        }
        h2,h3{
            color: white;
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
        
        <h2>Managers for <?php echo $loggedin_info[0]['comp_name'];?></h2><br>       

        <?php addMngOpen($loggedin_info[0]['comp_id'],$loggedin_info[0]['comp_name']); //Call function to display the button and form to add an employee, which will add an employee if submitted, pass comp ID and name as those don't change?> 

        <br><br>
        
        <table class='table table-striped table-dark'>     
            <thead>
            <th class='main'>Email Address<th class='main'>Username</th>
            <thead>
            <?php
                for($x=0;$x<count($allUsers);$x++){//Loop through every user
                    echo "\n\t\t\t<tr class='table-success'>"; 
                        echo "<td class='table-success'>"; //If user clicks on the name of an employee, run js function, passing the phone number (to use to search for that specific employee, as there are no duplicate numbers allowed)
                            echo $allUsers[$x]['user_email'];
                        echo "</td><td class='table-success'>";
                            echo $allUsers[$x]['user_name'];
                        echo "</td></tr>";
                }
                echo "\n"
            ?>
        </table>

       
       <?php 
        logOutButton();//Display logout button?>

        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        
        <script>
            
            function nmOpenModal(){
                var nmBody = new bootstrap.Modal(document.getElementById('nmModal'));
                nmBody.show();
            }

            function LCopenModal() { //Open logout modal
                var logoutCon = new bootstrap.Modal(document.getElementById('logoutCon'));
                logoutCon.show();
            }
        </script>
        
    <body>
</html>