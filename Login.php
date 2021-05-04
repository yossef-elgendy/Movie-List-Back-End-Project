<?php

require_once('dbConfig.php');
if (isset($_POST['email']) || isset($_POST['password'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $pw = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $error= '';
    $sql = "SELECT * FROM d_user WHERE email='$email'";
    $query = $conn->prepare($sql);
    $query->execute();

    if ($query->rowCount() == 1) {

        $results = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($results as $result) {
            if (password_verify($pw, $result->pass)) {
                session_start();
                $_SESSION['email']= $result->email;
                $_SESSION['pw'] = $result->pass;
                $_SESSION['id'] = $result->uID;
                $_SESSION['firstName']=$result->firstName;
                $_SESSION['lastName']=$result->lastName;
                $_SESSION['wellDone'] = "HI";

                if (isset($_POST['rememberMe'])) {
                    setcookie('email', $email, time() + 30 * 24 * 60 * 60);
                    setcookie('pw', $pw, time() + 30 * 24 * 60 * 60);
                } else {
                    setcookie('email', $email, time() - 30 * 24 * 60 * 60);
                    setcookie('pw', $pw, time() - 30 * 24 * 60 * 60);
                }


                header('refresh:0;url=index.php');




            } else {
                $error = "Invalid Password!!";
                $valid = 'false';
            }
        }

    } else {
        $error = "Invalid email or password";
    }

}


$conn = null;