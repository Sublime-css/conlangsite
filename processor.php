<?php
include 'setup.php';

function getFileType($file) {
  return strtolower(pathinfo($file,PATHINFO_EXTENSION));
}

//getting output from the database
//turns into HTML entities like \&lt;
function cleanHTML($array) {
  foreach ($array as $key => $value) {
    $array[$key] = htmlspecialchars(htmlentities($value));
    return $array;
  }
}

function cleanUserInput($string) {
  return 0;
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
      $meaning = cleanHTML($meaning);
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

  if($_POST["request"] == "getLanguages") {
    $languages = $conn->query("SELECT * FROM conlangs LIMIT " . $_POST["offset"] . ", " . $_POST["limit"]);

    // output data of each row
    while($language = $languages->fetch_assoc()) {
      print "<tr>
              <th><a  href=\"dictionary.php?l=" . $language["id"] . "\" style=\"font-family: " . $language["script_id"] . ";\"><b>" . $language["name"] . "</b></a></th>
              <th>" . $language["name_romanised"] . "</th>
              <th>" . $language["editors"] . "</th>
            </tr>";
    }
  }

  if($_POST["request"] == "getWords") {
    $words = $conn->query("SELECT * FROM words WHERE conlang_id=" . $_POST["l"] . " LIMIT " . $_POST["offset"] . ", " . $_POST["limit"]);
    $languages = $conn->query("SELECT * FROM conlangs WHERE id=" . $_POST["l"]);
    $language = $languages->fetch_assoc();

    while($word = $words->fetch_assoc()) {
      $meanings = $conn->query("SELECT * FROM meanings WHERE word_id=" . $word["id"] . " LIMIT 5");

      $pos = array();
      $english = array();
      while($meaning = $meanings->fetch_assoc()) {
        $meaning = cleanHTML($meaning);
        if ($meaning["pos"] != "") { $pos[] = $meaning["pos"]; }
        if ($meaning["english"] != "") { $english[] = $meaning["english"]; }
      }
      $pos = join(", ", $pos);
      $english = join(", ", $english);

      print "<tr>
              <th><a  href=\"word.php?w=" . $word["id"] . "\" style=\"font-family:" . $language["script_id"] . "\"><b>" . $word["name"] . "</b></a></th>
              <th>" . $word["name_romanised"] . "</th>
              <th>" . $pos . "</th>
              <th>" . $english . "</th>
            </tr>";
    }
  }

  if($_POST["request"] == "addUser") {
    $stmt = $conn->prepare("INSERT INTO users (name, pwd, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $uname, $pwd, $email);

    $pwd = password_hash(trim($_POST["pwd"]), PASSWORD_DEFAULT);
    $uname = hash("sha256", trim($_POST["uname"]));
    $email = hash("sha256", trim($_POST["email"]));
    echo $uname;

    $stmt->execute();
    $stmt->close();
  }

  if($_POST["request"] == "checkUser") {
    $stmt = $conn->prepare("SELECT * FROM users WHERE name=?");
    $stmt->bind_param("s", $uname);
    $uname = hash("sha256", trim($_POST["uname"]));
    $stmt->execute();
    $users = $stmt->get_result();
    $user = $users->fetch_assoc();

    if(password_verify(trim($_POST["pwd"]), $user["pwd"])) {
      $_SESSION["uname"] = $user["name"];
      echo "Logged in as " . $_SESSION["uname"];
    } else {
      echo "Failed";
    }
  }

  if($_POST == "destroyUser") {
    unset($_SESSION["uname"]);
  }
}

?>
