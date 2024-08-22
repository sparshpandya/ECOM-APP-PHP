<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Awesome SmartShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <?php
                $loggedIn = trim($_SESSION['userInfo'] ?? null);

                if($loggedIn && $loggedIn !== "admin") {
                   echo "<li class='nav-item'>
                <a class='nav-link' href='index.php'>Home</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='products.php'>Our Watches</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='values.php'>Our Values</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='logout.php'>Logout</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='cart.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cart mb-1' viewBox='0 0 16 16'>
                  <path d='M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2'/>
                </svg></a>
            </li>";
                } else if($loggedIn && $loggedIn === "admin") {
                    echo "
                    <li class='nav-item'>
                <a class='nav-link' href='admin.php'>Admin Access</a>
            </li>
                    <li class='nav-item'>
                <a class='nav-link' href='index.php'>Home</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='products.php'>Our Watches</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='values.php'>Our Values</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='logout.php'>Logout</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='cart.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cart mb-1' viewBox='0 0 16 16'>
                  <path d='M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2'/>
                </svg></a>
            </li>";
                }else{
                    echo "<li class='nav-item'>
                <a class='nav-link' href='register.php'>Register</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='login.php'>Login</a>
            </li>
            
            ";
                }
            ?>
        </ul>
    </div>
</nav>
