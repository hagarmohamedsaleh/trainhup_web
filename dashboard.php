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
                <a href="dashboard.php" class="active">
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
               
                <a href="help.html">
                    <i class="fas fa-circle-info"></i>
                    <h3 data-lang="help">help</h3>
                </a>
                <a href="settings.php" >
                    <i class="fas fa-gear"></i>
                    <h3 data-lang="settings">settings</h3>
                </a>
                <a href="#">
                    <i class="fas fa-right-from-bracket"></i>
                    <h3 data-lang="logout">log out</h3>
                </a>
              
            </div>
        </aside>
        <!-- ----------------------------End aside -------------------------------------- -->
    <main>
        <h1 data-lang="home">
            Home
        </h1>
        
         
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

// Function to fetch count from the requests table based on the given column and value
function getCount($column, $value = null, $distinct = false) {
    global $conn;
    $countQuery = "SELECT ";
    
    if ($distinct) {
        $countQuery .= "COUNT(DISTINCT $column)";
    } else {
        $countQuery .= "COUNT($column)";
    }

    $countQuery .= " as count FROM requests";

    if ($value !== null) {
        $countQuery .= " WHERE $column = ?";
    }

    $countStmt = $conn->prepare($countQuery);

    if ($value !== null) {
        $countStmt->bind_param("s", $value);
    }

    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $countRow = $countResult->fetch_assoc();
    return $countRow['count'];
}

// Fetch counts for each required column
$acceptedCount = getCount('status', 'accepted');
$distinctTracksCount = getCount('track_name', null, true); // Set $distinct parameter to true
$totalRequestsCount = getCount('status');

// Output your HTML structure here
echo '<div class="insights">';
echo '<div class="courses">';
echo '<span>  <i class="fas fa-code"></i></span>';
echo '<div class="middle">';
echo '<div class="lef">';
echo '<h3 data-lang="participator">participator</h3>';
echo '</div>';
echo '<div class="progress">';
echo '<svg>';
echo '<circle cx="38" cy="38" r="36"></circle>';
echo '</svg>';
echo '<div class="number">';
echo '<h1>' . $acceptedCount . '</h1>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<small class="text-muted"  data-lang="lastHour">last 24 hours</small>';
echo '</div>';

echo '<div class="company">';
echo '<span>  <i class="fas fa-building"></i></span>';
echo '<div class="middle">';
echo '<div class="lef">';
echo '<h3 data-lang="tracks">tracks</h3>';
echo '<h4 data-lang="active"class="text-muted">active</h4>';
echo '</div>';
echo '<div class="progress">';
echo '<svg>';
echo '<circle cx="38" cy="38" r="36"></circle>';
echo '</svg>';
echo '<div class="number">';
echo '<h1>' . $distinctTracksCount . '</h1>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<small class="text-muted" data-lang="lastHour">last 24 hours</small>';
echo '</div>';

echo '<div class="requests">';
echo '<span>  <i class="fas fa-chart-simple"></i></span>';
echo '<div class="middle">';
echo '<div class="lef">';
echo '<h3  data-lang="totalrequest">total request</h3>';
echo '</div>';
echo '<div class="progress">';
echo '<svg>';
echo '<circle cx="38" cy="38" r="36"></circle>';
echo '</svg>';
echo '<div class="number">';
echo '<h1>' . $totalRequestsCount . '</h1>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<small class="text-muted" data-lang="lastHour">last 24 hours</small>';
echo '</div>';

// Close the database connection
$conn->close();
?>


</div>
        <!-- --------------------End section1-------------------------------- -->
        
        <div class="recent">
            <h2 data-lang="tracks">tracks</h2>
            <table class="table1">
                <thead>
            <tr>
                <th data-lang="trackname">track name</th>
                <th data-lang="description">description</th>
                <th data-lang="content">content</th>
                <th data-lang="hours">hours</th>
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

            // Fetch only the first 5 records from the "add_track" table
            $sql = "SELECT * FROM add_track LIMIT 6";
            $result = $conn->query($sql);

            // Check for errors in the query execution
            if ($result === false) {
                echo "Error in SQL query: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    // Output data in table rows
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['track_name'] . '</td>';
                        echo '<td>' . $row['description'] . '</td>';
                        echo '<td>' . $row['content'] . '</td>';
                        echo '<td>' . $row['hours'] . '</td>';
                        // echo '<td><a href="editTrack.html" class="active"><i class="fas fa-edit"></i></a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No records found.</td></tr>';
                }
            }

            // Close the connection
            $conn->close();
            ?>
           
           </tbody>
            </table>
            <a href="tracks.php" data-lang="show">show all</a>
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
                <p data-lang="hey" >hey, <b> ITI </b></p>
                <small class="text-muted" data-lang="company">company</small>
            </div>
            <div class="profile-photo">
                <img src="images/iti.PNG" alt="">
            </div>
        </div>
    </div>
    
    <!-- ----------------End Updates---------------------------------- -->

    <div class="tracks">
        <h2 data-lang="tracks">Tracks</h2>

        <?php
        // Connect to the database
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'summer_training';
        $conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the database
        $sql = "SELECT * FROM add_track";
        $result = $conn->query($sql);

        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="item online">';
                echo '<div class="icon">';
                echo '<span><i class="fas fa-code"></i></span>';
                echo '</div>';
                echo '<div class="right">';
                echo '<div class="info">';
                echo '<h3>' . $row['track_name'] . '</h3>';
                echo '</div>';
                echo '<h5 class="primary">' . $row['hours'] . ' hr</h5>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }

        // Close the database connection
        $conn->close();
        ?>

        <!-- Add Track Button -->
        <a href="addtrack.php">
        <div class="item add-report">
     
            <div>
                <span>
                    <i class="fas fa-plus"></i>
                </span>
               <h3 data-lang="addtrack">Add track</h3>
            </div>
            
        </div>
        </a>
    </div>
</div>



    
    </div>
    
    




    <script src="script/main1.js"></script>
</body>
</html>