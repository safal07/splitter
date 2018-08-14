<?php
session_start();

if(isset($_SESSION["userid"])) {
  include_once 'database/dbconnect.php';
  include_once 'head.html';
  include_once 'partone.html';
  echo $_SESSION["firstname"]. " ". $_SESSION["lastname"];
  include_once 'parttwo.html';

  $sql = "SELECT * FROM users";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  $userlist = array();
  $expenselist = array();
  $totalexpense = 0;
  $userTotalExpense = 0;
  $userid = $_SESSION["userid"];
  $userDivided = 0;



  if ($resultCheck >= 1) {
    while($row = mysqli_fetch_assoc($result)) {
        array_push($userlist, $row);
    }
  }

  $sql = "SELECT userid, SUM(amount) FROM expenditure GROUP BY userid";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);

  if ($resultCheck >= 1) {
    while($row = mysqli_fetch_assoc($result)) {
        array_push($expenselist, $row);
    }
  }

  for ($i = 0; $i < sizeof($expenselist); $i++) {
    if ($expenselist[$i]["userid"] == $userid) {
      $userTotalExpense += $expenselist[$i]["SUM(amount)"];
    }
    $totalexpense += $expenselist[$i]["SUM(amount)"];
  }
    $userDivided = $userTotalExpense/4;
  echo  '<div class="top_right">
          <div class="graphic_title">
            TOTAL EXPENSES ( '. date("F"). ', '. date("Y").
            ' )
          </div>
          <div class = "expense_amount">
            $'.round($totalexpense, 2).
            '<p class = "your_total"> YOUR TOTAL: $'
              . round($userTotalExpense, 2).
            '</p>
          </div>
          </div>
         </div>
         <div class="bottom_content">';


      function userSummary($userlist, $userDivided, $mateTotalExpense, $mateName) {
        $mateDivided = $mateTotalExpense/4;
         if($mateDivided > $userDivided) {
           echo '<div class="summary_row">
                 <div class="username negative">'.$mateName.'</div>
                 <div class="user_total">$'.round($mateDivided-$userDivided, 2).'</div>
                 <div class="user_summary">'
                 .$mateName.
                 '\'s total expense this month: $'
                 .round($mateTotalExpense, 2).
                 '<br>
                 You owe '. $mateName . ': $'. round($mateDivided-$userDivided, 2).
                 '</div>
                 </div>';
         }
         else if($userDivided > $mateDivided) {
           echo '<div class="summary_row">
                 <div class="username positive">'.$mateName.'</div>
                 <div class="user_total">$'.round($userDivided-$mateDivided, 2).'</div>
                 <div class="user_summary">'
                 .$mateName.
                 '\'s total expense this month: $'
                 .round($mateTotalExpense, 2).
                 '<br>'
                 . $mateName .' owe\'s you : $'. round($userDivided-$mateDivided, 2).
                 '</div>
                 </div>';
         }
         else {
           echo '<div class="summary_row">
                 <div class="username balance">'.$mateName.'</div>
                 <div class="user_total">$'.round($mateDivided-$userDivided, 2).'</div>
                 <div class="user_summary">'
                 .$mateName.
                 '\'s total expense this month: $'
                 .round($mateTotalExpense, 2).
                 '<br>
                 You are in balance with '. $mateName. ' !
                 </div>
                 </div>';
         }
      }

      function findExpense($expenselist, $thisuserid) {
        for ($i = 0; $i < sizeof($expenselist); $i++) {
          if ($expenselist[$i]["userid"] == $thisuserid) {
            return $expenselist[$i]["SUM(amount)"];
          }
        }
        return 0;
      }



      for ($i = 0; $i < sizeof($userlist); $i++) {
        $thisUserExpense = findExpense($expenselist, $userlist[$i]["userid"]);
        if ( $userlist[$i]["userid"] != $userid) {
          userSummary($userlist, $userDivided, $thisUserExpense, $userlist[$i]["firstname"]);
        }
      }

      include_once "partthree.html";
}
else header("Location: index.php?redirect");
?>
