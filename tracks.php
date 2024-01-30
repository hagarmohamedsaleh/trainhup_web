
<?php
session_start();
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
                <a href="dashboard.php" >
                    <i class="fas fa-home"></i>
                    <h3 data-lang="home">Home</h3>
                </a>
                <a href="profile.php">
                    <i class="fas fa-user"></i>
                    <h3 data-lang="profile">profile</h3>
                </a>
                <a href="tracks.php" class="active">
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
        <h1 data-lang="tracks">
            tracks
        </h1>

    <!-- Table for displaying tracks -->
    <div class="recent">
    <table class="table2">
                <thead>
                    <tr>
                        <th data-lang="trackname">track name</th>
                        <th data-lang="description">description</th>
                        <th data-lang="content">content</th>
                        <th data-lang="hours">hours</th>
                        
                        
                        <td></td>
                    </tr>
                    
                </thead>
            <tbody>
            <?php
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

// Handle track deletion
if (isset($_GET['delete_track'])) {
    $trackIdToDelete = $_GET['delete_track'];

    // Perform deletion
    $deleteQuery = "DELETE FROM add_track WHERE track_name = ?";
    $deleteStmt = $conn->prepare($deleteQuery);

    if (!$deleteStmt) {
        die("Error in delete query: " . $conn->error);
    }

    $deleteStmt->bind_param("s", $trackIdToDelete);
    $deleteStmt->execute();

    // Check if deletion was successful
    if ($deleteStmt->affected_rows > 0) {
        echo ' <div id="message-container" class="hidden">
        <div id="message">This is your message!</div>
    </div>';


    } else {
       // echo '<p>Error deleting track: ' . $deleteStmt->error . '</p>';
    }

    // Close the delete statement
    $deleteStmt->close();
}

// Fetch data from the "add_track" table
$sql = "SELECT track_name,description,content,hours FROM add_track";
$result = $conn->query($sql);

if ($result) {
    // Output data in table rows
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['track_name'] . '</td>';
        echo '<td>' . $row['description'] . '</td>';
        echo '<td>' . $row['content'] . '</td>';
        echo '<td>' . $row['hours'] . '</td>';
        echo '<td><a href="editTrack.php" class="active"><i class="fas fa-edit"></i></a></td>';
        echo '<td>
                <a href="?delete_track=' . $row['track_name'] . '">
                <i class="fa fa-trash danger" style="font: size 19px;px;"></i>
                </a>
            </td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No records found.</td></tr>';
}

// Close the connection
$conn->close();
?>


            </tbody>
        </table>
    </div>
</main>

<!-- ------------------------------End main------------------------------------ -->

   

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



    <script src="script/main1.js"></script>
</body>
</html>







































































 