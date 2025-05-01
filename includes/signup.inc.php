<?php
    if(isset($_POST['signup-submit'])){
        require 'dbh.inc.php';

        $username = $_POST['uid'];
        $Email = $_POST['mail'];
        $Password = $_POST['pwd'];
        $PasswordRepeat = $_POST['pwd-repeat'];

        //error handling
        if(empty($username) || empty($Email) || empty($Password) || empty($PasswordRepeat) ){
            header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$Email);
            exit();
        }
        //if there is a email error & a username error
        elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("Location: ../signup.php?error=invalidemailuid");
            exit();
        }
        //if there is a email error
        elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
            header("Location: ../signup.php?error=invalidemail&uid=".$username);
            exit();
        }
        ////if there is a username error
        elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("Location: ../signup.php?error=invaliduid&mail=".$Email);
            exit();
        }
        //if two passwords didnt match
        elseif( $Password !== $PasswordRepeat){
            header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$Email);
            exit();
        }

        //if a user tries to SignUP enter a username which is already in the databse, then  it will show error
        else{
            $sql = "SELECT username FROM lists WHERE username=?";
            $stmt = mysqli_stmt_init($conn); //it checks the DB connection with prepared statements

            if(!mysqli_stmt_prepare($stmt, $sql)){ //if DB connection with prepared statements failed
                header("Location: ../signup.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $username); //take the username from from users
                mysqli_stmt_execute($stmt); //here we execute the stmt and see if there is any user with the same username in the DB
                mysqli_stmt_store_result($stmt); //the result we got from the DB, return and store in the "$stmt" variable
                $resultCheck = mysqli_stmt_num_rows($stmt); //$resultCheck variable store the number of results (rows) returned from the DB
                if($resultCheck > 0){
                    header("Location: ../signup.php?error=userTaken&mail=".$Email);
                    exit();
                }
                else{
                    $sql = "INSERT INTO lists(username, email, password) values(?,?,?)";
                    $stmt = mysqli_stmt_init($conn); //it checks the DB connection with prepared statements

                    if(!mysqli_stmt_prepare($stmt, $sql)){ //if DB connection with prepared statements failed
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                    }
                    else{
                        $hasedPwd = password_hash($Password, PASSWORD_DEFAULT); //here we hashed the password using BCRYPT default method

                        mysqli_stmt_bind_param($stmt, "sss", $username, $Email, $hasedPwd); 
                        //take the username, email & password from from users

                        mysqli_stmt_execute($stmt); //here we execute the stmt and inserting into the DB
                        header("Location: ../signup.php?signup=success");
                        exit();
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else{
        header("Location: ../signup.php"); //if user gain access without clicking the "signUP" button
        exit();
    }
?>
