<?php 
include('connection.php');
session_start();
$id = $_GET['MnoQtyPXZORTE'];
$message = $Home = '';
$_SESSION['user'] = $id;
if ($_SESSION['user'] == '') {
    header("location:forget_pass.php");
}
else {
    if(isset($_POST['submit'])) {
        $password = $_POST['password'];
        $Repassword = $_POST['Repassword'];

        if ($password !== $Repassword) {
            $message = "<div class='alert alert-danger'>Password Not Match..!!</div>";
        }
        else {
            $id_decode = base64_decode($id);
            $query = "UPDATE company_signup SET password = '$password' WHERE username = '$id_decode' ";
            $result = $conn->query($query);

            if($result) {
                $message = "<div class='alert alert-success'>Reset Your Password Successfully..</div>";
                $Home = "<a href='company_login.php' class='btn btn-success btn-sm'>Login</a>";
            } else {
                $message = "<div class='alert alert-danger'>Failed to Reset Password..!!</div>";
            }
        }
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
    <br><br><br>
    <div class="container w-50 mt-5">
        <form class="bg-light p-5 shadow-lg" method="post">
            <?php echo $message; ?>
            <h1 style="color:#5772a1;text-align:center;" data-lang="new_pass">New Password</h1>
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
                <input type="password" name="Repassword" id="Repassword" placeholder="confirm Password" class="form-control form-control-sm" required>
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
        <script src="js/main.js"></script>

    </div>
    <div style="color:black;text-align:center;margin-top:10.5rem" class="credit">&copy; copyright @ 2023 by <span>TechnoLava Team: Faculty Of Computer Science And Artificial Intelligence</span> | all rights reserved!</div>


    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
        }
    </script>
</body>
</html>
