<!DOCTYPE html>
<?php
if (is_null($_GET["l"])) {
  header("Location: index.php");
}

include 'nav.php';
include 'setup.php';
?>

<head>
  <link rel="stylesheet" href="css/table.css">
  <script src="js/dictionary.js"></script>
</head>
<body>
  <div class="page">
    <div class="wrapper">
      <div class="pageHeader">
        <b>
          <?php
          $conlangs = $conn->query("SELECT * FROM conlangs WHERE id=" . $_GET["l"]);
          $conlang = $conlangs->fetch_assoc();
          print $conlang['name_romanised'] . "'s Dictionary";
          ?>
        </b>
          <?php
          print "<a style=\"float: right;\" href=\"wordedit.php?l=" . $conlang['id'] . "\">Add Word</a>";
          ?>
      </div>

      <table id="table">

      </table>
    </div>
  </div>
</body>
