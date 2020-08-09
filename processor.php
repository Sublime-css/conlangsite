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

//check if user has right permission to edit conlang
function checkUserPerms($conn, $conlang_id) {
  if(isset($_SESSION["uid"])) {
    $editors = $conn->query("SELECT * from editors WHERE conlang_id=" . $conlang_id);
    $editorsList = array();
    while($editor = $editors->fetch_assoc()) {
      $editorsList[] = $editor["user_id"];
    }
    return in_array($_SESSION["uid"], $editorsList);
  }
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

  //delete() word
  if($_POST["request"] == "delete") {
    $words = $conn->query("SELECT * FROM words WHERE id=" . $_POST["w"]);
    $word = $words->fetch_assoc();
    $conn->query("DELETE FROM meanings WHERE word_id=" . $_POST["w"]);
    $conn->query("DELETE FROM words WHERE id=" . $_POST["w"]);
    echo "dictionary.php?l=" . $word["conlang_id"];
  }

  //fontUpload()
  if($_POST["request"] == "addScript") {
    $dir = "scripts/";

    //file checks
    echo getFileType($_FILES["script"]);
    if (getFileType($_FILES["script"]) != "ttf") {
      echo "Not a .ttf file.";
    } elseif ($_FILES["script"]["size"] > 5000000) { //not allowing files over 5MB this may be very large check later
      echo "This file is too large.";
    } else {
      echo "Uploading";

      $conn->query("INSERT INTO scripts (name, editors) VALUES (" . $_POST["name"] . ", " . $_SESSION["uid"] . ")");
      $id = $conn->insert_id;
      if (file_exists($target)) {
        echo "DATABASE ERROR, ID NOT SET PROPERLY";
      } else {
        move_uploaded_file($_FILES["script"], $dir);
      }
    }
  }

  if($_POST["request"] == "getLanguages") {
    $languages = $conn->query("SELECT * FROM conlangs LIMIT " . $_POST["offset"] . ", " . $_POST["limit"]);

    // output data of each row
    while($language = $languages->fetch_assoc()) {
      $editorsList = array(); //List of editors for the front end table
      $editors = $conn->query("SELECT editors.conlang_id, users.name FROM editors LEFT JOIN users ON editors.user_id=users.id WHERE conlang_id=" . $language["id"]);
      while ($editor = $editors->fetch_assoc()) { $editorsList[] = $editor["name"]; }
      $editorsList = join(", ", $editorsList);

      print "<tr>";

      //if conlang has script associated with it use it
      if($language["script_id"] != "") {
        print "<th><a  href=\"dictionary.php?l=" . $language["id"] . "\" style=\"font-family: f" . $language["script_id"] . ";\"><b>" . $language["name"] . "</b></a></th>";
      } else {
        print "<th><a  href=\"dictionary.php?l=" . $language["id"] . "\"><b>" . $language["name"] . "</b></a></th>";
      }

      print "<th>" . $language["name_romanised"] . "</th>
             <th>" . $editorsList . "</th>
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

      print "<tr>";

      //if conlang has script associated with it use it
      if($language["script_id"] != "") {
        print "<th><a  href=\"word.php?w=" . $word["id"] . "\" style=\"font-family: f" . $language["script_id"] . "\"><b>" . $word["name"] . "</b></a></th>";
      } else {
        print "<th><a  href=\"word.php?w=" . $word["id"] . "\"><b>" . $word["name"] . "</b></a></th>";
      }

      print "<th>" . $word["name_romanised"] . "</th>
            <th>" . $pos . "</th>
            <th>" . $english . "</th>";


      if(checkUserPerms($conn, $language["id"])) {
        print "<th style=\"width: auto; display: flex;\"><a href=\"wordedit.php?w=" . $word["id"] . "\">Edit</a><a onclick=\"deleteWord()\" name=" . $word["id"] . ">Delete</a></th>";
      }

      print "</tr>";
    }
  }

  if($_POST["request"] == "addUser") {
    $stmt = $conn->prepare("INSERT INTO users (name, pwd, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $uname, $pwd, $email);

    $pwd = password_hash(trim($_POST["pwd"]), PASSWORD_DEFAULT);
    $uname = $_POST["uname"];
    $email = hash("sha256", trim($_POST["email"]));
    echo $uname;

    $stmt->execute();
    $stmt->close();
  }

  if($_POST["request"] == "checkUser") {
    $stmt = $conn->prepare("SELECT * FROM users WHERE name=?");
    $stmt->bind_param("s", $uname);
    $uname = $_POST["uname"];
    $stmt->execute();
    $users = $stmt->get_result();
    $user = $users->fetch_assoc();

    if(password_verify(trim($_POST["pwd"]), $user["pwd"])) {
      $_SESSION["uname"] = $user["name"];
      $_SESSION["uid"] = $user["id"];
      echo "Logged in as " . $_SESSION["uname"];
      echo " " . $_SESSION["uid"];
    } else {
      echo "Failed";
    }
  }

  if($_POST["request"] == "destroyUser") {
    unset($_SESSION["uname"]);
    unset($_SESSION["uid"]);
    header("Refresh:0");
  }

  if($_POST["request"] == "getUID") {
    echo $_SESSION["uid"];
    echo $_SESSION["uname"];
  }

  if($_POST["request"] == "checkUserPerms") {
    echo checkUserPerms($conn, $_POST["conlang_id"]);
  }

  //need user creating &  name of language
  if($_POST["request"] == "addLanguage") {
    $conn->query("INSERT INTO conlangs");
    $id = $conn->insert_id;
    $conn->query("INSERT INTO editors (user_id, conlang_id) VALUES (" . $_SESSION["uid"] . ", " . $id . ")");
  }

  if($_POST["request"] == "deleteLanguage") {

  }

  if($_POST["request"] == "updateLanguage") {

  }

}


?>
