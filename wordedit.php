<!DOCTYPE html>
<?php
include 'nav.php';
include 'setup.php';

$words = $conn->query("SELECT * FROM words WHERE id=" . $_GET["w"]);
$word = $words->fetch_assoc();

$conlangs = $conn->query("SELECT * FROM conlangs WHERE id=" . $word["conlang_id"]);
$conlang = $conlangs->fetch_assoc();

?>

<head>
  <link rel="stylesheet" href="css/table.css">
</head>
<body>
  <div class="page">
    <div class="wrapper">
      <div class="pageHeader">
        <b>LANGUAGE's Dictionary</b>
      </div>

      <form method="post">
          <label for="text">Word in LANGUAGE</label>
          <input name="text" type="text" />
          <label for="pronunciation">Pronunciation</label>
          <input name="pronunciation" type="text" />
          <label for="romanisation">Romanisation</label>
          <input name="romanisation" type="text" />
          <select>
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

          <div class="meanings">
              <label for="english">Word in English</label>
              <input name="english" type="text" />
              <label for="meaning">Additional Meaning</label>
              <input name="meaning" type="text" />
              <label for="example">Example</label>
              <input name="example" type="text" />
          </div>

        <button onclick="addMeaning()">Add Another Meaning</button>
      </form>
    </div>
  </div>

  <script>
    def addMeaning() {

    }

  </script>
</body>
