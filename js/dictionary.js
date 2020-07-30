function getWords(offset, limit) {
  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "getWords",
      offset: offset,
      limit: limit,
      l: params.get("l"),
    }
  })
    .then(function(result) {
      table = document.getElementById("table");
      table.insertAdjacentHTML("beforeend", result);

    });
}

function deleteWord() {
  firer = getFirer()
  if(confirm("Are you sure you want to delete this word?")) {
    request({
      method: "POST",
      url: "processor.php",
      params: { //params object is made into string, is very nice
        request: "delete",
        w: params.get("w"),
      }
    })
      .then(function(result) {
        gparent = firer.parentElement.parentElement;
        gparent.remove();
      });
  }
}

getWords(0, 50);
