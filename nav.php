<!DOCTYPE html>
<html>
<?php
session_start();
include "setup.php";
?>
<head>
  <title>LANGFORGE</title>
  <link rel="stylesheet" href="css/grid.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/main.js"></script>
</head>

<body>
  <div class="nav">
    <div class="login span margins">
        <a onclick="signup()">SIGN UP</a> | <a onclick="login()">LOG IN</a>
    </div>
    <div class="header span margins" style="">
      <h1 style="padding-right: 10px;"><?php ?></h1>
      <div class="search">
        <form class="span">
          <input type="text" name="search" />
          <select name="searchType">
            <option value="conlang">
              Searching Conlang Words
            </option>
            <option value="english">
              Searching English Words
            </option>
            <option value="languages">
              Searching Languages
            </option>
          </select>
          <button>
            <svg>
              <image href="images/magnifyingGlass.svg">Submit</image>
            </svg>
          </button>
        </form>
      </div>
      <svg viewBox="0 0 300 30" style="width: 300px;">
        <image href="images/langforge.svg">LANGFORGE</image>
      </svg>
    </div>

    <div class="menu span margins">
          <a id="dictionary" href="dictionary.php">DICTIONARY</a>
          <a id="phonology"  href="phonology.php">PHONOLOGY</a>
          <a id="script" href="script.php">SCRIPT</a>
          <a id="index" href="index.php" style="text-align:right;">LANGUAGES</a>
    </div>

  </div>

  <script>
    var page = (location.href.split("/").slice(-1) + "").split(".")[0];
    if(page == "word") {
      page = "dictionary"
    }
    document.getElementById(page).className = "selected"

  </script>
</body>

</html>
