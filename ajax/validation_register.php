<?php
require_once ('../dbConfig.php') ;
if(isset($_POST['currentTab']))
{
    $nameRegex = '/^[a-zA-Z]{3,}$/';
    $pwRegex = '/(?=^.{8,}$)(?=.*\d)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*/';
    $emailRegex = '/([\w.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/';
    $mobileRegex = "/^01[0-2][0-9]{8}/";


    if($_POST['currentTab'] ==  0)
    {

        if(isset($_POST['firstName']) || isset($_POST['lastName']))
        {
            $FNE = ""; // First name error message
            $LNE = ""; // Last name error message
            $valid = "true"; // key to determine if the tab is validated or no

            $firstName = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
            if($firstName == "")
            {
                $FNE = "Please enter your first name !!";
                $valid = "false" ;
            }
            else
            {
                 if(preg_match($nameRegex, $firstName) == 0)
                 {
                     $FNE = "Please enter a valid first name !!";
                     $valid = "false" ;
                 }


            }


            $lastName = filter_var($_POST['lastName'],FILTER_SANITIZE_STRING);
            if($lastName  == "")
            {
                $LNE = "Please enter your last name !!";
                $valid = "false" ;
            }
            else
            {
                if(preg_match($nameRegex, $lastName) == 0)
                {
                    $LNE = "Please enter a valid last name !!";
                    $valid = "false" ;
                }


            }

            $data = '{"status":'.$valid.', "FNE":"'.$FNE.'", "LNE":"'.$LNE.'"}';
            echo $data ;
        }


    }

    if($_POST['currentTab'] ==  1)
    {
        if(isset($_POST['email']) || isset($_POST['pw']) || isset($_POST['pwC']))
        {
            $email = $_POST['email'];
            $pw = filter_var($_POST['pw'], FILTER_SANITIZE_STRING);
            $pwC = filter_var($_POST['pwC'], FILTER_SANITIZE_STRING);
            $valid = "true"; // key to determine if the tab is validated or no
            $EE = ""; // Email error message
            $PE = ""; // Password error message
            $PCE = ""; // Password confirmation message

            if($email == "")
            {
                $EE = "Please enter your email !!";
                $valid = "false";
            }
            else
            {
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $sql = "SELECT email From d_user WHERE email=:em";
                    $query = $conn->prepare($sql);
                    $query->bindParam(':em',$email,PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if($query->rowCount() > 0)
                    {
                        $EE = "This email already exists !!";
                        $valid = "false";
                    }

                }
                else
                {
                    $EE = "Please enter a valid email !!";
                    $valid = "false";

                }
            }

            if($pw == "")
            {
                $PE = "Please enter a password !!";
                $valid = "false";
            }
            else
            {
                if(preg_match($pwRegex, $pw) == 0)
                {
                    $PE = "A password must consist of at least one capital character, lowercase character and minimum of 8 characters !!";
                    $valid = "false";
                }
                if($pwC == "")
                {
                    $PCE = "Please confrim your password !!";
                    $valid = "false";
                }
                else
                {
                    if($pwC != $pw)
                    {
                        $PCE = "The two passwords do not match !!";
                        $valid = "false";
                    }
                }
            }

            $data = '{"status":'.$valid.', "EE":"'.$EE.'", "PE":"'.$PE.'", "PCE":"'.$PCE.'"}';
            echo $data ;

        }
    }

    if($_POST['currentTab'] ==  2)
    {
        if(isset($_POST['mobile']) || isset($_POST['city']))
        {
            $valid = "true";
            $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_STRING);
            $city = $_POST['city'];
            $ME = ""; // error message for the mobile number
            $CE = ""; // error message for the city
            $IE = ""; // indicates error in inserting

            if($mobile == "")
            {
                $ME = "Please enter your mobile number !!";
                $valid = "false";
            }
            else
            {

                if(preg_match($mobileRegex, $mobile) == 0)
                {
                    $ME = "Please enter a valid mobile number !!";
                    $valid = "false";
                }
                else
                {
                    if(strlen($mobile)>11)
                    {
                        $ME = "Please enter a valid mobile number !!";
                        $valid = "false";
                    }
                    else
                    {


                        $sql = "SELECT mobile From d_user WHERE mobile=:mb";
                        $query = $conn->prepare($sql);
                        $query->bindParam(':mb',$mobile,PDO::PARAM_STR);
                        $query->execute();
                        if($query->rowCount() > 0)
                        {
                            $ME = "This mobile number already exist !!";
                            $valid = "false";
                        }
                    }


                }
            }

            if($city == "")
            {
                $CE = "Please choose a city !!";
                $valid = "false";
            }

            if($ME == "" && $CE == "" && $valid=="true")
            {
                if($_POST['submit']!=null)
                {

                    $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
                    $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
                    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
                    $pw = password_hash(filter_var(trim($_POST['pw']), FILTER_SANITIZE_STRING),PASSWORD_DEFAULT);
                    $mobile = filter_var(trim($_POST['mobile']), FILTER_SANITIZE_STRING);
                    $city = filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);



                    $sql = "INSERT INTO d_user (firstName,lastName,email,pass,mobile,cityID) VALUES('$firstName','$lastName','$email','$pw','$mobile',$city)";
                    $query = $conn->prepare($sql);
                    $query->execute();

                    if ($query->rowCount() > 0) {
                        $IE = 'insert';
                    } else {
                        $IE = 'error';
                    }




                }
            }

            $data = '{"status":'.$valid.', "ME":"'.$ME.'", "CE":"'.$CE.'", "IE":"'.$IE.'"}';
            echo $data ;

        }


    }
}



$conn = null ;