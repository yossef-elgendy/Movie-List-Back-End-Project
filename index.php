<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>

    <?php
    session_start();
    require_once('layouts/cssLinks.php');
    require_once('dbConfig.php');
    $sql = "SELECT * FROM city";
    $query = $conn->prepare($sql);
    $query->execute();
    ?>
</head>
<body class="bg-primary position-relative">

<?php require_once('layouts/navBar.php'); ?>

<div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title">LOGIN</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="LoginForm" method="post" action="Login.php">
                <div class="modal-body">
                    <div  id="errorL" class=" col col-md-8 mt-2 mb-2" style="display: none">

                    </div>

                    <div class="row mb-3">
                        <div class=" col-md-12">
                            <label for="EmailInput" class="form-label">Email</label>
                            <input name="email" value="<?php echo isset($_COOKIE['email'])?$_COOKIE['email']:''; ?>" type="email" class="form-control" id="EmailInput" >
                            <small class="invalid-feedback" id="EmailInputE"></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="PasswordInput" class="form-label">Password</label>
                            <input name="password" value="<?php echo isset($_COOKIE['pw'])?$_COOKIE['pw']:''; ?>"  type="password" class="form-control" id="PasswordInput" >
                            <small class="invalid-feedback" id="PasswordInputE"></small>
                        </div>


                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-12 ">
                            <input name="rememberMe" class="form-check-input" type="checkbox" value="1" id="remember"
                            <?php echo isset($_COOKIE['email'])&&isset($_COOKIE['pw'])?'checked':''?> >
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a id="noEmail" role="button" class="link-info" >Don't have an account? Register Now !!</a>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button id="signIN" type="button" class="btn btn-primary">Sign In </button>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-fullscreen-lg-down fade" id="RegModal" tabindex="-1" aria-labelledby="RegeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title">REGISTER</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="regForm" method="post" action="#">
                <div class="modal-body">

                    <div class="container-custom">
                        <ul class="progressbar ">
                            <li >Step 1</li>
                            <li >Step 2</li>
                            <li >Step 3</li>
                        </ul>
                    </div>

                    <div class="row g-3">
                        <div class="tab" id="first">
                            <div class="col-md-12">
                                <label for="inputFname" class="form-label">First name</label>
                                <input name="inputFname" type="text" class="form-control " id="inputFname" >
                                <small class="invalid-feedback" id="inputFnameE"></small>
                            </div>
                            <div class="col-md-12">
                                <label for="inputLname" class="form-label">Last name</label>
                                <input name="inputLname" type="text" class="form-control" id="inputLname" >
                                <small class="invalid-feedback" id="inputLnameE"></small>
                            </div>
                        </div>

                        <div class="tab" id="second">
                            <div class="col-12">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input name="inputEmail" type="email" class="form-control" id="inputEmail" >
                                <small class="invalid-feedback" id="inputEmailE"></small>
                            </div>
                            <div class="col-12">
                                <label for="inputPassword" class="form-label">Password</label>
                                <input name="inputPassword" type="password" class="form-control" id="inputPassword" >
                                <small class="invalid-feedback" id="inputPasswordE"></small>
                            </div>
                            <div class="col-12">
                                <label for="inputCPassword" class="form-label"> Confirm Password</label>
                                <input name="inputCPassword" type="password" class="form-control" id="inputCPassword" >
                                <small class="invalid-feedback" id="inputCPasswordE"></small>
                            </div>
                        </div>
                        <div class="tab" id="third">

                            <div  id="errorR" class=" col col-md-8 mt-2 mb-2" style="display: none">

                            </div>

                            <div class="col-md-6">
                                <label for="inputMobile" class="form-label">Mobile</label>
                                <input name="inputMobile" type="text" class="form-control" id="inputMobile" >
                                <small class="invalid-feedback" id="inputMobileE"></small>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputCity" class="form-label">City</label>
                                <select name="inputCity" id="inputCity" class="form-select">
                                    <option value="" selected hidden disabled>Choose...</option>
                                    <?php
                                    $results= $query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach ($results as $result)
                                        {
                                            echo "<option value=".$result->cityID.">".$result->cityName."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <small class="invalid-feedback" id="inputCityE"></small>
                            </div>


                        </div>
                        <div class="row justify-content-center mt-2 p-2">

                            <div class="col col-md-3">
                                <button type="button" id="prev"  class="btn btn-danger">Prev</button>
                            </div>

                            <div class="col col-md-6">
                                <a id="AlreadyHaveEmail" role="button" class="link-info" >Already have an account</a>
                            </div>

                            <div class="col col-md-3 d-flex justify-content-end ">

                                <button type="button"  id="next" class="btn btn-primary">Next</button>
                            </div>


                        </div>
                    </div>

                    <div id="regFooter" class="modal-footer justify-content-center">
                        <div class="row  mt-2">
                            <div class="col col-md-12 mt-2">
                                <button type="button" value="submit"   id="register" class="col col-md-12 Zbtn btn-lg btn-warning">submit</button>
                            </div>
                        </div>
                    </div>



                </div>


            </form>
        </div>
    </div>
</div>

<div class="container-fluid text-white">
    <div class="row justify-content-center">

        <div id="successR" class=" col col-md-8 mt-1 mb-2" style="display: none" >

        </div>

        <div id="successL" class=" col col-md-8 mt-1 mb-2" style="display: none" >
            <?php
                if (isset($_SESSION['wellDone']))
                {
                    ?>
                    <script>
                        $('#successL').show();
                        $('#successL').html('<div style="display: none" class="alert alert-success alert-dismissible fade show" role="alert" >\n' +
                            '                <strong>Success</strong> You are now Logged in successfully\n' +
                            '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                            '            </div>');
                        $('#successL .alert').delay(1000).show('slow');
                    </script>
                    <?php
                    unset($_SESSION['wellDone']);
                }

            if (isset($_SESSION['Logout']))
            {
                ?>
                <script>
                    $('#successL').show();
                    $('#successL').html('<div style="display: none" class="alert alert-success alert-dismissible fade show" role="alert" >\n' +
                        '                <strong>Good Bye!!</strong> and see you next time <3 \n' +
                        '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                        '            </div>');
                    $('#successL .alert').delay(1000).show('slow');
                </script>
                <?php
                unset($_SESSION['Logout']);
            }

            if (isset($_SESSION['LoginPlease']))
            {
                ?>
                <script>
                    $('#successL').show();
                    $('#successL').html('<div style="display: none" class="alert alert-warning alert-dismissible fade show" role="alert" >\n' +
                        '                <strong>You are not logged in.</strong> Login first please.<3 \n' +
                        '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                        '            </div>');
                    $('#successL .alert').delay(1000).show('slow');
                </script>
                <?php
                unset($_SESSION['LoginPlease']);
            }
            ?>
        </div>
    </div>

    <div class="row justify-content-center">


        <div class="col col-md-8 ">
            <div class="card bg-dark text-white " style="width: 100%">
                <img src="images/sample2.jpg" style="width: 100%; height: 200px; object-fit: cover; opacity: 0.30"
                     class="card-img" alt="...">
                <div class="card-img-overlay p-xs-5">
                    <h5 class="card-title display-5 text-uppercase ">Best Collection of DvDs</h5>
                    <p class="card-text">In this website you could make the best list of movies you've ever watched.</p>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center text-center mt-5 mb-2 ">
        <div class="col col-md-7 bg-dark text-light rounded">
            <h3 class="h3 text-uppercase">Here Is Some Of The Movies We Have</h3>
            <small class="text-white text-muted text-lowercase">Join Us And Add your top 10 movies</small>
        </div>
    </div>


    <div class="row justify-content-center mb-3">

        <div class="col col-md-8 ">

            <div id="carouselExampleCaptions" class="carousel slide " data-bs-ride="carousel" data-bs-interval="2000">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/inception.jpg" class="d-block w-100 " height="500px" alt="...">

                    </div>
                    <div class="carousel-item">
                        <img src="images/harryPotter.jpg" class="d-block w-100 " height="500px" alt="...">

                    </div>
                    <div class="carousel-item">
                        <img src="images/Divergent.jpg" class="d-block w-100  " height="500px" alt="...">

                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>

        </div>

    </div>


</div>

<div class="container-fluid position-relative" id="footer">
<?php
include_once('layouts/footer.php');
?>
</div>

<div class="container ">
    <div class="row fixed-top justify-content-center">
        <div id="alerts" class="col col-md-6 ">
            <div id="invalidSearch" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none">
                <strong>You're Not Logged In!</strong> You should login first.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        </div>
    </div>
</div>
<?php
$conn = null ;

require_once('layouts/jsLinks.php');
?>

</body>

</html>