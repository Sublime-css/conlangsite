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

conlangDisplayLimit = 50;
getLanguage(0, conlangDisplayLimit);
conlangsLoaded = conlangDisplayLimit;

window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        getLanguage(conlangsLoaded, conlangDisplayLimit);
        conlangsLoaded = conlangDisplayLimit + conlangsLoaded;
    }
};
