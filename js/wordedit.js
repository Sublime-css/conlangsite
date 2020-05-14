let params = new URLSearchParams(location.search);
//params.get("key") = $_GET["key"]


function getFirer() {
  return event.target || event.srcElement;
}

function saveMeaning() {
  firer = getFirer();
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {

      console.log("Server Reponse: " + this.responseText);
  };

  xhr.open("POST", "processor.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(firer.name + "=" + firer.value);
  console.log("Requested Data from Server")
}
