<?php
session_start();

if(isset($_SESSION["userid"])) {
  include_once 'database/dbconnect.php';
  include_once 'head.html';
  include_once 'partone.html';
  echo $_SESSION["firstname"]. " ". $_SESSION["lastname"];
  include_once 'parttwo.html';
  $sql = "SELECT SUM(amount) FROM expenditure";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);

  if ($resultCheck == 1) {
    $row = mysqli_fetch_assoc($result);
    echo round($row["SUM(amount)"], 2);
  }

  $userid = $_SESSION["userid"];
  $userDivided = 0;
  $sql = "SELECT SUM(amount) FROM expenditure WHERE userid='$userid'";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  if ($resultCheck >= 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<p class = "your_total"> YOUR TOTAL: $'. round($row["SUM(amount)"], 2). '</p>';
      $userDivided = $row["SUM(amount)"]/4;
    }
  }


      echo '</div>
    </div>
  </div>
  <div class="bottom_content">';


      function userSummary($userDivided, $mateDivided, $mateName) {
         if($mateDivided > $userDivided)
          return "You owe ". $mateName . " $" . round(($mateDivided-$userDivided), 2). " only!";

         else if($mateDivided < $userDivided)
          return $mateName . " owes you $" . round(($userDivided-$mateDivided), 2). " only!";

        else
          return "You are in balance with ". $mateName. " !";
      }

      $sql = "SELECT users.firstname, users.userid, SUM(expenditure.amount)
            FROM expenditure INNER JOIN users ON expenditure.userid = users.userid
            WHERE NOT users.userid='$userid' GROUP BY users.userid";

      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);

      if ($resultCheck >= 1) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="summary_row">
            <div class="username">'.$row["firstname"].'</div>
            <div class="user_total">$'.round($row["SUM(expenditure.amount)"], 2).'</div>
            <div class="user_summary">'.
            userSummary($userDivided, $row["SUM(expenditure.amount)"]/4, $row["firstname"])
            .'</div>
          </div>';
        }
      }
      include_once "partthree.html";
}
else header("Location: index.php?redirect");
?>
