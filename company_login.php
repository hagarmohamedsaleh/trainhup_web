
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summer_training";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$message = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT email,password FROM company_signup WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store user information in session
        $_SESSION['email'] = $email;

        // Redirect to the dashboard page
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Login failed..!!</div>";
    }

    $stmt->close();
}
?>











<!--  -->


















<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forget Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-secondary">
    <br>
    <div class="container w-50 mt-5">
        <form method="post" action="" class="bg-light p-5 shadow-lg">
            <?php echo $message; ?>
            <h2 style="color:#5772a1;text-align:center;" data-lang="back">Welcome back</h2>
            <p style="color:black;text-align:center;" data-lang="enter_login">Enter your email and password to Login</p>
            <label for="Email" data-lang="email">Email</label>
            <input type="text" name="email" placeholder="Email Address" class="form-control form-control-sm" required><br>
            <label for="password" style="position: relative; display: block;">
                <span data-lang="password">   Password</span>
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control form-control-sm" required>
                    <div class="input-group-append">
                        <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
            </label>
            <br> 
            <a href="company_forget_pass.php" style="color:#5772a1 ; " data-lang="forget_pass">Forget Password?</a>
            <br>
            <br>
            <button type="submit" name="submit" class="btn btn-success btn-sm" style="background-color: #5772a1; font-size:15px;margin-left: 12rem; padding: 5px 70px;" data-lang="login">Login</button>
        </form>
        <select name="" id="change_lang" style="margin-left: 17rem;border-color:#5772a1;border-radius: 7px;">
            <option value="en" selected data-lang="lang_en">English</option>
            <option value="ar" data-lang="lang_ar">Arabic</option>
         </select>
    </div>
    <div style="color:black;text-align:center;margin-top:2.2rem" class="credit" data-lang="copy_right">copyright @ 2023 by TechnoLava Team: Faculty Of Computer Science And Artificial Intelligence | all rights reserved!</div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
        }
    </script>
    <script src="js/main.js"></script>
</body>
</html>
