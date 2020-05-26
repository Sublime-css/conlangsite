<!DOCTYPE html>
<?php
include "nav.php";
include "setup.php";
?>
<head>
  <link rel="stylesheet" href="css/table.css">
</head>
<body>
  <div class="page">
    <div class="wrapper">
      <div class="pageHeader">
        <b>Languages on LANGFORGE</b>
      </div>

      <table>
        <?php
        $sql = "SELECT * FROM conlangs";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              print "<tr>
                      <th><a  href=\"dictionary.php?l=" . $row["id"] . "\" style=\"font-family: " . $row["script"] . ";\"><b>" . $row["name"] . "</b></a></th>
                      <th>" . $row["name_romanised"] . "</th>
                      <th>" . $row["editors"] . "</th>
                    </tr>";
            }

        } else {
            echo "ERROR: No languages found";
        }
        ?>
      </table>
    </div>
  </div>
</body>
