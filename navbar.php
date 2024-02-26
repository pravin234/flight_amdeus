    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="#">Streamlining Flight Booking</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto" style="float:right;">
                <li class="nav-item active">
                    <a class="nav-link text-light" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="booking.php">Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="profile.php">Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Details
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        if (isset($_SESSION['email'])) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $_SESSION['email'] . '</a>';
                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                            echo '<a class="dropdown-item" href="profile.php">Profile</a>';
                            echo '<div class="dropdown-divider"></div>';
                            echo '<a class="dropdown-item" href="logout.php">Logout</a>';
                            echo '</div>';
                        } else {
                            echo '<a class="btn btn-outline-success" href="#">Login</a>';
                        }
                        ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>