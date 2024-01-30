<?php
include('connection.php');
session_start();
$message = $link = '';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    
    // Use a prepared statement to prevent SQL injection
    $query = "SELECT * FROM faculty_login WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if(isset($row['id'])){
                $id = $row['id'];
                $id_encode = base64_encode($id);
                $message = "<div class='alert alert-success'>Your Email Is Correct ,Please Contact Us to Change Your Password!</div>";
                $link = "<a href='https://wa.me/+0201123538948?MnoQtyPXZORTE=$id_encode' class='btn btn-info btn-sm'>Contact Us</a>";
            } else {
                $message = "<div class='alert alert-danger'>Invalid Email..!!</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger'>Invalid Email..!!</div>";
    }

    // Close the prepared statement
    $stmt->close();
}
?>
<!DOCTYPE html>  
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>forget Password</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body  class="bg-secondary">
    <br><br><br><br>
		<div class="container w-50 mt-5">
			<form class="bg-light p-5 shadow-lg" method="post">
				<?php echo $message; ?>
				<h1  style="color:#5772a1;text-align:center;" data-lang="for_pass">Forgot Password</h1>
                <p style="color:#062b6b;text-align:center;" data-lang="enter_email">Enter your email address</p>

                <input type="email" name="email" placeholder="Email Address" class="form-control form-control-sm" required><br>
				<button type="submit" name="submit"  style="background-color: #5772a1; font-size:15px;margin-left: 9.5rem; padding: 5px 70px;color:white" data-lang="reset_pass">Reset Password</button>
				<?php echo $link; ?>
			</form>
            <br>
            <select name="" id="change_lang" style="margin-left: 17rem;border-color:#5772a1;border-radius: 7px;" >
            <option value="en" selected data-lang="lang_en">English</option>
            <option value="ar" data-lang="lang_ar">Arabic</option>
         </select>
		</div>
        <div style="color:black;text-align:center;margin-top:12rem" class="credit">&copy; copyright @ 2023 by <span>TechnoLava Team: Faculty Of Computer Science And Artificial Intelligence</span> | all rights reserved!</div>
        <script src="js/main.js"></script>

</body>
</html>
