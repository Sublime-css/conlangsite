<!DOCTYPE html>
<html>
<?php
include "processor.php";
?>
<head>
  <title>LANGFORGE</title>
  <link rel="stylesheet" href="css/grid.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/main.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
  <div class="nav">
    <div class="overlay">
      <div class="login span margins">
        <ul><?php if(isset($_SESSION["uid"])) { ?>
          <a onclick="destroyUser()">LOG OUT</a> | <?php print "Logged in as " . $_SESSION["uname"] ?>
        <?php } else { ?>
          <a href="usermenu.php?q=1">SIGN UP</a> | <a href="usermenu.php?q=0">LOG IN</a>
        <?php } ?></ul>
      </div>
      <div class="header span margins" style="">
        <h1 style="padding-right: 10px;"><?php ?></h1>
        <div class="search">
          <form class="span" onsubmit="return searching()">
            <input id="search" type="text" name="search" />
            <select id="searchType" name="searchType" onchange="updateSearchScript()">
              <option value="name">
                Searching by Word
              </option>
              <option value="name_romanised">
                Searching by Romanisation
              </option>
              <option value="english">
                Searching by Meaning
              </option>
              <option value="name">
                Searching by Language
              </option>
            </select>
            <button type="submit">
              <svg>
                <image href="images/magnifyingGlass.svg">Submit</image>
              </svg>
            </button>
          </form>
        </div>
        <!-- <svg viewBox="0 0 300 30" style="width: 300px;">
          <image href="images/langforge.svg">LANGFORGE</image>
        </svg> -->
      </div>

      <div class="menu span margins tabbed">
            <a id="dictionary" href="dictionary.php">DICTIONARY</a>
            <!-- <a id="phonology"  href="phonology.php">PHONOLOGY</a> -->
            <a id="script" href="script.php">SCRIPT</a>
            <a id="index" href="index.php" style="border-style: none solid none solid;">LANGUAGES</a>
      </div>
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
