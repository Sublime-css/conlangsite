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
  <script src="js/wordedit.js"></script>
  <style>
    p {
      margin-bottom: 5px;
    }

    .page select {
      background-color: #EEE;
      padding: 5px;
    }

    textarea {
      outline: none;
      border: none;
      background-color: #EEE;
      font-family: inherit;
      padding: 5px;
      width: 100%;
    }

    input {
      width: 100%;
    }

    select {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="page">
    <div class="wrapper">
      <div class="pageHeader">
        <b>LANGUAGE's Dictionary</b>
      </div>
      <div class="section" >
        <form method="post" id="wordInfo">
          <div class="span">
            <div class="spand" style="width: 150%;">
              <label for="name"><p>Word in LANGUAGE</p></label>
              <input name="name" type="text" />
              <label for="pronunciation"><p>Pronunciation (IPA)</p></label>
              <input name="pronunciation" type="text" />
            </div>
            <div style="width: 100%;"></div>
            <div class="spand" style="width: 150%;">
              <label for="romanisation"><p>Romanisation</p></label>
              <input name="romanisation" type="text" />
            </div>
          </div>
        </form>

        <ul class="spand" style="padding-right: 40px;">
          <form method="post" id="meaning">
              <p>Meaning #1</p>
              <label for="pos"><p>Part of Speech</p></label>
              <select name="pos" onchange="saveMeaning()">
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
        <ul>
          <button onclick="addMeaning()" style="text-align: left;">Add Another Meaning</button>
        </ul>


      </div>
    </div>
  </div>
</body>
