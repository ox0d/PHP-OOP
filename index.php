<?php
require('./user_validator.php');

use Validator\UserValidator;

// Initialize the toast state to false
$toastState = false;

// Check if the form was submitted
if(isset($_POST['submit'])) {

  // Null Coalescing Operator to handle the gender value
  $gender = $_POST['gender'] ?? '';

  // Validate user input using the UserValidator class and get the errors
  $errors = (new UserValidator($_POST['name'], $_POST['email'], $gender))->getErrors();

  // If there are no validation errors, proceed with storing data in the database
  if (empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    // Set the timezone to Asia/Baghdad
    date_default_timezone_set('Asia/Baghdad');
    $current_date = date('Y-m-d H:i:s');

    // Connect to the database
    $dbc = mysqli_connect('localhost', 'root', '', 'demo_db');
    if (!$dbc) {
      die('<span style="background-color: #f44336;">Could not connect to the database. Please try again later.</span>');
    }

    $name = mysqli_real_escape_string($dbc, $name);
    $email = mysqli_real_escape_string($dbc, $email);
    $gender = mysqli_real_escape_string($dbc, $gender);

    // Insert query
    $insert_query = "INSERT INTO user(name, email, gender, added_date) VALUES ('$name', '$email', '$gender', '$current_date')";

    // Execute the insert query
    if(mysqli_query($dbc, $insert_query)) {

      // Clear form fields by emptying the $_POST array
      $_POST = [];

      // Set the toast state to true to display a success message
      $toastState = true;
    } else {
      die('<span style="background-color: #f44336;">Error while storing data. Please try again later.</span>');
    }

    // Close database connection
    mysqli_close($dbc);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Submission</title>
    <link rel="stylesheet" href="./main.css">
</head>
<body>

  <!-- Form -->
  <div id="container">
      <h1>New User Submission</h1>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>">
          <div class="error">
            <?php echo $errors['name'] ?? '' ?>
          </div>

          <label for="email">Email:</label>
          <input type="text" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
          <div class="error">
            <?php echo $errors['email'] ?? '' ?>
          </div>

          <label for="gender">Gender:</label>
          <select id="gender" name="gender">
              <option value="" disabled selected>Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
          </select>
          <div class="error">
            <?php echo $errors['gender'] ?? '' ?>
          </div>

          <input type="submit" value="Submit" name="submit">
      </form>        
  </div>

  <!-- Toast -->
  <?php 
  if ($toastState) {
    echo '<div id="toast" style="background-color: #4caf50;">';
    echo "User stored successfuly!";
    echo "</div>";
  }
  ?>
    
  <!-- Import js -->
  <script src="./app.js"></script>

</body>
</html>
