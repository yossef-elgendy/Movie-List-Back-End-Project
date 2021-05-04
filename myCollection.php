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


?>


<div class="container-fluid text-white">


    <div class="row justify-content-center">




        <div class="col col-md-8 ">


            <div class="card bg-dark text-white " style="width: 100%">
                <img src="images/sample2.jpg" style="width: 100%; height: 200px; object-fit: cover; opacity: 0.30"
                     class="card-img" alt="...">
                <div class="card-img-overlay p-xs-5">
                    <h5 class="card-title display-5 text-uppercase ">My Top Ten</h5>
                    <p class="card-text">Here is where you can make your list.</p>

                </div>
            </div>

            <div id="errorImg" class=" col col-md-12 mt-1 mb-2" style="display: none" >

            </div>




        </div>
    </div>



    <div class="row justify-content-center rounded mt-3">
        <div class="col col-md-8 ">
            <table id="AddForm" class="table text-light bg-dark table-borderless rounded ">
                <tr class=" justify-content-center">
                    <th>Add Movie</th>
                    <th style="width: 250px"><input type="text" class="form-control" id="name" placeholder='Name ' /> <small class="invalid-feedback" id="nameE"></small></th>
                    <th><input type="text" class="form-control" id="rate" placeholder=' Rate | 10 ' /> <small class="invalid-feedback" id="rateE"></small><br/>
                        <label for="path" class="btn btn-outline-primary rounded-pill " style="cursor: pointer">Upload </label> <span id="img-name"></span></th>
                    <th> <input class="form-control form-control-sm" id="path" placeholder="Choose the poster" type="file" style="display: none">

                        <div id="img-preview" class="d-flex align-items-center justify-content-center" style="display: inline;height: 125px;width: 75px; background: #b8beb3;border-radius: 10px ;margin: 1px" >
                            <span class="text-center text-muted">Preview</span>
                        </div>
                    </th>
                    <th class="d-flex justify-content-center align-items-center" style="height: 125px" ><button  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add" value="<?php echo $_SESSION['id']?>" id="add1" class="btn-primary rounded"><i class="fas fa-plus"></i></button></th>
                </tr>
            </table>
        </div>

    </div>

    <div class="container">
        <div class="row justify-content-center  text-dark  mt-3">
            <div id="search5" class="col col-md-6 rounded bg-dark">

                <form class="d-flex p-3">
                    <input id="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                </form>

            </div>

        </div>

        <div class="row justify-content-center  text-dark ">
            <div id="alert" class=" col col-md-4 mt-1 mb-2" style="display: none" >

            </div>
        </div>
    </div>

    <div class="row justify-content-center rounded mt-3">

        <div class="col col-md-8">
            <table id="list_1"  class="table bg-dark text-light table-borderless rounded  table-striped table-margin">
                <tr class="text-light">
                    <th>#</th>
                    <th >Name</th>
                    <th>Rate</th>
                    <th>Poster</th>
                    <th>Options</th>
                </tr>
                <tbody id="list">
                    <?php
                        $stmt = $conn->prepare('SELECT movieID,mName,mRate,pName,movie.pID FROM photo,movie WHERE photo.pID = movie.pID AND movie.uID ='.$_SESSION['id']);
                        $stmt->execute();
                        if($stmt->rowCount()>0)
                        {
                            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $result)
                            {
                                ?>
                    <tr class="text-light">
                        <td class="count"></td>
                        <td><?php echo $result->mName ?></td>
                        <td><?php echo $result->mRate ?></td>
                        <td><img src="uploaded-imgs/<?php echo $result->pName ?>" class="img-thumbnail small-img" height="125" width="75" alt="<?php echo $result->mName?>"/></td>
                        <td class="text-lg-start">
                            <button data-bs-toggle="modal" data-bs-target="#delete<?php echo $result->movieID ?>"
                                                          name="deletee" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>
                            </button>
                            <button data-bs-toggle="tooltip" value="<?php echo $result->movieID ?>" data-bs-placement="right"
                                    title="Edit" name="edit" class="btn btn-outline-primary edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <div class="modal fade" id="delete<?php echo $result->movieID ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-light">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $result->mName ?></h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this movie ?
                                    </div>
                                    <div class="modal-footer p-2">
                                        <button type="button" class="btn btn-secondary p-2" data-bs-dismiss="modal">Cancel</button>
                                        <button name="delete" data-bs-dismiss="modal" type="button" value="<?php echo $result->movieID ?>" class="btn btn-danger delete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="updateModal<?php echo $result->movieID ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-light">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $result->mName ?></h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to save changes for this movie ?
                                    </div>
                                    <div class="modal-footer p-2">
                                        <button type="button" class="btn btn-secondary p-2" data-bs-dismiss="modal">Cancel</button>
                                        <button name="delete" data-bs-dismiss="modal" type="button" value="<?php echo $result->movieID ?>" id="update<?php echo $result->movieID ?>" class="btn btn-success ">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>

                    <?php

                            }
                        }

                    ?>
                </tbody>

            </table>
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