<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Collection</title>
    <?php
    require_once ('dbConfig.php');
    include_once ('session.php');
    include_once('layouts/cssLinks.php');
    ?>
</head>
<body class="bg-primary">

<div class="container ">
    <div class="row fixed-top justify-content-center">
        <div class="col col-md-6 ">
            <div id="ValidLog" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none">
                <strong>Welcome Back </strong> We Have Missed You.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

<?php

include_once('layouts/navBar.php');

$sql = $conn->prepare(' SELECT CONCAT(firstName, " " ,lastName) as Fullname,movieID,mName,mRate,pName,movie.uID FROM movie,photo,d_user
    WHERE d_user.uID = movie.uID AND movie.pID = photo.pID AND movieID='.$_GET['id']);
$sql->execute();
$results = $sql->fetchAll(PDO::FETCH_OBJ);

?>


<div class="container-fluid text-white">


    <div class="row d-flex align-items-center justify-content-center" style="height: 550px">




        <div class="col col-md-8 ">


            <div class="card mb-3" >
                <div class="row g-0 ">
                    <div class="col-md-4">
                        <div class="zoomBOut">
                            <img src="uploaded-imgs/<?php echo $results[0]->pName ?>" class="zoomBIn" alt="<?php echo $results[0]->mName ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body text-dark">
                            <h2 class="card-title"><?php echo $results[0]->mName ?></h2>
                            <h4 class="text-primary"> <?php echo $results[0]->mRate ?> | 10</h4>
                            <h6 class="text-muted">Added And Rated By: <?php echo strtoupper($results[0]->Fullname) ?> </h6>
                            <?php
                                if($results[0]->uID == $_SESSION['id'])
                                {

                                    ?>

                                    <a href="myCollection.php" class="btn btn-outline-primary" role="button"> Click For More Options </a>
                            <?php
                                }

                            ?>
                             <a href="dvds.php" class="btn btn-outline-primary" role="button"><i class="fas fa-backward"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>








    <div class="row justify-content-center rounded mt-3">

        <div class="col col-md-8">

        </div>

    </div>
</div>







<?php
$conn = null ;
include_once('layouts/footer.php');
include_once('layouts/jsLinks.php');
?>


</body>
</html>