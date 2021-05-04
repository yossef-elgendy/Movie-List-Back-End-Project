<?php
require_once ('../dbConfig.php');
if(isset($_POST['email']) || isset($_POST['pw']))
{
    $email = filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
    $pw = filter_var(trim($_POST['pw']),FILTER_SANITIZE_STRING);
    $EE = "";//Error in the email
    $PE = "";//Error in the password
    $LE = "";//message for indicating if the login was successful or not.
    $valid = 'true';
    $sql = "SELECT * FROM d_user WHERE email='$email'";
    $query = $conn->prepare($sql);
    $query->execute();

    if($query->rowCount() == 1 )
    {

        $results = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($results as $result)
        {
            if(password_verify($pw,$result->pass))
            {
                $LE="Login";


            }
            else
            {
                $PE = "Invalid Password!!";
                $valid = 'false';
            }
        }

    }
    else
    {
        $valid = 'false';
        $EE = "Invalid email or password";
    }
    $data = '{"status":"'.$valid.'", "EE":"'.$EE.'", "PE":"'.$PE.'", "LE":"'.$LE.'"}';
    echo $data;
}


$conn = null ;