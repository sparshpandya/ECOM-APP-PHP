<?php
// Including the database connection
include('db_conn.php');
include('./class/LoginClass.php');

// Start the user session
session_start();
$userInfo = $_SESSION['userInfo'] ?? null;
if ($userInfo) {
    header("Location: index.php");
    exit();
}

$msg = '';
$msg_success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnLogin'])) {
    $login = new LoginClass($conn);
    $login->setData($_POST['email'], $_POST['password']);
    
    // Extracting username from the email
    $userEmail = substr($_POST['email'], 0, strpos($_POST['email'], "@"));

    $validationResult = $login->validate();
    if ($validationResult === true) {
        $loginResult = $login->login();
        if ($loginResult === "Login successful, welcome!") {
            $_SESSION['userInfo'] = $userEmail;
            if ($_SESSION['userInfo'] === "admin") {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $msg = $loginResult;
        }
    } else {
        $msg = $validationResult;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Awesome SmartShop</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Login</h3>
                        <div class="mt-3">
                            <?php if ($msg) echo "<p class='text-center text-danger'>{$msg}</p>"; ?>
                            <?php if ($msg_success) echo "<p class='text-center text-success'>{$msg_success}</p>"; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="email">Email ID</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>" class="form-control" autocomplete="off" id="email" placeholder="Enter Email ID" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Enter Password</label>
                                <input type="password" minlength="8" name="password" value="<?php echo htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES); ?>" class="form-control" autocomplete="off" id="password" placeholder="Enter Password" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-danger">Cancel</button>
                                <button type="submit" name="btnLogin" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
