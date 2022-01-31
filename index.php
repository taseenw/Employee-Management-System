<?php
    //File constructing the homepage encountered when the website is first accessed

    //Including the files that connect to the database, and that contain all our frequently used functions
    include('database.php');
    include('functions.php');

    session_start();
    
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
        button.btn1{
            position:absolute;
            bottom: 92%;
            right:3%;
        }

        body.text-center{
        background:#5cb85c;
        }
        .name{
            color: #5cb85c;
	        font-size: 55px;

            }
        .center{
            margin: auto;
            width: 40%;
            length: 100%;
            padding: 100px;
        }
        p{
            font-size:20px;

            color:white;
        }
        p.p1{
            position:absolute;
            bottom: 37%;
            right:41.5%;
        }
        p.p2{
            position:absolute;
            bottom: 39%;
            right:41.5%;
        }
        h2{
            color:white;
        }

        h3{
            color:white;
            text-align:center;
            position:absolute;

            bottom: 64%;
            left:43.5%;
        }
        
    </style>

    <body class='text-center'>

        <div class="p-3 mb-2 bg-light text-dark">
            <h1 class='name'>TW Employee Management</h1>
        </div>      

        <h2>The Filing Cabnet That Will Never Get Messy</h2>
        <h3 class='display-3'>Welcome</h3>

        <?php
        
            if(isset($_POST["submit"])){ //If login was pressed, check if the login was correct
                $loginSuccess=loginCheck($_POST["uiuser"],$_POST["uipass"]);
                if($loginSuccess){ // If login was successefull
                    echo 'Correct Password'; 
                    $_SESSION['user_name']=$_POST["uiuser"];
                    header("location:userHome.php");
                }
            }
 
            if(!isset($_POST["submit"]) OR !$loginSuccess){ //If page hasn't been submitted OR login was unsuccessful
        ?>

        <br><br><br><br>
                <div class='center'>
                    <form action='' class=bod method='POST'>
                        <input type='text' name='uiuser' placeholder='Username' required><br>
                        <input type='password' name='uipass' placeholder='Password'required>
                        <br><br><input class="btn btn-success btn-lg" type='submit' name='submit' value='Login'>
                    </form>   

        <?php
                    if(isset($loginSuccess)){ //If variable is set and is false; indicates incorrect password with valid username
                        echo "<br><p class='p2'>Incorrect Password! Please Try Again</p>";
                    }
            }
            
                     createAccountModal();//Function call to display button and form to create new user, which will then call function to add new user to database if submitted
        
        ?>

                </div>
        

        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        
        <script>
            function nuOpenModal(){//Function to open the New User Modal
                var nuBody = new bootstrap.Modal(document.getElementById('nuModal'));
                nuBody.show();
               
            }
        </script>
    
    <body>
</html>