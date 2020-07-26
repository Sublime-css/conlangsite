function addLanguage() {
  request({
    method: "POST",
    url: "processor.php",
    params: { //params object is made into string, is very nice
      request: "addLanguage",
      user:
    }
  })
    .then(function(result) {
      console.log(result);
    });
}
