<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header text-muted">
            <a class="pull-left" href="search_diseases.php">
              <h1>MyAssessment<small><sup>&trade;</sup></small></h1>
            </a>
        </div>

        <ul class="nav navbar-nav navbar-right user_display link">
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Welcome, <?php echo $_SESSION["username"];?>&nbsp;<span class="caret"></span></a>
                <div class="dropdown-menu">
                    <ul class="dropdown-menu-right" id="user_dropdown">
                        <li><a href="#">My Profile</a></li>
                        <?php 
                                if( isset( $_SESSION["admin"]) ){
                                    if($_SESSION["admin"] == 1 ) {
                                        include("includes/admin_li.php");
                                    }
                                }
                        ?>
                        <li><a href="" id="logout">Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>