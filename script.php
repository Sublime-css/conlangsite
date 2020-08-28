<!DOCTYPE html>
<?php include 'nav.php';?>
<head>
  <script src="js/script.js"></script>
  <link rel="stylesheet" href="css/table.css">
</head>
<body>
  <div class="page">
    <div class="wrapper" class="spand">
      <div class="section">
        <p>Upload A Script</p>
        <p>
          The font must be in .ttf format
        </p>
        <input id="script_file" type="file" name="script"/>
        <a type="submit" onclick="addScript()">Upload</a>
        <p id="feedback"></p>
      </div>
      <table>
        <tr class="tableHeading">
          <th>
            ID
          </th>
          <th>
            Name
          </th>
          <th>
            Editor
          </th>
        </tr>
      </table>
      <table id=table>
      </table>
    </div>
  </div>
</body>
