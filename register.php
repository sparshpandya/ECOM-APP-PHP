<?php
// including the db conn
include('db_conn.php');
include('./class/UserInformation.php');

session_start();
$userInfo = $_SESSION['userInfo'] ?? null;
if($userInfo) {
    header("Location: index.php");
};

$msg = '';
$msg_success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnRegister'])) {
    $user = new UserInformation($conn);
    $user->setData(
        $_POST['firstName'],
        $_POST['lastName'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['address'],
        $_POST['password'],
        $_POST['confirmPassword'],
        $_POST['country'],
        $_POST['state']
    );

    $validationResult = $user->validate();
    if ($validationResult === true) {
        $msg_success = $user->register();
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
    <title>User Registration</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('navbar.php') ?>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>User Registration</h3>
                        <div class="mt-3">
                            <?php if ($msg) echo "<p class='text-center text-danger'>{$msg}</p>"; ?>
                            <?php if ($msg_success) echo "<p class='text-center text-success'>{$msg_success}</p>"; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <form name="register-user" method="POST">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" name="firstName" value="<?php echo htmlspecialchars($_POST['firstName'] ?? '', ENT_QUOTES); ?>" class="form-control" id="firstName" placeholder="Enter First Name">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" name="lastName" value="<?php echo htmlspecialchars($_POST['lastName'] ?? '', ENT_QUOTES); ?>" class="form-control" id="lastName" placeholder="Enter Last Name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email ID</label>
                                <input type="text" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>" class="form-control" id="email" placeholder="Enter Email ID">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES); ?>" class="form-control" id="phone" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="address">Billing Address</label>
                                <input type="text" name="address" value="<?php echo htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES); ?>" class="form-control" id="address" placeholder="Enter Billing Address">
                            </div>
                            <div class="form-group">
                                <label for="password">Enter Password</label>
                                <input type="password" minlength="8" name="password" value="<?php echo htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES); ?>" class="form-control" id="password" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" value="<?php echo htmlspecialchars($_POST['confirmPassword'] ?? '', ENT_QUOTES); ?>" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select name="country" class="form-control" id="country" onchange="updateStateOptions()">
                                    <option value="">Select Country</option>
                                    <option value="1" <?php if (isset($_POST['country']) && $_POST['country'] == '1') echo 'selected'; ?>>US</option>
                                    <option value="2" <?php if (isset($_POST['country']) && $_POST['country'] == '2') echo 'selected'; ?>>Canada</option>
                                    <option value="3" <?php if (isset($_POST['country']) && $_POST['country'] == '3') echo 'selected'; ?>>India</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="state">State</label>
                                <select name="state" class="form-control" id="state">
                                    <option value="">Select State</option>
                                    
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-danger">Cancel</button>
                                <button type="submit" name="btnRegister" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                        <div class="card-body text-center">
                            <p><a class="link-opacity-75-hover" href="login.php">Already have an account? Please login!</a></p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateStateOptions() {
    var countrySelect = document.getElementById('country');
    var stateSelect = document.getElementById('state');
    var selectedState = "<?php echo isset($_POST['state']) ? $_POST['state'] : ''; ?>"; // Get previously selected state
    stateSelect.innerHTML = ''; // Clear existing options

    var states = [];
    if (countrySelect.value == '1') {
        states = [
            { id: 1, name: 'California' },
            { id: 2, name: 'New York' },
            { id: 3, name: 'Texas' },
            { id: 4, name: 'Florida' }
        ];
    } else if (countrySelect.value == '2') {
        states = [
            { id: 5, name: 'Ontario' },
            { id: 6, name: 'Quebec' },
            { id: 7, name: 'British Columbia' },
            { id: 8, name: 'Alberta' }
        ];
    } else if (countrySelect.value == '3') {
        states = [
            { id: 9, name: 'Maharashtra' },
            { id: 10, name: 'Gujarat' },
            { id: 11, name: 'Rajasthan' },
            { id: 12, name: 'Delhi' }
        ];
    }

    // Add the new options
    for (var i = 0; i < states.length; i++) {
        var opt = document.createElement('option');
        opt.value = states[i].id;
        opt.innerHTML = states[i].name;
        if (states[i].id == selectedState) {
            opt.selected = true; // Preserve selected state
        }
        stateSelect.appendChild(opt);
    }
}

// Trigger state update on page load if country is already selected
if (document.getElementById('country').value) {
    updateStateOptions();
}

    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
