<!DOCTYPE HTML>
<head>
  <script src="js/main.js"></script>
  <link rel="stylesheet" href="css/table.css">
</head>
<body>
  <form id="register">
    <div class="spand">
      <input id="email" name="email" type="text"/>
      <input id="uname" name="uname" type="text"/>
      <input id="passw" name="pwd" type="text"/>
    </div>
  </form>
  <button onclick="addUser()"></button>
  <form id="login">
    <div class="spand">
      <input id="uname2" name="uname" type="text"/>
      <input id="passw2" name="pwd" type="text"/>
    </div>
  </form>
  <button onclick="checkUser()"></button>
</body>
