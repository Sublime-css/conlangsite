<!DOCTYPE html>
<?php
include 'nav.php';
include 'setup.php';

$words = $conn->query("SELECT * FROM words WHERE id=" . $_GET["w"]);
$word = $words->fetch_assoc();

$conlangs = $conn->query("SELECT * FROM conlangs WHERE id=" . $word["conlang_id"]);
$conlang = $conlangs->fetch_assoc();

?>

<body>
  <div class="page">
    <head>
      <link rel="stylesheet" href="css/table.css">
    </head>
    <div class="wrapper">
      <div class="pageHeader">
        <b><?php print $conlang["name_romanised"]?>'s Dictionary</b>
      </div>
      <div class="section">
        <div class="span">
          <h1 style="font-family: <?php print $conlang['script']; ?>"><?php print $word['name'];?></h1>
          <div style="width: 100%;"></div> <!-- this is literally just to space edit/delete from the word -->
          <a href="wordedit.php?w=<?php print $_GET["w"]?>">edit</a>
          <a>delete</a>
        </div>
        <h3><?php print $word['name_romanised'];?></h3>
        <h3 style="color: #3C99DC">[<?php print $word['pronunciation'];?>]</h3>

        <?php
        $pos = array("noun", "verb");  //OI: this order should probably come from somewhere else rather than be built in. Let users define pos for conlang?

        foreach($pos as $class) {
          $meanings = $conn->query("SELECT * FROM meanings WHERE word_id=" . $_GET["w"] . " AND pos='" . $class . "'"); //finds meanings of certain part of speech

          if($meanings->num_rows > 0) { //checks to see if there are any meanings of that class
            print "<h3>" . $class . "</h3>";

            $count = 0;
            while($meaning = $meanings->fetch_assoc()) {
              $count++;
              print "
              <ul class=\"spand\">
                <div class=\"meaning\">" . $count . ". <span class=\"highlight\">" . $meaning["english"] . "</span>";

              if(strlen($meaning["meaning"]) > 0) {
                print " - " . $meaning["meaning"] . "</div>";
              } else {
                print "</div>";
              }

              if(strlen($meaning["example"]) > 0) { //need example tags?
                print "
                <p class=\"example\">" . $meaning["example"] . "<br />
                " . $meaning["example_english"] . "</p>
                </ul>";
              } else {
                print "</ul>";
              }
            }
          }
        }
        ?>

      </div>
      <div class="section">
        <h2>Related Words</h2>
        <ul>
          other words
        </ul>
        <h2>Synonyms</h2>
        <ul>
          egg
        </ul>
        <h2>Homophones</h2>
        <ul>
          egg
        </ul>
      </div>
      <div class="section">
        <h2>Etymology</h2>
        <ul>
          egg
        </ul>
      </div>
    </div>
  </div>
</body>
