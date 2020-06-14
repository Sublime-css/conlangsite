<?php
include 'setup.php';

function getFileType($file) {
  return strtolower(pathinfo($file,PATHINFO_EXTENSION));
}

if(isset($_REQUEST["test"])) {
  echo "TEST!";
}

if(isset($_POST["request"])) {

  //saveMeaning()
  if($_POST["request"] == "saveMeaning") {
    $keys = array_keys($_POST);
    $conn->query("UPDATE meanings SET " . $_POST["field"] . " = '" . $_POST["value"] . "' WHERE id=" . $_POST["m"]);
    echo "Updated meaning at id \"" . $_POST["m"] . "\", field \"" . $_POST["field"] . "\" with \"" . $_POST["value"] . "\"";
  }

  //addMeaning()
  if($_POST["request"] == "addMeaning") {
    $conn->query("INSERT INTO meanings (word_id) VALUES (" . $_POST["w"] . ")");
    $id = $conn->insert_id;
    $n = 2;
    print '
    <ul>
      <form method="post" id="' . $id . '">
          <p>Meaning #' . $n . '</p> <a onclick="delMeaning()">Delete</a>
          <label for="pos"><p>Part of Speech</p></label>
          <select name="pos" onchange="saveMeaning()">
            <option selected disabled hidden>

            </option>
            <option value="noun">
              noun
            </option>
            <option value="pronoun">
              pronoun
            </option>
            <option value="verb">
              verb
            </option>
            <option value="adjective">
              adjective
            </option>
            <option value="numeral">
              numeral
            </option>
          </select>
          <label for="english"><p>English</p></label>
          <input name="english" type="text" onfocusout="saveMeaning()"/>
          <label for="meaning"><p>Additional Meaning</p></label>
          <input name="meaning" type="text" onfocusout="saveMeaning()"/>
          <label for="example"><p>Example of Meaning</p></label>
          <textarea name="example" style="height: 8em;" onfocusout="saveMeaning()"></textarea>
      </form>
    </ul>
    ';
  }

  //getMeanings()
  if($_POST["request"] == "getMeanings") {
    $meanings = $conn->query("SELECT * FROM meanings WHERE word_id=" . $_POST["w"]);
    $pos = array("noun", "verb");

    $count = 0;
    while($meaning = $meanings->fetch_assoc()) {
      $count++;
      $posSelected = array("", "");
      $selected = array_search($meaning["pos"], $pos);
      $posSelected[$selected] = "selected"; //um ok this makes a array with a bunch of empty strings and "selected" so we can choose the dropdown menu value

      print '
      <ul>
        <form method="post" id="' . $meaning["id"] . '">
            <p>Meaning #' . $count . '</p> <a onclick="delMeaning()">Delete</a>
            <label for="pos"><p>Part of Speech</p></label>
            <select name="pos" onchange="saveMeaning()">
              <option disabled hidden>

              </option>
              <option value="noun">
                noun
              </option>
              <option value="pronoun">
                pronoun
              </option>
              <option value="verb">
                verb
              </option>
              <option value="adjective">
                adjective
              </option>
              <option value="numeral">
                numeral
              </option>
            </select>
            <label for="english"><p>English</p></label>
            <input name="english" type="text" onfocusout="saveMeaning()" value="' . $meaning["english"] . '"/>
            <label for="meaning"><p>Additional Meaning</p></label>
            <input name="meaning" type="text" onfocusout="saveMeaning()" value="' . $meaning["meaning"] . '"/>
            <label for="example"><p>Example of Meaning</p></label>
            <textarea name="example" style="height: 8em;" onfocusout="saveMeaning()">' . $meaning["example"] . '<br />' . $meaning["example_english"] . '</textarea>
        </form>
      </ul>
      ';
    }
  }

  //delMeaning()
  if($_POST["request"] == "delMeaning") {
    $conn->query("DELETE FROM meanings WHERE id=". $_POST["m"]);
    echo "Deleted Meaning with ID " . $_POST["m"];
  }

  //save() TOP text
  if($_POST["request"] == "save") {
    $conn->query("UPDATE words SET " . $_POST["field"] . " = '" . $_POST["value"] . "' WHERE id=" . $_POST["w"]);
    echo "Updated meaning at id \"" . $_POST["w"] . "\", field \"" . $_POST["field"] . "\" with \"" . $_POST["value"] . "\"";
  }

  //fontUpload()
  if($_POST["request"] == "fontUpload") {
    $dir = "scripts/";


    //file checks
    if (getFileType($target) != "ttf") {
      echo "Not a .ttf file.";
    } elseif ($_FILES["script"]["size"] > 5000000) { //not allowing files over 5MB this may be very large check later
      echo "This file is too large.";
    } else {
      echo "Uploading";

      $conn->query("INSERT INTO scripts (name, editors) VALUES (" . $_POST["name"] . ", " . $_POST["editors"] . ")");
      $id = $conn->insert_id;
      $target = $dir . $id;
      if (file_exists($target)) {
        echo "DATABASE ERROR, ID NOT SET PROPERLY";
      } else {
        move_uploaded_file($_FILES["script"], $target);
      }
    }

  }
}

?>
