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

function delMeaning() { //similar functionality with addMeanings should be put into a function if possible
  if(confirm("Are you sure you want do delete this meaning?") == false) {
    return 0;
  }

  var xhr = new XMLHttpRequest();
  firer = getFirer();

  xhr.onreadystatechange = function() {
      console.log("Server Reponse: " + this.responseText);

      if (this.readyState == 4 && this.status == 200) {
        firer.parentElement.remove();
      }
  };

  xhr.open("POST", "processor.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("request=delMeaning&m=" + firer.parentElement.id);
  console.log("Requested Data from Server");
}

function save() {
  var xhr = new XMLHttpRequest();
  firer = getFirer();

  xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log("Server Reponse: " + this.responseText);
      }
  };

  xhr.open("POST", "processor.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(firer.name + "=" + firer.value + "&request=save&w=" + params.get("w"));
  console.log("Requested Data from Server");
}



getMeanings();
