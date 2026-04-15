<?php
include "connect.php";

//LOGIN USERS HERE
if($_SERVER["REQUEST_METHOD"]=="POST"){
    //get form data
    $email = mysqli_real_escape_string($conn , $_POST['email']);
    $password = mysqli_real_escape_string($conn , $_POST['password']);
    
    //FETCH DATABASE
    $sql = "SELECT * FROM users WHERE email = ''$email'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        //CHECK IF PASSOWRD IS CORRECT;
        if(password_verify($password, $user['password'])){
            echo "login successful! , Welcome" . $user['fullname'];
            
            $_SESSION['user'] = $user['email'];
            //redirect to dashboard..
            header("Location: dashboard.php");
        } else {
        //email doesnt exist
        echo "wrong password!!";
        }
    }else {
        echo "NO USER WITH THAT EMAIL";
    }
}
?>