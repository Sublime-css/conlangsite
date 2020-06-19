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
  <script src="js/main.js"></script>
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
        <!--
        $words = $conn->query("SELECT * FROM words WHERE conlang_id=" . $_GET["l"]);

        if ($words->num_rows > 0) {
            // output data of each row
            while($word = $words->fetch_assoc()) {

              $meanings = $conn->query("SELECT * FROM meanings WHERE word_id=" . $word["id"]);
              $meaning = $meanings->fetch_assoc();
              if (! empty($meaning["pos"])) {
                $pos = $meaning["pos"];
                $english = $meaning["english"];
              }
              else {
                $pos = "<span style=\"color: gray;\"><i>Missing</i></span>";
                $english = "<span style=\"color: gray;\"><i>Missing</i></span>";
              }

              print "<tr>
                      <th><a  href=\"word.php?w=" . $word["id"] . "\" style=\"font-family:" . $conlang["script"] . "\"><b>" . $word["name"] . "</b></a></th>
                      <th>" . $word["name_romanised"] . "</th>
                      <th>" . $pos . "</th>
                      <th>" . $english . "</th>
                    </tr>";


            }

        }
        else {
            echo "<p style=\"color: red;\">ERROR: No words found</p>";
        }
        -->
      </table>
    </div>
  </div>
</body>
