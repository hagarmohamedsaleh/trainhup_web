
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summer_training";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the count from the 'requests' table
$sql = "SELECT COUNT(*) AS total FROM requests";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCount = $row['total'];
} else {
    $totalCount = 0;
}

$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>TrainHub</title>
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="images/logo.jpg" alt="">
                    <h2>Train <span class="primary">Hub</span></h2>
                </div>
                <div class="close" id="close-btn">
                   <span> <i class="fas fa-close"></i></span>
                </div>
            </div>
            <div class="sidebar">
                <a href="dashboard.php">
                    <i class="fas fa-home"></i>
                    <h3 data-lang="home">Home</h3>
                </a>
                <a href="profile.php">
                    <i class="fas fa-user"></i>
                    <h3 data-lang="profile">profile</h3>
                </a>
                <a href="tracks.php">
                    <i class="fas fa-table-cells-large"></i>
                    <h3 data-lang="tracks">tracks</h3>
                </a>
                <a href="addtrack.php"  >
                    <i class="fas fa-upload"></i>
                    <h3 data-lang="addtrack">add track</h3>
                </a>
                <a href="editTrack.php">
                    <i class="fas fa-edit"></i>
                    <h3 data-lang="edittracks">edit tracks</h3>
                </a>
                <a href="requests.php">
                    <i class="fas fa-message"></i>
                    <h3 data-lang="requests">requests </h3>
                    <span class="count"><?php echo $totalCount; ?></span>
                </a>

                <a href="evaluation.php">
                    <i class="fas fa-check"></i>
                    <h3 data-lang="evaluation">requests </h3>
                  
                </a>
               
                <a href="help.php">
                    <i class="fas fa-circle-info"></i>
                    <h3 data-lang="help">help</h3>
                </a>
                <a href="settings.php"  class="active">
                    <i class="fas fa-gear"></i>
                    <h3 data-lang="settings">settings</h3>
                </a>
                <a href="start.html">
                    <i class="fas fa-right-from-bracket"></i>
                    <h3 data-lang="logout">log out</h3>
                </a>
              
            </div>
        </aside>
        <!-- ----------------------------End aside -------------------------------------- -->

































        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    

    <?php
// Assuming you have a database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'summer_training';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for validation messages
$emailError = $oldPasswordError = $newPasswordError = $confirmPasswordError = $updateMessage = '';

// Handle form submission
if (isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form data
    if (empty($email)) {
        $emailError = 'Email is required';
    }

    if (empty($oldPassword)) {
        $oldPasswordError = 'Old Password is required';
    }

    if (empty($newPassword)) {
        $newPasswordError = 'New Password is required';
    }

    if (empty($confirmPassword)) {
        $confirmPasswordError = 'Confirm Password is required';
    } elseif ($newPassword !== $confirmPassword) {
        $confirmPasswordError = 'New Password and Confirm Password do not match';
    }

    // If there are no validation errors, proceed with password update
    if (empty($emailError) && empty($oldPasswordError) && empty($newPasswordError) && empty($confirmPasswordError)) {
        // Check if old password matches the one in the database for the specified email
        $checkPasswordQuery = "SELECT * FROM company_signup WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($checkPasswordQuery);
        $stmt->bind_param("ss", $email, $oldPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Old password matches, update the password
            $updatePasswordQuery = "UPDATE company_signup SET password = ? WHERE email = ?";
            $updateStmt = $conn->prepare($updatePasswordQuery);
            $updateStmt->bind_param("ss", $newPassword, $email);
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                $updateMessage = 'Password updated successfully!';
            } else {
                $updateMessage = 'Error updating password.';
            }
        } else {
            $updateMessage = 'Incorrect old password or email not found.';
        }

        // Close the statements
        $stmt->close();
        // $updateStmt->close();
    }
}

// Close the database connection
$conn->close();
?>




<main>
        <h1 data-lang="changePassword">Change your password</h1>
        <br><br>
        <div class="edit-profile-page">
            <form action="" method="post" class="edit-profile">
                <div class="edit-profile-content">
                    <label for="email" data-lang="email">Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <span class="error"><?php echo $emailError; ?></span>
                </div>
                <div class="edit-profile-content">
                    <label for="old_password" data-lang="old_pass">Old Password</label>
                    <input type="password" name="old_password" placeholder="Enter old password" required>
                    <span class="error"><?php echo $oldPasswordError; ?></span>
                </div>
                <div class="edit-profile-content">
                    <label for="new_password" data-lang="new_pass">New Password</label>
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                    <span class="error"><?php echo $newPasswordError; ?></span>
                </div>
                <div class="edit-profile-content">
                    <label for="confirm_password" data-lang="confirm_pass">Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Enter new password again" required>
                    <span class="error"><?php echo $confirmPasswordError; ?></span>
                </div>
                <button type="submit" name="update_password" data-lang="update">Update</button>

            </form>
            <p class="update-message"><?php echo $updateMessage; ?></p>
        </div>
        <br>
    </main>





<!--  -->
    <!--  -->
    <div class="right">
        <div class="top">
            <button id="menu-btn">
                <span><i class="fas fa-bars"></i></span>
            </button>
            <select name="" id="change-language" hidden>
                <option value="en" selected data-lang="lang_en">English</option>
                <option value="ar" data-lang="lang_ar">Arabic</option>
            </select>
            <div hidden>
                <div class="theme-toggler">
                    <span class="active"><i class="fas fa-sun"></i></span>
                    <span><i class="fas fa-moon"></i></span>
                </div>
               </div>

            <div class="profile">
                <div class="info">
                    <p data-lang="hey">hey, <b> ITI </b></p>
                    <small class="text-muted" data-lang="company">company</small>
                </div>
                <div class="profile-photo">
                    <img src="images/iti.PNG" alt="">
                </div>
            </div>
        </div>


    </div>


</div>

</div>

<script src="script/main1.js"></script>
</body>
</html>