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
        w: firer.name,
      }
    })
      .then(function(result) {
        gparent = firer.parentElement.parentElement;
        gparent.remove();
        console.log(result);
      });
  }
}

wordDisplayLimit = 50;
getWords(0, wordDisplayLimit);
wordsLoaded = wordDisplayLimit;

window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        getWords(wordsLoaded, wordDisplayLimit);
        wordsLoaded = wordDisplayLimit + wordsLoaded;
    }
};
