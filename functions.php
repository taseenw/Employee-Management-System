<?php
    //File containing all of the frequently used functions in the project, all together so they may be easily incorporated multiple times throughout all the pages/files

    include('database.php'); //Include the database.php file in order to access and manipulate our database

    function addEmployee($newFn,$newLn,$newEmpID,$compID,$newEmail,$newNum){ //Function to insert a new employee into the database, with all of their information passed in as the parameters
        global $pdo;
        $qry = $pdo -> prepare("INSERT INTO employees (fname, lname, emp_id, comp_id, emp_email, phone_num) VALUES (:fname, :lname, :emp_id, :comp_id, :emp_email, :phone_num)");
        $qry -> execute(array(
            'fname' => $newFn,
            'lname' => $newLn,
            'emp_id' => $newEmpID,
            'comp_id' => $compID,
            'emp_email' => $newEmail,
            'phone_num' => $newNum
        ));

        header("Refresh: 0");//After form is submitted and the new employee is added, refresh the page
    }

    function loginCheck($user_entry, $password_entry){ //Function to cover all possible cases when a user attempt to login, with the attempted username/password as the parameters
        global $pdo;
        
        $qry = $pdo -> prepare("SELECT user_pass FROM users WHERE user_name =:entry;");
        $qry -> execute(array(
            'entry' => $_POST["uiuser"]
        ));

        $hashpass = $qry -> fetchAll(PDO::FETCH_ASSOC); // Pulling the correct password
        
        if(isset($hashpass[0]['user_pass'])){ //If the entered username matched with a password in the table (existing username)
            if(password_verify($password_entry,$hashpass[0]['user_pass'])){ //Right password
                return true; //Password was correct
            }
            else{
                return false; //Password WAS NOT correct, username is valid
            }
        }
        else{ //Username invalid
            echo "<p class='p1'>Username is unregistered! Try again<br>Or click signup!</p>";
        }
    }

    function createAccountModal(){ //Function that can be called to display the create account modal for new users
        ?>
        <br><button type="button" class="btn1 btn-outline-success btn-lg" onclick="nuOpenModal()"/>Sign Up</button>
        <div class="modal fade" id="nuModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuModal">Create an Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action='' method='POST'>
                        <div class="modal-body">
                            <table class=newAccount>
                                <tr><th>Company Name: </th><td><input type='text' name='newCN' required></td></tr>
                                <tr><th>Email: </th><td><input type='email' name='newAddr' required></td></tr>
                                <tr><th>Username: </th><td><input type='text' name='newUN' required></td></tr>
                                <tr><th>Password:</th><td><input type='password' name='newPass' required></td></tr>
                                <tr><td colspan="2">-</td></tr><tr><td colspan="2">Company already registered?<br>Have an existing manager log on and create your user</td></tr>
                           </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name='addUser' class="btn btn-success">Confirm registration</button>
                     </form>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($_POST['addUser'])){
            $companyID=findCompID();//Find the last comp ID
            addUser($_POST['newUN'],$_POST['newPass'],$companyID,$_POST['newCN'],$_POST['newAddr']);//Passing new info, adding one to comp ID as its the next company
        }
    }

    function findCompID(){ //Function used to find latest comp ID so we can create the newest one
        global $pdo;

        $qry = $pdo -> prepare("SELECT comp_id FROM users ORDER BY comp_id");//The company IDs will be pulled in numerical order
        $qry -> execute();

        $compIDs = $qry -> fetchAll(PDO::FETCH_ASSOC);
        $maxIndex=count($compIDs)-1; //The idea here is that we take the quantity of company IDs, and subtract one to get the index value of the highest company ID
        $newID=$compIDs[$maxIndex]['comp_id']+1;//Add one to the highest company ID to create the newest one
        
        return $newID;//Returning new company ID
    }

    function addUser($newUN,$newPass,$newCompID,$newCN,$newAddr){ //Function to add a new user account to the database, with all of their information passed in as the parameters
        $hashNewPass=password_hash($newPass, PASSWORD_DEFAULT);
        global $pdo;
        
        $qry = $pdo -> prepare("INSERT INTO users (user_name, user_pass, comp_id, comp_name, user_email) VALUES (:user_name, :user_pass, :comp_id, :comp_name, :user_email)");
        $qry -> execute(array(
            'user_name' => $newUN,
            'user_pass' => $hashNewPass,
            'comp_id' => $newCompID,
            'comp_name' => $newCN,
            'user_email' => $newAddr
        ));

        header("Refresh: 0");//After form is submitted and the new employee is added, refresh the page
    }

    function pullUserInf($loggedin){ //Function to pull in the data of the user thats logged in through the database, with their username as the parameters
        global $pdo;
        
        $qry = $pdo -> prepare("SELECT * FROM users WHERE user_name =:user;");
        $qry -> execute(array(
            'user' => $loggedin
        ));

        $loggedin_info = $qry -> fetchAll(PDO::FETCH_ASSOC);

        return $loggedin_info; //Sending back all the data in the table that corresponds with the logged in user
    }

    function pullUsers($loggedinCompId){ //Function to pull all registered users with the same company ID (manager at same company) from the database, passing in the company ID as parameters
        global $pdo;
        
        $qry = $pdo -> prepare("SELECT * FROM users WHERE comp_id =:compID ORDER BY user_name;");
        $qry -> execute(array(
            'compID' => $loggedinCompId
        ));

        $sameCompUsers = $qry -> fetchAll(PDO::FETCH_ASSOC);

        return $sameCompUsers; //Sending back all the data on users that are in the same company matching the ID passed in.
    }

    function pullEmployees($loggedin_comp_id){ //Function to pull in all the employees with the same company ID as the user logged in, passing in the comany ID as parameters
        global $pdo;

        $qry = $pdo -> prepare("SELECT * FROM employees WHERE comp_id =:compid ORDER BY lname;");
        $qry -> execute(array(
            'compid' => $loggedin_comp_id
        ));
        $employees = $qry -> fetchAll(PDO::FETCH_ASSOC); // Pulling every employee in the table with the according comp_id

        return $employees;
    }

    function pullSingleEmployee($empPhone){ //Function to pull a single employees info out from the database using their phone number (no duplicates exist), passing in the number as the parameters
        global $pdo;

        $qry = $pdo -> prepare("SELECT * FROM employees WHERE phone_num =:passedNum;");
        $qry -> execute(array(
            'passedNum' => $empPhone
        ));
        $employee = $qry -> fetchAll(PDO::FETCH_ASSOC); // Pulling every employee in the table with the according comp_id

        return $employee;
    }
    function addMngOpen($comp_ID,$comp_name){ //Function for the button/modal to add manager *TO EXISTING COMPANY*, passing in the company ID and username of the user logged in as parameters?>
        <button type="button" class="btn2 btn-outline-success btn-lg" onclick="nmOpenModal()"/>Add Manager</button>
            <div class="modal fade" id="nmModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nmModal">Add Manager</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action='' method='POST'>
                            <div class="modal-body">
                                <table class=newAccount>
                                    <tr><th>Email: </th><td><input type='email' name='nmAddr' required></td></tr>
                                    <tr><th>Username: </th><td><input type='text' name='nmUN' required></td></tr>
                                    <tr><th>Password:</th><td><input type='password' name='nmPass' required></td></tr>
                            </table>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name='addMng' class="btn btn-success">Confirm</button>
                        </form>
                            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Close</button>
                            </div>
                    </div>
                </div>
            </div>
        
        <?php  
        if (isset($_POST['addMng'])){
            addUser($_POST['nmUN'],$_POST['nmPass'],$comp_ID,$comp_name,$_POST['nmAddr']);//If they submit, run function to add user passing info
        }   
    }

    function addEmpOpen($comp_ID){ //Function for the button/modal to add an employee, passing in the company ID as parameters?>
 
        <button type="button" class="btn2 btn-outline-success btn-lg" onclick="aeOpenModal()"/>Add Employee</button>
     
        <div class="modal fade" id="aeModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aeModal">New Employee Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action='' method='POST'>
                        <div class="modal-body">
                            <table class=newEntry>
                                <tr><th>Employee ID: </th><td><input type='number' name='newEmpID' required></td></tr>
                                <tr><th>First Name: </th><td><input type='text' name='newFN' required></td></tr>
                                <tr><th>Last Name: </th><td><input type='text' name='newLN' required></td></tr>
                                <tr><th>Email:</th><td><input type='email' name='newEmail' required></td></tr>
                                <tr><th>Phone #:</th><td><input type='tel' pattern="[0-9]{10}" name='newNum' required></td></tr>
                           </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name='addEmp' class="btn btn-success" onclick="ref()">Confirm</button>
                     </form>
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div>
    
        <?php  
        if (isset($_POST['addEmp'])){ //If they submit, run function to add user passing all the new information as parameters
            addEmployee($_POST['newFN'],$_POST['newLN'],$_POST['newEmpID'],$comp_ID,$_POST['newEmail'],$_POST['newNum']);
        }
    }



    function logOutButton(){ // Function to create and display the logout button?>
        <!-- Button and Modal for LogOut -->
        <button type="button" class="btn1 btn-outline-success btn-lg" onclick="LCopenModal()"/>Logout</button>
        <div class="modal fade" id="logoutCon" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="loModal">Logout Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure you would like to logout?</p>
                    </div>

                    <div class="modal-footer">
                        <a type="button" class="btn btn-success" href="logOut.php"/>Log Out</a>
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Close</button>
                    </div>

                    </div>
            </div>
        </div>
<?php }

    function uploadEdits($updID,$updFN,$updLN,$updEmail,$updNum,$opgNum){ //Function to complete the desired employee edits to the database, passing in all employee details as parameters, to replace the old ones with
        global $pdo;
        
        $qry = $pdo->prepare("UPDATE employees SET fname = :fname, lname = :lname, emp_id = :emp_id, emp_email = :emp_email, phone_num = :phone_num WHERE phone_num = :oldNum");
        $qry -> execute(array(
            'fname' => $updFN,
            'lname' => $updLN,
            'emp_id' => $updID,
            'emp_email' => $updEmail,
            'phone_num' => $updNum,
            'oldNum' => $opgNum
        ));

        header("Refresh: 0");//After form is submitted and the new employee is added, refresh the page
    }

    function delEmployee($empDetails){ //Function to delete a specific employee from the database, with the desired employees details as the parameters
        global $pdo;
        
        $qry = $pdo -> prepare("DELETE FROM employees WHERE phone_num = :num");
        $qry -> execute(array(
            'num' => $empDetails[0]['phone_num']
        ));

    }
?>