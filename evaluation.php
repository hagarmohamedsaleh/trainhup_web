<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "summer_training";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the count from the 'requests' table based on the 'status' column
$sql = "SELECT COUNT(*) AS total FROM requests WHERE status IS NOT NULL";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCount = $row['total'];
} else {
    $totalCount = 0;
}

$conn->close();
?>


































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

// Initialize variables to store form data
$evaluations = $_POST['evaluations'] ?? [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO company_evaluation (student_name, evaluation) VALUES (?, ?)");

    // Check if the preparation was successful
    if ($stmt === false) {
        // Handle preparation error
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Bind parameters
    $stmt->bind_param("ss", $student_name, $evaluation);

    // Loop through evaluations and insert into the database
    foreach ($evaluations as $student_name => $evaluation) {
        // Set parameter values
        $student_name = $conn->real_escape_string($student_name);
        $evaluation = $conn->real_escape_string($evaluation);

        // Execute the prepared statement
        $stmt->execute();

        // Check if the execution was successful
        if ($stmt->affected_rows === -1) {
            // Handle execution error
            echo "Error executing statement: " . $stmt->error;
            exit();
        }
    }

    // Close the statement
    $stmt->close();

    // Optionally, you can redirect to a success page after inserting data
    // header("Location: success.php");
}
// Fetch student names where status is "accepted" from the "requests" table
$sql = "SELECT student_name FROM requests WHERE status = 'accepted'";
$result = $conn->query($sql);

// Check for errors during the query execution
if ($result === false) {
    // Handle query execution error
    echo "Error executing query: " . $conn->error;
    exit(); // Exit the script if there's an error
}
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
                <a href="profile.html">
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

                <a href="evaluation.php" class="active">
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
<!--        --------------------------------------------------------------------------------------------- -->

<main>
<h1 data-lang="evaluation"> Evaluation </h1>

            <div class="recent">
                <form method="post">
                <table class="table2">
    <thead>
        <tr>
            <th data-lang="name">student name</th>
            <th data-lang="evaluation" colspan='2'>Evaluation</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['student_name'] . '</td>';
            echo '
                    <div class="apply-form-content-radio">
                    <td>
                        <div>
                            <input type="radio" name="evaluations[' . $row['student_name'] . ']" id="Completed" value="COMPLETED"> 
                            <label for="Completed" data-lang="completed">Completed</label>
                        </div>
                        </td>
                        <td>
                        <div>
                            <input type="radio" name="evaluations[' . $row['student_name'] . ']" id="uncompleted" value="UNCOMPLETED">
                            <label for="uncompleted" data-lang="Uncompleted">Uncompleted</label>
                        </div>
                        </td>
                    </div>';
               
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

                    <br>
                    <div class="request-form-button-content">
                        <button type="submit" class="request_form_button" style="margin-left: 25rem;" data-lang="Save">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </main>
<!-- ----------------------------------------------------------------- -->
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
 