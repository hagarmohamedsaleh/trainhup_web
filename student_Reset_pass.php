<?php 
include('connection.php');
session_start();
$id = $_GET['MnoQtyPXZORTE'];
$message = $Home = '';
$_SESSION['user'] = $id;
if ($_SESSION['user'] == '') {
    header("location:student_Reset_pass.php");
}
else {
    if(isset($_POST['submit'])) {
        $password = $_POST['password'];
        $Repassword = $_POST['Repassword'];

        // Check if the password is strong
        if (!isStrongPassword($password)) {
            $message = "<div class='alert alert-danger'>Password is not strong enough. Please use a stronger password.</div>";
        }
        else if ($password !== $Repassword) {
            $message = "<div class='alert alert-danger'>Password Not Match..!!</div>";
        }
        else {
            $id_decode = base64_decode($id);
            $query = "UPDATE student SET password = '$password' WHERE id = '$id_decode' ";
            $result = $conn->query($query);

            if($result) {
                $message = "<div class='alert alert-success'>Reset Your Password Successfully..</div>";
                $Home = "<a href='student_login.php' class='btn btn-success btn-sm'>Login</a>";
            } else {
                $message = "<div class='alert alert-danger'>Failed to Reset Password..!!</div>";
            }
        }
    }
}

function isStrongPassword($password) {
    // Add your criteria for a strong password (e.g., minimum length, uppercase, lowercase, numbers, symbols)
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $symbol    = preg_match('@[^\w]@', $password);

    return $uppercase && $lowercase && $number && $symbol && strlen($password) >= 8;
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
    <link rel="stylesheet" href="c1.css">
</head>
<body class="bg-secondary">
    <br><br><br>
    <div class="container w-50 mt-5">
        <form class="bg-light p-5 shadow-lg" method="post">
            <?php echo $message; ?>
            <h1 style="color:#5772a1;text-align:center;"data-lang="new_pass">New Password</h1>
            <br>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-sm" required>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
            <br>
            
            <div class="input-group">
                <input type="password" name="Repassword" id="Repassword" placeholder="Confirm Password" class="form-control form-control-sm" required>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password" onclick="togglePassword('Repassword')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-success btn-sm" style="border-color:#5772a1;background-color: #5772a1; font-size:15px;margin-left: 9.5rem; padding: 5px 70px;color:white"data-lang="reset_pass">Reset Password</button> <?php echo $Home; ?>
        </form>
        <br>
        <select name="" id="change_lang" style="margin-left:18rem"; >
                <option value="en" selected data-lang="lang_en">English</option>
                <option value="ar" data-lang="lang_ar">Arabic</option>
             </select>
    </div>
    <div style="color:black;text-align:center;margin-top:10rem" class="credit">&copy; copyright @ 2023 by <span>TechnoLava Team: Faculty Of Computer Science And Artificial Intelligence</span> | all rights reserved!</div>
    <script src="js/main.js"></script>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
        }
    </script>
</body>
</html>
