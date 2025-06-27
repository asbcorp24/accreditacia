chrome.runtime.onMessage.addListener(
    function (request, sender, sendResponse) {

        if (request.greeting == "otv")


            var ot = request.otv;
        ot = ot.substr(1).trim();

        let firstHref = $(".formulation");
        firstHref.each(function (i, elem) {

            let vopros = $(elem).find('.qtext').text();
            if (vopros == request.vopr) {
                console.log(request.vopr);
                //console.log($(elem).find('.answer').text());
                let otv = $(elem).find('.answer').find('div');
                otv.each(function (ii, elem2) {
                    //    console.log([ot,$(elem2).text()]);
                    if ($(elem2).text().trim() == ot) {

                        $(elem2).css('font-style', 'italic');

                    }


                });
            }
            // console.log(i + ': ' + $(elem).text());
            //
        });


    }
);


function sayHi() {
    console.log('go go go')
    var firstHref = $(".formulation");
    firstHref.each(function (i, elem) {

        var vopros = $(elem).find('.qtext').text();
        chrome.runtime.sendMessage({"message": "open_new_tab", "url": vopros});
        //console.log($(elem).find('.answer').text());
        var otv = $(elem).find('.answer').find('div').find('.flex-fill');
        otv.each(function (ii, elem2) {
            // console.log(ii + ': ' + $(elem2).text());


        });
        // console.log(i + ': ' + $(elem).text());
        //
    });


}

setTimeout(sayHi, 5000);

/*
chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {

        chrome.tabs.sendMessage(tabId, sendObj);

});
*/
