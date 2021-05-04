<?php
require_once ('../dbConfig.php');
require_once ('../session.php');

if(isset($_POST['Edit']))
{
    $sql = $conn->prepare("SELECT * FROM movie,photo WHERE movie.pID = photo.pID AND movieID=".$_POST['Edit']);
    $sql->execute();
    if($sql->rowCount()>0)
    {
        $results =$sql->fetchAll(PDO::FETCH_OBJ);
        foreach ($results as $result)
        {
            ?>


                <td></td>
                <td style="width: 250px"><input type="text" class="form-control" value="<?php echo $result->mName ?>" name="nameUp" placeholder='Name ' /> <small class="invalid-feedback nameE" ></small></td>
                <td><input type="text" class="form-control" value="<?php echo $result->mRate ?>"  name="rateUp"  placeholder=' Rate | 10 ' /><input type="hidden" name="pID" value="<?php echo $result->pID?>"/> <small class="invalid-feedback rateE"></small><br/>
                    <label for="pathUp<?php echo $result->movieID ?>" class="btn btn-outline-primary rounded-pill " style="cursor: pointer">Upload </label> <span class="img-name"><?php echo $result->pName ?></span></td>
                <td> <input class="form-control form-control-sm" id="pathUp<?php echo $result->movieID ?>" name="pathUp" placeholder="Choose the poster" type="file" style="display: none">

                    <div class="d-flex align-items-center justify-content-center img-preview" style="display: inline;height: 125px;width: 75px; background: #b8beb3;border-radius: 10px ;margin: 1px" >
                        <img src="uploaded-imgs/<?php echo $result->pName ?>" class="img-thumbnail small-img" height="125" width="75" alt="<?php echo $result->mName?>"/>
                    </div>
                </td>
                <td class="justify-content-start align-items-center" >
                    <button  data-bs-toggle="tooltip" title="Cancel" data-bs-placement="down" id="cancel<?php echo $result->movieID ?>"  class="btn btn-outline-danger "><i class="fas fa-times"></i></button>
                    <button  data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $result->movieID ?>"  class="btn btn-outline-warning "><i class="fas fa-check"></i></button>
                </td>




<?php
        }
    }
    else
    {
        echo $sql->errorInfo();
    }
}




if (isset($_POST['Update']))
{
    $photoName = '';

    if(isset($_FILES['pathUp']))
    {
        echo 'here';
        $test = explode('.', $_FILES['pathUp']['name']);
        $extension = end($test);
        $photoName = rand(100, 999) . '.' . $extension;
        $location = '../uploaded-imgs/' . $photoName;
        $stmt = $conn->prepare("UPDATE photo SET pName='" . $photoName . "' WHERE pID =" . $_POST['pID']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            move_uploaded_file($_FILES['pathUp']['tmp_name'], $location);
        } else {
            print_r($stmt->errorInfo());
        }
    }



    $RE = "";
    $NE = "";
    $IE = "";
    $valid = "true";
    $name = filter_var(trim($_POST['nameUp']), FILTER_SANITIZE_STRING);
    $rate = trim(floatval($_POST['rateUp']));

    if ($rate == null) {
        $valid = "false";
        $RE = 'Please enter the movie\'s rate';
    }
    else
    {
        if (filter_var($rate, FILTER_VALIDATE_FLOAT)) {
            if ($rate > 10  || $rate < 0)
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

    if ($name == "") {
        $valid = "false";
        $NE = "Movie name cannot be blank!!";
    }
    else
    {
        $sql = $conn->prepare('SELECT * FROM movie WHERE movieID <> '.$_POST['Update'].' AND mName="'.$name.'" AND uID='.$_SESSION['id']);
        $sql->execute();
        if($sql->rowCount()>0)
        {
            $valid = "false";
            $NE = "This film name already exists!!";
        }
    }

    if($valid == "true")
    {
        $update = $conn->prepare("UPDATE movie SET mName='".$name."', mRate=".$rate." WHERE movieID=".$_POST['Update']);

        $update->execute();

    }

    $sql= $conn->prepare("SELECT * FROM photo, movie WHERE movie.pID = photo.pID AND movieID=".$_POST['Update']);
    $sql->execute();
    if($sql->rowCount() === 1)
    {
        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach($results as $result)
        {
            $data = '{"status":'.$valid.', "RE":"'.$RE.'", "NE":"'.$NE.'",
              "Name":"'.$result->mName.'",
              "Rate":"'.$result->mRate.'",
              "Photo":"'.$result->pName.'",
               "mID":'.$result->movieID.'}';
            echo $data;
        }

    }


}
$conn = null ;
