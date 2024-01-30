

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
    <link rel="stylesheet" href="csss/stylee.css">
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
                <a href="dashboard.php" >
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
                <a href="editTrack.php"class="active">
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
                <a href="settings.php" >
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
    
    <main>
        <h1 data-lang="edittracks">
            edit tracks
        </h1>

        <section class="form1" id="edit">   
            <div class="row">
               <form action="" method="post" enctype="multipart/form-data">
                  
                  <input type="text" required placeholder="track name" name="track name" class="box">
                  <input type="text" required placeholder="description" name="description" class="box">
                  <input type="number" required placeholder="hours"  name="hours" class="box" >
                  <label for="" data-lang="edittracklogo">Edit track logo</label>
                  <input type="file" required placeholder="track logo"  name="track logo" class="box" >
                  <input type="text" required placeholder="content" name="content" class="box">
                  <input type="submit" value="save" class="btn" name="send">
                 
               </form>
<!------------------------------------ php code ------------------------------>





<?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'summer_training';

        // Create a connection
        $conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Process form data
        $name = $_POST['track_name'];
        $description = $_POST['description'];
        $hours = $_POST['hours'];
        $content = $_POST['content'];

        // Process image upload
        if (isset($_FILES["track_logo"]) && $_FILES["track_logo"]["error"] == 0) {
            $targetDir = "images/";
            $targetFile = $targetDir . basename($_FILES["track_logo"]["name"]);

            if (move_uploaded_file($_FILES["track_logo"]["tmp_name"], $targetFile)) {
                $logo = $targetFile;
            } else {
                echo "Error uploading logo.";
                // You may want to handle the error gracefully or exit the script here
            }
        } else {
            // If no new logo is provided, retain the existing logo path in the database
            $logo = ''; // Adjust this based on your database schema
        }

        // Update data in the "add_track" table using prepared statement to prevent SQL injection
        // Use placeholders in the prepared statement
        $sql = $conn->prepare("UPDATE add_track SET description=?, hours=?, track_logo=?, content=? WHERE track_name=?");
        $sql->bind_param("sssss", $description, $hours, $logo, $content, $name);

        if ($sql->execute()) {
            echo "Track information updated successfully";
        } else {
            echo "Error updating track information: " . $sql->error;
        }

        // Close the prepared statement
        $sql->close();

        // Close the connection
        $conn->close();
    }
    ?>






<!-------------------- end php code--------------------- -->



               
            </div>
         
         </section>
        
        
 
    </main>

    <!------------------------------------------------------------  -->
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