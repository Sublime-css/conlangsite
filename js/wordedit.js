let params = new URLSearchParams(location.search);
//js = php
//params.get("key") = $_GET["key"]


function getFirer() { //gets HTML element that fired the event
  return event.target || event.srcElement;
}

function addMeaning() {
  var n = "2";
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
      console.log("Server Reponse: " + this.responseText);

      if (this.readyState == 4 && this.status == 200) {
        button = document.getElementById("addMeaning");
        button.insertAdjacentHTML("beforebegin", this.responseText);
        return 1;
      }
  };

  xhr.open("POST", "processor.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("request=addMeaning&n=" + n + "&w=" + params.get("w"));
  console.log("Requested Data from Server");
}

function saveMeaning() {
  firer = getFirer();
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
      console.log("Server Reponse: " + this.responseText);
  };

  xhr.open("POST", "processor.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(firer.name + "=" + firer.value + "&request=saveMeaning&m=" + firer.parentElement.id);
  console.log("Requested Data from Server");
}

function getMeanings() { //similar functionality with addMeanings should be put into a function if possible
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
      console.log("Server Reponse: " + this.responseText);

      if (this.readyState == 4 && this.status == 200) {
        button = document.getElementById("addMeaning");
        button.insertAdjacentHTML("beforebegin", this.responseText);
        return 1;
      }
  };

  xhr.open("POST", "processor.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("request=getMeanings&w=" + params.get("w"));
  console.log("Requested Data from Server");
}

getMeanings();
