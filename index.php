<!DOCTYPE html>
<?php
include "nav.php";
?>
<head>
  <script src="js/index.js"></script>
  <link rel="stylesheet" href="css/table.css">
</head>
<body>
  <div class="page">
    <div class="wrapper">
      <div class="pageHeader">
        <b>Languages on LANGFORGE</b>
        <?php
        if(isset($_SESSION["uid"])) {
          print "<a style=\"float: right;\" href=\"languageedit.php\">Create Language</a>";
        }
        ?>
      </div>
      <table id="table">
      </table>
    </div>
  </div>
</body>
