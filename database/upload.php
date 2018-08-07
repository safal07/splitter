<?php
session_start();
//check if submit button for upload is pressed
if (isset($_POST["add"])) {
  echo "it is here";
  include_once "dbconnect.php";
  // grab form info
  $userid = $_SESSION["userid"];
  $reason = $_POST["reason"];
  $amount = $_POST["amount"];
  $date = $_POST["date"];

  //all file info
  $file = $_FILES["file"];
  $fileName = $file["name"];
  $fileTmpName = $file["tmp_name"];
  $fileSize = $file["size"];
  $fileError = $file["error"];
  $fileType = $file["type"];

//filter the accepted file extension.
  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpg', 'jpeg', 'png', 'pdf');

  if(in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize <= 1000000) {
        $fileNewName = uniqid('', true).'.'.$fileActualExt;
        $fileDestination = "../uploads/".$fileNewName;
        move_uploaded_file($fileTmpName, $fileDestination);
        $sql = "INSERT INTO  expenditure (userid, reason, amount, date, receiptimage)
                VALUES ('$userid', '$reason', '$amount', '$date', '$fileNewName');";
        mysqli_query($conn, $sql);
        header("Location: ../homepage.php?upload=sucess");
      }
      else {
        echo "File size is too big to upload.";
      }
    }
    else {
      echo "There was an erro uploading file.";
    }
  }
  else {
    echo "You cannot upload files of this type. Make sure it is a picture format.";
  }
}
?>
