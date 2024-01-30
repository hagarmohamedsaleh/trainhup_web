
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
                <a href="dashboard.php">
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
                <a href="requests.php" class="active">
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
        <h1 data-lang="requests">requests</h1>

    <div class="content">
        <form action="" method="post" class="request_form">
            <div class="form-request-info">
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

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Check if form is submitted and if 'scales' is an array
                    if (isset($_POST['scales']) && is_array($_POST['scales'])) {
                        // Prepare statement to insert data into the "requests" table
                        $insertQuery = "INSERT INTO requests (track_name, student_name, status, gpa, department, level) VALUES (?, ?, ?, ?, ?, ?)";
                        $insertStmt = $conn->prepare($insertQuery);
                
                        if ($insertStmt === false) {
                            die("Error preparing statement: " . $conn->error);
                        }
                
                        // Fetch all student names from the database for the selected checkboxes
                        $selectedStudentNames = $_POST['scales'];
                
                        // Fetch all student names from the database for all checkboxes
                        $allStudentNamesQuery = "SELECT st_name FROM courses";
                        $allStudentNamesResult = $conn->query($allStudentNamesQuery);
                        $allStudentNames = [];
                        while ($row = $allStudentNamesResult->fetch_assoc()) {
                            $allStudentNames[] = $row['st_name'];
                        }
                
                        // Loop through all student names
                        foreach ($allStudentNames as $studentName) {
                            // Retrieve additional data from the database for the current student
                            $selectQuery = "SELECT course, gpa, department, level FROM courses WHERE st_name = ?";
                            $selectStmt = $conn->prepare($selectQuery);
                
                            if ($selectStmt === false) {
                                die("Error preparing statement: " . $conn->error);
                            }
                
                            $selectStmt->bind_param("s", $studentName);
                            $selectStmt->execute();
                            $selectResult = $selectStmt->get_result();
                            $selectRow = $selectResult->fetch_assoc();
                
                            // Check if the checkbox is checked and set the status accordingly
                            $status = in_array($studentName, $selectedStudentNames) ? 'accepted' : 'rejected';
                
                            // Bind parameters for the insert statement
                            $insertStmt->bind_param("ssssss", $selectRow['course'], $studentName, $status, $selectRow['gpa'], $selectRow['department'], $selectRow['level']);
                
                            $insertStmt->execute();
                        }
                
                        // Close the prepared statement
                        $insertStmt->close();
                    }
                }
                
                

                // Fetch unique values of "course" from the database
                $courseQuery = "SELECT DISTINCT course FROM courses";
                $courseResult = $conn->query($courseQuery);

                if ($courseResult === false) {
                    die("Error executing query: " . $conn->error);
                }

                // Store the unique courses in an array
                $tracks = array();
                while ($courseRow = $courseResult->fetch_assoc()) {
                    $tracks[] = $courseRow['course'];
                }

                // Loop through each track
                foreach ($tracks as $track) {
                    echo '<div id="left">';
                    echo '<h2>' . $track . '</h2>';

                    // Retrieve data from the database for the current track
                    $query = "SELECT * FROM courses WHERE course = ?";
                    $stmt = $conn->prepare($query);

                    if ($stmt === false) {
                        die("Error preparing statement: " . $conn->error);
                    }

                    $stmt->bind_param("s", $track);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    // Display the data for each student in the current track
                    while ($row = $result->fetch_assoc()) {
                        echo '<br>';
                        echo '<input type="checkbox" id="scales" name="scales[]" value="' . $row['st_name'] . '" />';
                        echo '<label for="scales">' . $row['st_name'] . '</label>';
                        echo '<div>';
                        // Add additional fields as needed
                        echo '<p>Department: ' . $row['department'] . '</p>';
                        echo '<p>GPA: ' . $row['gpa'] . '</p>';
                        echo '<p>Level: ' . $row['level'] . '</p>';
                        // echo '<p>Course: ' . $row['course'] . '</p>';
                        echo '</div>';
                    }

                    echo '</div>';
                    $stmt->close();
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>
            <br>
            <div class="request-form-button-content">
                <button type="submit" class="request_form_button">
                    save
                </button>
            </div>
        </form>
    </div>
</main>


  

        <!----------------------------------------------->
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