<nav class="navbar navbar-expand-lg navbar-dark text-light bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-muted " href="index.php"><i class="fas fa-compact-disc"></i> DVD STORE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ml-5" id="navbarSupportedContent">
            <ul id="links" class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" aria-current="page" href="index.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <?php
                if(isset($_SESSION['email'])||isset($_SESSION['pw'])||
                isset($_SESSION['lastName'])||isset($_SESSION['firstName'])
                ||isset($_SESSION['id']))
                {

                    ?>

                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="myCollection.php">
                            <i class="fas fa-layer-group"></i> My Collection
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="dvds.php">
                            <i class="fas fa-compact-disc"></i> ALL DVDS
                        </a>
                    </li>

                    <?php

                }
                else
                {
                    ?>

                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" data-bs-toggle="modal" data-bs-target="#LoginModal" role="button">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" data-bs-toggle="modal" data-bs-target="#RegModal" role="button">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>

                    <?php
                }

                ?>

            </ul>

            <div class="d-flex mx-lg-5">
                 <span>

                    <?php
                        if(isset($_SESSION['email'])||isset($_SESSION['pw'])||
                            isset($_SESSION['lastName'])||isset($_SESSION['firstName'])
                            ||isset($_SESSION['id']))
                        {
                            echo '<div class="btn-group">
                          <a type="button" class="btn btn-md p-2 btn-outline-primary text-white rounded dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span><i class="fas fa-user"></i>&nbsp;&nbsp; '.strtoupper($_SESSION['firstName'].' '.$_SESSION['lastName']). '
                          &nbsp;</a>
                          <ul class="dropdown-menu">
                            <li>
                                <li><a class="dropdown-item" href="Logout.php">Logout</a></li>
                               
                            </li>
                          </ul>
                    </div>';

                        }
                    ?>

                 </span>
            </div>
        </div>
    </div>
</nav>