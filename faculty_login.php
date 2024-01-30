<?php 
include('connection.php');
session_start();
$message = '';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM faculty_login WHERE email = '".$email."' AND password = '".$password."'";
    $result = $conn->query($query);

    if($result->num_rows > 0) {
        $message = "<div class='alert alert-success'>Login Successful..</div>";
    } else {
        $message = "<div class='alert alert-danger'>Login failed..!!</div>";
    }
}
?>

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
    <br><br>
    <div class="container w-50 mt-5">
        <form method="post" class="bg-light p-5 shadow-lg">
            <h2 style="color:#5772a1;text-align:center;" data-lang="back">Welcome back</h2>
            <p style="color:black;text-align:center;" data-lang="enter_login">Enter your email and password to Login</p>
            <label for="Email" data-lang="email">Email</label>
            <input type="text" name="email" placeholder="Email Address" class="form-control form-control-sm" required><br>
            <label for="password" style="position: relative; display: block;">
               <span data-lang="password">Password</span>
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
            <a href="faculty_forget_pass.php" data-lang="forget_pass">Forget Password?</a>
            <br>
            <br>
            <button type="submit" name="submit" class="btn btn-success btn-sm" style="background-color: #5772a1; font-size:15px;margin-left: 12rem; padding: 5px 70px;"  data-lang="login">Login</button>
        </form>
        <br>
        <select name="" id="change_lang" style="margin-left: 17rem;border-color:#5772a1;border-radius: 7px;" >
            <option value="en" selected data-lang="lang_en">English</option>
            <option value="ar" data-lang="lang_ar">Arabic</option>
         </select>
    </div>
    <div style="color:black;text-align:center;margin-top:5rem" class="credit" data-lang="copy_right">&copy; copyright @ 2023 by <span>TechnoLava Team: Faculty Of Computer Science And Artificial Intelligence</span> | all rights reserved!</div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
        }
    </script>
        <script src="js/main.js"></script>

</body>
</html>
