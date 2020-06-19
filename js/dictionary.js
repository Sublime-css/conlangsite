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

getWords(0, 50);
