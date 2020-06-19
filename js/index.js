function getLanguage(offset, limit) {
  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "getLanguages",
      offset: offset,
      limit: limit
    }
  })
    .then(function(result) {
      table = document.getElementById("table");
      table.insertAdjacentHTML("beforeend", result);

    });
}

getLanguage(0, 50);
