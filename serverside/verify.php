<?php

    session_start();

    include_once 'dbh.inc.php';

    // Verifies admin login
    if(isset($_POST['submit'])){
        
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $serverUsername = "";
        $serverPassword = "";
        
        $getQuery = "SELECT * FROM admin WHERE admin_username='$username'";
        if($results = mysqli_query($conn, $getQuery)){
            if(mysqli_num_rows($results) > 0){
                while($row = mysqli_fetch_array($results)){
                    $serverUsername = $row['admin_username'];
                    $serverPassword = $row['admin_password'];
                }
            }
        }

        if( !(empty($username) || empty($password)) ){
            if($username == $serverUsername){
                if(password_verify($password, $serverPassword)){
                    echo "Passowords Match!";
                    $_SESSION['admin_logged_in'] = $serverUsername;
                    $_SESSION['loginerror'] = 0;
                    header("Location: ../index.php?success");
                }
                else{
                    $_SESSION['loginerror'] = 1;
                    header("Location: ../admin.php?incorrect");     
                }
            }
            else{
                $_SESSION['loginerror'] = 1;
                header("Location: ../admin.php?empty");
            }
        }else{
            $_SESSION['loginerror'] = 1;
            header("Location: ../admin.php?empty");   
        }
        

    }