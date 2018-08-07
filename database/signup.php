<?php
if (isset($_POST["signup"])) {
  include_once 'dbconnect.php';
  $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
  $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  $sql = "INSERT INTO  users (firstname, lastname, username, password, email)
          VALUES ('$firstname', '$lastname', '$username', '$password', '$email');";
  mysqli_query($conn, $sql);
  header("Location: ../index.php?signup=sucess|loginbelow");
}
else {
  header("Location: ../index.php");
  exit();
}
 ?>
