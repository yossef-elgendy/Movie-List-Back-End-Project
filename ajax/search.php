<?php
require_once ('../dbConfig.php');
require_once ('../session.php');
if(isset($_POST['key']))
{
    $key = filter_var(trim($_POST['key']),FILTER_SANITIZE_STRING);
    $sql = $conn->prepare("SELECT movieID,mName,mRate,pName,movie.pID FROM photo,movie WHERE photo.pID = movie.pID AND movie.uID =".$_SESSION['id']." AND mName Like '".$key."%' " );
    $sql->execute();
    if($sql->rowCount()>0)
    {
        $results = $sql->fetchAll(PDO::FETCH_OBJ);
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
                            name="deletee" class="btn btn-danger"><i class="fas fa-trash-alt"></i>
                    </button>
                    <button data-bs-toggle="tooltip" data-bs-placement="right" title="Edit" name="edit" class="btn btn-primary "><i class="fas fa-edit"></i>
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
            </tr>

            <?php

        }
    }

}

if(isset($_POST['key2']))
{
    $sql = $conn->prepare(" SELECT CONCAT(firstName, ' ' ,lastName) as Fullname,movieID,mName,mRate,pName FROM movie,photo,d_user
     WHERE d_user.uID = movie.uID AND movie.pID = photo.pID AND mName LIKE '".filter_var(trim($_POST['key2']),FILTER_SANITIZE_STRING)."%' ");
    $sql->execute();
    if($sql->rowCount()>0)
    {
        $responses = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach ($responses as $response)
        {
            ?>


                <div class="card col-md-3 m-2 col-sm-12 bg-gradient bg-dark" style=" height: 450px; width: 220px;">
                    <div class="zoomBOut card-img-top">
                        <a href="movie.php?id=<?php echo $response->movieID?>"><img src="uploaded-imgs/<?php echo $response->pName; ?>" class=" zoomBIn" alt="..."></a>
                    </div>
                    <div class="card-body text-center text-light">
                        <h5 class="card-title"><?php echo $response->mName; ?></h5>
                        <p class="card-text">Rate: <?php echo $response->mRate; ?>/10 <br/> By: <?php echo $response->Fullname; ?></p>
                    </div>
                </div>


<?php
        }
    }
}
$conn = null;
