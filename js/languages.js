function getLanguage(offset, limit) {
  request({
    method: "POST",
    url: "processor.php",
    params: {
      request: "getLanguages",
      offset: offset,
      limit: limit,
      searchField: document.getElementById("searchType").value,
      search: document.getElementById("search").value
    }
  })
    .then(function(result) {
      console.log(result);
      result = JSON.parse(result);
      table = document.getElementById("table");
      table.insertAdjacentHTML("beforeend", result.HTML);
      for (i = 0; i < result.scripts.length; i++) {
        loadScript(result.scripts[i]);
      }
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

function searching() {
  document.getElementById("table").innerHTML = "";
  getLanguage(0, conlangDisplayLimit);
  conlangsLoaded = conlangDisplayLimit;
  return false;
}
