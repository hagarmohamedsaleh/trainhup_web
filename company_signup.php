<?php
function getCompanyLogo($username, $conn) {
    // Create a new connection for this function
    $connLocal = new mysqli("localhost", "root", "", "summer_training");

    // Check connection
    if ($connLocal->connect_error) {
        die("Connection failed: " . $connLocal->connect_error);
    }

    $logoQuery = $connLocal->prepare("SELECT logo FROM company_requirement WHERE username = ?");
    $logoQuery->bind_param("s", $username);
    $logoQuery->execute();
    $logoResult = $logoQuery->get_result();

    if ($logoResult->num_rows > 0) {
        $logoRow = $logoResult->fetch_assoc();
        $logo = $logoRow['logo'];
    } else {
        $logo = null;
    }

    // Close the local connection
    $connLocal->close();

    return $logo;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "summer_training"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = isset($_POST["name"]) ? $_POST["name"] : '';
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirmPassword"];

    function checkPasswordStrength($password) {
        // Check if the password length is at least 8 characters
        if (strlen($password) < 8) {
            return "weak";
        }

        // Check if the password contains uppercase, lowercase, numbers, and special characters
        if (!preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match("#[0-9]+#", $password) || !preg_match("/\W+/", $password)) {
            return "weak";
        }

        return "strong";
    }

    // Perform basic validation
    if ($password !== $confirm_password) {
        echo "<h1 style='padding: 20px;text-align: center;color:#263238;'>Passwords do not match. Please try again.</h1>";
    } else {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<h1 style='padding: 20px;text-align: center;color:#263238;'>Invalid email format. Please enter a valid email address.</h1>";
        } else {
            // Check password strength
            $passwordStrength = checkPasswordStrength($password);

            if ($passwordStrength === "weak") {
                echo "<h1 style='padding: 20px;text-align: center;color:#263238;'>Password is weak. Please use a stronger password </h1>";
                echo "<h1 style='padding: 20px;text-align: center;color:#263238;'>(8 characters long with uppercase, lowercase, numbers, and special characters)</h1>";
            } else {
                // Check if username or email already exists using prepared statements
                $checkExisting = $conn->prepare("SELECT username, email FROM company_signup WHERE username = ? OR email = ?");
                $checkExisting->bind_param("ss", $username, $email);
                $checkExisting->execute();
                $checkExisting->store_result();

                if ($checkExisting->num_rows > 0) {
                    echo "<h1 style='padding: 20px;text-align: center;color:#263238;'>Username or Email already exists. Please choose a different one.</h1>";
                } else {
                    // Hash the password before storing it in the database
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert data into the database using prepared statements
                    $stmt = $conn->prepare("INSERT INTO company_signup (username, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $username, $email, $hashed_password);

                    if ($stmt->execute()) {
                        header("Location: company_requirement.php");
                        exit(); // Add exit after header to prevent further execution
                    } else {
                        echo "<h1 style='padding: 20px;text-align: center;color:#263238;'>Sorry, there was an error processing your request.</h1>";
                    }
                    $stmt->close();
                }
                $checkExisting->close();
            }
        }
    }

    $conn->close();
}
?>












































<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TrainHub</title>
   <link rel="stylesheet" href="all.min.css">

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/req.css">
   <style>
      .password-container {
         position: relative;
      }

      .toggle-password {
         cursor: pointer;
         user-select: none;
         position: absolute;
         right: 10px;
         top: 50%;
         transform: translateY(-50%);
      }
   </style>
</head>
<body>


<!-- ------------------------sign up start--------------------  -->
<section class="signup" id="signup">   
<select name="" id="change_lang"  style="margin-left:6rem";>
      <option value="en" selected data-lang="lang_en">English</option>
      <option value="ar" data-lang="lang_ar">Arabic</option>
   </select>
   <div class="row">
   <div class="image">
    <?php

    

    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "summer_training"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Get the username from the POST request
    $username = isset($_POST["name"]) ? $_POST["name"] : '';

    // Retrieve logo based on username
    $logo = getCompanyLogo($username, $conn);

    // Display the logo if available
    if ($logo !== null) {
        echo '<img src="' . $logo . '" alt="Company Logo">';
    } else {
        //echo '<img src="images/iti.png" alt="">';
    }
    ?>
</div>



      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <h2 data-lang="wel_sign">Welcome</h2>
         <p data-lang="sign_p" style="font-size:15px";>Create a new account on TrainHub</p>
         <input type="text" required placeholder="username" name="name" class="box">
         <input type="email" required placeholder="email" name="email" class="box">
         <div class="password-container">
            <input type="password" required placeholder="password"  name="password" id="password" class="box" >
            <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
         </div>
         <div class="password-container">
            <input type="password" required placeholder="confirm password"  name="confirmPassword" id="confirmPassword" class="box" >
            <span class="toggle-password" onclick="togglePassword('confirmPassword')">👁️</span>
         </div>
         
         <input type="submit" value="sign up" class="btn" name="send" >
         <p data-lang="al_have_acc" style="font-size:15px";>Already have an account? </p><a style="font-size:15px"; href="company_login.php"><span data-lang="login">login Here</span></a> 
      </form>
      
   </div>

</section>
<div class="loader"></div>

<div class="credit">&copy; copyright @ 2023 by <span>TechnoLava Team: Faculty Of Computer Science And Artificial Intelligence</span> | all rights reserved!</div>
<!-- sign up section ends -->
<script>
   function togglePassword(passwordFieldId) {
      const passwordInput = document.getElementById(passwordFieldId);
      passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
   }
</script>
<script>
   window.addEventListener("load",()=>{
      const loader=document.querySelector(".loader");
      loader.classList.add("loader-hidden");
      loader.addEventListener("transitionend",()=>{
         document.body.removeChild(loader);
      });
   });
</script>
<script src="js/main.js"></script>

</body>
</html>
