<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ALL DVDS'</title>
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


?>


<div class="container-fluid text-white">


    <div class="row justify-content-center">




        <div class="col col-md-8 ">


            <div class="card bg-dark text-white " style="width: 100%">
                <img src="images/sample2.jpg" style="width: 100%; height: 200px; object-fit: cover; opacity: 0.30"
                     class="card-img" alt="...">
                <div class="card-img-overlay p-xs-5">
                    <h5 class="card-title display-5 text-uppercase ">Here is alll the movies we have</h5>
                    <p class="card-text">Here is where you can see more movies suggestions form other users</p>

                </div>
            </div>


        </div>
    </div>



    <div class="container">
        <div class="row justify-content-center  text-dark  mt-3">
            <div id="search5" class="col col-md-6 rounded bg-dark">

                <form class="d-flex p-3">
                    <input id="search2" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                </form>

            </div>

        </div>

    </div>
    <div class="container rounded p-2 mb-2 mt-3">
        <div id="movies" class="row justify-content-center rounded mt-3 " style="margin-bottom: 100px;">
            <?php
                $sql = $conn->prepare(' SELECT CONCAT(firstName, " " ,lastName) as Fullname,movieID,mName,mRate,pName FROM movie,photo,d_user
    WHERE d_user.uID = movie.uID AND movie.pID = photo.pID');
                $sql->execute();
                if($sql->rowCount() > 0)
                {
                    $results = $sql->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results as $result)
                    {




            ?>


                    <div class="card bg-gradient col-md-3 m-2 col-sm-12 bg-dark" style=" height: 450px; width: 220px;">
                        <div class="zoomBOut card-img-top">
                          <a href="movie.php?id=<?php echo $result->movieID?>"><img src="uploaded-imgs/<?php echo $result->pName; ?>" class=" zoomBIn" alt="..."></a>
                        </div>
                        <div class="card-body text-center text-light">
                            <h5 class="card-title"><?php echo $result->mName; ?></h5>
                            <p class="card-text">Rate: <?php echo $result->mRate; ?>/10 <br/> By: <?php echo $result->Fullname; ?></p>
                        </div>
                    </div>


            <?php


                    }
                }
            ?>


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