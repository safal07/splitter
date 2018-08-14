<?php
session_start();
if(isset($_SESSION["userid"])) {
include_once "database/dbconnect.php";

echo '<!DOCTYPE html>
<html>
  <head>
    <title> Splitter </title>

    <style>
      table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
      }

      td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
      }

      tr:nth-child(even) {
          background-color: #dddddd;
      }
    </style>
  </head>
  <body>
    <h1> SPLITTER </h1>
      <table>
        <tr>
          <th>Receipt#</th>
          <th>Name</th>
          <th>Expense</th>
          <th>Date</th>
          <th>Amount</th>
        </tr>';

        $sql = "SELECT * FROM expenditure INNER JOIN users ON expenditure.userid = users.userid";

        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck >= 1) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
              <td>'.$row["receiptid"].'</td>
              <td>'.$row["firstname"].' '.$row["lastname"]. '</td>
              <td>'.$row["reason"].'</td>
              <td>'.$row["date"].'</td>
              <td>$'.$row["amount"].'</td>
            </tr>';
          }
        }

      echo '</table>
  </body>
</html>';
}
else header("Location: index.php?redirect");
