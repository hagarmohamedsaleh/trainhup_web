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

</head>
<body>

   
<!-- ------------------------sign up start--------------------  -->
<section class="req" id="req"> 
<select name="" id="change_lang"  style="margin-left:6rem";>
      <option value="en" selected data-lang="lang_en">English</option>
      <option value="ar" data-lang="lang_ar">Arabic</option>
   </select>
   <br>  
   <div class="row">
      <div class="image">
         <img src="images/req.png" alt="">
      </div>
      <form action="" method="post">
         <h2 data-lang="req">Requirements </h2>
         <p data-lang="req_cont" style="font-size:15px";> please fill out your data carefully </p>
         <input type="text" required placeholder="Company Name" name="username" class="box">
         <input type="number" required placeholder="Tax Number" name="taxnumber" class="box">
         <input type="number" required placeholder="Contact Number"  name="phone_number" class="box" >
         <input type="text" required placeholder="Location"  name="location" class="box" >
         <input type="text" required placeholder="Branches"  name="branch" class="box" >
         
         <input type="submit" value="Finish" class="btn" name="save" >

      </form>
      
   </div>

</section>
<div class="loader"></div>

<div class="credit">&copy; copyright @ 2023 by <span>TechnoLava Team : Faculty Of Computer science And Artificial Intellgence</span> | all rights reserved!</div>
<!-- sign up  section ends -->
<script>
        window.addEventListener("load", () => {
            const loader = document.querySelector(".loader");
            loader.classList.add("loader-hidden");
            loader.addEventListener("transitionend", () => {
                document.body.removeChild(loader);
            });
        });
    </script>

<?php
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

   $companyName = $_POST["username"];
   $taxNumber = $_POST["taxnumber"];
   $phoneNumber = $_POST["phone_number"];
   $location = $_POST["location"];
   $branches = $_POST["branch"];

   // Check if the data already exists in the database
   $checkQuery = $conn->prepare("SELECT * FROM company_requirement WHERE username = ? AND branches = ?");
   $checkQuery->bind_param("ss", $companyName, $branches);
   $checkQuery->execute();
   $checkResult = $checkQuery->get_result();

   if ($checkResult->num_rows > 0) {
      echo "<script>alert('Data already exists!');</script>";
   } else {
      // Insert data into the database using prepared statements
      $insertQuery = $conn->prepare("INSERT INTO company_requirement (username, tax_number, phone, location, branches) VALUES (?, ?, ?, ?, ?)");
      $insertQuery->bind_param("sssss", $companyName, $taxNumber, $phoneNumber, $location, $branches);

      if ($insertQuery->execute()) {
        echo "<script>alert('Data saved successfully!');</script>";
        // Redirect to login page
        header("Location: company_login.php");
        exit(); // Ensure that no further code is executed after the redirect
     } else {
        echo "<script>alert('Error: " . $insertQuery->error . "');</script>";
     }

      $insertQuery->close();
   }

   $checkQuery->close();
   $conn->close();
}
?>
<script src="js/main.js"></script>

</body>

</html>
