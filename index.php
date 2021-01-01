<?php
// Variables
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "do_supply_test";

//PDO connection to mySQL database on localhost Xampp server
try {
  $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName;
  $pdo = new PDO($dsn, $dbUser, $dbPassword);
} catch(PDOException $e) {
  echo "DB Connection Failed: " . $e->getMessage();
}

//Form Field Validation
$status = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  
  if(empty($name) || empty($email) || empty($phone)) {
    $status = "All fields must be completed.";
  } else {
    if(strlen($name) >= 255 || !preg_match("/^[a-zA-Z-'\s]+$/", $name)) {
      $status = "Please enter a valid name";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $status = "Please enter a valid email";
    } else {
        //mySql statement: posting data into database from input feilds
      $sql = "INSERT INTO do_table_test (name, email, phone) VALUES (:name, :email, :phone)";

      $stmt = $pdo->prepare($sql);
      
      $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone]);

      $status = "Your message was sent";
      $name = "";
      $email = "";
      $phone = "";
    }
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Contact D.O. Supply</title>
</head>

<body>

  <div class="container">
    <h1>Contact D.O. Supply Today</h1>

    <form action="" method="POST" class="main-form">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" class="do-input"
          value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $name ?>">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="do-input"
          value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $email ?>">
      </div>

      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="do-input"
        value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $phone ?>">
      </div>

      <input type="submit" class="do-button" value="Submit">

      <div class="form-status">
        <?php echo $status ?>
      </div>
    </form>
  </div>

  <script src="main.js"></script>

</body>

</html>