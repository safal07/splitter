<?php
session_start();  //start the session
if (isset($_POST["login"])){  //if the login button is pressed
  include_once 'dbconnect.php'; //get database variables
  $username = mysqli_real_escape_string($conn, $_POST["username"]); //store user credentials from post data
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);

  if ($resultCheck == 1) {  // if a match is found in the database
    $row = mysqli_fetch_assoc($result);
    if($row["password"] === $password){ // check for the password
      $_SESSION["userid"] = $row["userid"];
      $_SESSION["firstname"] = $row["firstname"];
      $_SESSION["lastname"] = $row["lastname"];
      $_SESSION["username"] = $username;
      $_SESSION["email"] = $row["email"];

      header("Location: ../homepage.php?login=sucess");
      //include_once '../homepage.php'; //display homepage
    }
    else header("Location: ../index.php?login=failed");
  }
  else header("Location: ../index.php");
}
else header("Location: ../index.php");  //redirect to index if login button is not pressed
?>
