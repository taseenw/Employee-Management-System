<?php
    //File constructing the user homepage, to which they are sent once successfully logged on

    //Including the files that connect to the database, and that contain all our frequently used functions
    include('database.php');
    include('functions.php');

    session_start();
    if (!$_SESSION['user_name']) header("location:index.php"); //Send back if not logged in
    $loggedin_info = pullUserInf($_SESSION['user_name']); //Bring in logged in users info
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
        h2,h3{
            color: white;
        }
        h2{
            position:absolute;
            left:2.5%;
            top:15%;
        }
        h3{
            position:absolute;
            left:2.5%;
            top:20%;
        }
        button.btn2{
            position:absolute;
            left:2.5%;
            top: 28%;
        }

        button.btn3{
            position:absolute;
            left:2.5%;
            top: 36%;
        }

        button.btn1{
            position:absolute;
            bottom: 92%;
            right:3%;
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
    </style>

    <body class='main'>
        
        <div class="p-3 mb-2 bg-light text-dark">
            <h1 class='name'>TW Employee Management</h1>
        </div>
        
        <h2>Welcome, <?php echo $loggedin_info[0]['user_name'];?></h2>
        <h3>Company ID: <?php echo $loggedin_info[0]['comp_id'];?></h3>
        
        <div class='options' id='sel'>
            <br><button class="btn2 btn-outline-success btn-lg" onclick="location.href ='employeeHub.php'">Employee Hub</button><br><br>
            <button class="btn3 btn-outline-success btn-lg" onclick="location.href='mngHub.php'">Manager Hub</button>
        </div>

        <?php logOutButton();//Display logout button?>

        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        
        <script>
            function LCopenModal() { //Function to open the logout modal
                var logoutCon = new bootstrap.Modal(document.getElementById('logoutCon'));
                logoutCon.show();
            }
        </script>

    <body>
</html>