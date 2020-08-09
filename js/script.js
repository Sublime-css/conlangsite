//EPIC JAVASCRIPT FOR script.php affecting scripts

function addScript() {
  script = document.getElementById("script");

  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "addScript",
      name: "Standard Galactic",
      file: script.value  
    }
  })
    .then(function(result) {
      console.log(result);
    });
}
