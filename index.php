<!DOCTYPE html>
<html>
  <head>
    <title> Grocery Divider </title>
  </head>
  <body>
    <h1>SPLITTER</h1>
      Login
      <form action="database/login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="login">Login</button>
      </form>
      <br>
      <br>
      <br>

      Signup
      <form class="signup" action="database/signup.php" method="post">
        <input type="text" name="firstname" placeholder="Firstname">
        <input type="text" name="lastname" placeholder="Lastname"><br>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password"><br>
        <input type="email" name="email" placeholder="Email Address">
        <button type="submit" name="signup">Signup</button>
      </form>
  </body>
</html>
