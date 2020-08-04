<!DOCTYPE HTML>
<head>
  <script src="js/main.js"></script>
  <?php include "nav.php" ?>
</head>
<body>
  <div class="page">
    <div class="wrapper">
      <form id="register">
        <div class="spand">
          <label for="email">Email</label>
          <input id="email" name="email" type="text"/>
          <label for="uname">Username</label>
          <input id="uname" name="uname" type="text"/>
          <label for="pwd">Password</label>
          <input id="passw" name="pwd" type="password"/>
        </div>
      </form>
      <button onclick="addUser()">Sign up</button>
      <button onclick="checkUser()"></button>
    </div>
  </div>
</body>
