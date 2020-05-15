<?php
include 'setup.php';

if(isset($_POST["request"])) {

  //saveMeaning()
  if($_POST["request"] == "saveMeaning") {
    $keys = array_keys($_POST);
    $conn->query("UPDATE meanings SET " . $keys[0] . " = '" . $_POST[$keys[0]] . "' WHERE id=" . $_POST["m"]);
    echo "Updated meaning at id \"" . $_POST["m"] . "\", field \"" . $keys[0] . "\" with \"" . $_POST[$keys[0]] . "\"";
  }

  //addMeaning()
  if($_POST["request"] == "addMeaning") {
    $conn->query("INSERT INTO meanings (word_id) VALUES (" . $_POST["w"] . ")");
    $id = $conn->insert_id;
    print '
    <ul>
      <form method="post" id="' . $id . '">
          <p>Meaning #' . $_POST["n"] . '</p>
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
            <p>Meaning #' . $count . '</p>
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
}

?>
