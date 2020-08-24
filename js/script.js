//EPIC JAVASCRIPT FOR script.php affecting scripts

/* THIS DOES NOT WORK NO FUCKING IDEA WHY
function addScript() {
  script = document.getElementById('script_file').files[0];
  data = new FormData();
  data.append('files[]', script);

  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "addScript",
      name: "Standard Galactic",
      data: data
    }
  })
    .then(function(result) {
      console.log(result);
    });
}
*/

function addScript() {
  const files = document.getElementById("script_file").files;
  const formData = new FormData();

  for (let i = 0; i < files.length; i++) {
    let file = files[i];
    formData.append("files[]", file);
  }

  fetch("processor.php", {
    method: "POST",
    body: formData
  }).then((result) => {
    console.log(result);
    document.getElementById("feedback").innerText = result;
  })
}
