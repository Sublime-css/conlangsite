let params = new URLSearchParams(location.search);
//js = php
//params.get("key") = $_GET["key"]


function getFirer() { //gets HTML element that fired the event
  return event.target || event.srcElement;
}


function request(options) { //does ajax requests example of request below function
  return new Promise(function(resolve, reject) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
      resolve(this.responseText); //resolve promise with reponseText
    };
    xhr.onerror = reject; //rip promise
    xhr.open(options.method, options.url, true);
    if (options.method == "POST") { //only needs this if method is POST but unsure what does if method is GET
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    }
    var params = options.params;
    if (params && typeof params === 'object') {
      params = Object.keys(params).map(function(key) { //code to put params object into string like seen in GET URL
        return encodeURIComponent(key) + '=' + encodeURIComponent(params[key]);
      }).join('&')
    }
    xhr.send(params);
    console.log("Executed AJAX request with options:");
    console.log(options);
  });
}

/* example request
request({
  method: "GET",
  url: "text.txt",
  params: { //params object is made into string, is very nice
    test: 1 //parameters that would normally in the URL for a request with a GET method
  }
})
  .then(function(result) {
    console.log(result); //result is reponseText from ajax request
  })
  .catch(function () { //if it fails for some reason
    console.error("OH HECK ERROR");
  });
*/


//user register
function addUser() {
  email = document.getElementById("email");
  uname = document.getElementById("uname");
  pwd = document.getElementById("passw");

  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "addUser",
      email: email.value,
      uname: uname.value,
      pwd: pwd.value
    }
  })
    .then(function(result) {
      console.log(result);
    });
}

//user logout
function destoryUser() {
  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "destroyUser"
    }
  })
}

//user login
function checkUser() {
  uname = document.getElementById("uname");
  pwd = document.getElementById("passw");

  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "checkUser",
      uname: uname.value,
      pwd: pwd.value
    }
  })
    .then(function(result) {
      console.log(result);
    });
}
