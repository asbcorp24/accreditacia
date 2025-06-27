chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
  if (request.greeting === "otv") {
    let ot = request.otv;
    ot = ot.substr(1).trim();

    $(".formulation").each(function (i, elem) {
      let vopros = $(elem).find(".qtext").text();
      if (vopros === request.vopr) {
        $(elem)
          .find(".answer div")
          .each(function (ii, elem2) {
            if ($(elem2).text().trim() === ot) {
              $(elem2).css("font-style", "italic");
            }
          });
      }
    });
  }
});

function sayHi() {
  console.log("go go go");
  $(".formulation").each(function (i, elem) {
    const vopros = $(elem).find(".qtext").text();
    chrome.runtime.sendMessage({ message: "open_new_tab", url: vopros });
  });
}

setTimeout(sayHi, 5000);
