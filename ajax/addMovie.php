<?php
require_once ('../dbConfig.php');


if(isset($_FILES['file'])&& isset($_POST['name']) && isset($_POST['rate']) && isset($_POST['uid']) ) {

    $NE = '';
    $RE = '';
    $IE = '';
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $rate = floatval(trim($_POST['rate']));
    $uID = filter_var($_POST['uid'],FILTER_VALIDATE_INT);
    $valid = 'true';
    if ($name == "") {
        $valid = "false";
        $NE = "Please enter the movie name!!";
    }
    else
    {
        $sql = $conn->prepare('SELECT * FROM movie WHERE mName="'.$name.'" AND uID='.$uID);
        $sql->execute();
        if($sql->rowCount()>0)
        {
            $valid = "false";
            $NE = "You have already added this film!!";
        }
    }

    if ($rate == null) {
        $valid = "false";
        $RE = 'Please enter the movie\'s rate';
    }
    else
    {
        if (filter_var($rate, FILTER_VALIDATE_FLOAT)) {
            if ($rate > 10 || $rate < 0)
            {
                $valid = "false";
                $RE = 'The movie\'s rate must be a number from 0 to 10';
            }

        }
        else
        {
            $valid = "false";
            $RE = 'The movie\'s rate must be a number';
        }
    }



    if($valid == "true")
    {
        $test = explode('.',$_FILES['file']['name']);
        $extension = end($test);
        $photoName = rand(100,999).'.'.$extension ;
        $location = '../uploaded-imgs/'.$photoName;

        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO photo (pName) VALUES ('$photoName')");
        $stmt->execute();

        $insertedId = $conn->lastInsertId();


        $stmt = $conn->prepare("INSERT INTO movie (mName, mRate, pID, uID) VALUES('$name',$rate,$insertedId,$uID)");

        $stmt->execute();
        $insertedId = $conn->lastInsertId();
        $conn->commit();

        if($stmt->rowCount()< 0)
        {
            $valid = "false";
            $IE = "Error in inserting";
        }
        else
        {
            $IE = "Insert";
            move_uploaded_file($_FILES['file']['tmp_name'],$location);
        }

        $data = '{"status":"'.$valid.'", "NE":"'.$NE.'", "RE":"'.$RE.'", "IE":"'.$IE.'", "Name":"'.$name.'", "Rate":"'.$rate.'", "Photo":"'.$photoName.'", "mID":'.$insertedId.'}';

    }
    else
    {
        $data = '{"status":"'.$valid.'", "NE":"'.$NE.'", "RE":"'.$RE.'", "IE":"'.$IE.'"}';
    }

    echo $data;
}
$conn = null;
