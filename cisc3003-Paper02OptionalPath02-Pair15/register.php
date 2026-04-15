<?php
include "connect.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
//get form data

    $fullname = mysqli_real_escape_string($conn , $_POST['fullname']);
    $email = mysqli_real_escape_string($conn , $_POST['email']);
    $password = mysqli_real_escape_string($conn , $_POST['password']);
    
    //check if email is already in database
    $checkEmail = "SElECT * FROM uers WHERE email ='$email'";
    $result = $conn->query($checkEmail);
    
    if($result->num_rows > 0){
        echo "Email already has a account";
    } else {
        //CREATE ACCOUNT // SAVE DATA TO DATABASE
        // SECURITY - HASHING
        $hashed_password = password_hash($password , PASSWORD_BCRYPT);
        $sql = "INSERT INTO users(fullname, email, password) VALUES ('$fullname','$email',
'$hashed_password')";
        
        if($conn->query($sql)===TRUE){
            //account created
            echo "<script>alert('Account Created!!!');
            window.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "Error" . $sql . $conn->error;
        }
    }
}
?>