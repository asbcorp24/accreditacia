// background.js // Вызывается, когда пользователь нажимает на действие браузера.
chrome.runtime.onMessage.addListener(
    function(request, sender, sendResponse) {
        if( request.message === "open_new_tab" ) {
            $.ajax({
                type: "GET",
                url: "http://priem.medzel.ru/get_vopr.php",
                data: { vopros:request.url }
            }).done(function( msg ) {
                let ms;
                if (msg=="0"){return;}
               ms= JSON.parse(msg);
               if (ms.otvet1[0]=='*') ss= ms.otvet1;
                if (ms.otvet2[0]=='*')  ss= ms.otvet2;
                if (ms.otvet3[0]=='*')   ss= ms.otvet3;
                if (ms.otvet4[0]=='*')   ss= ms.otvet4;

                chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
                    console.log(ms);
                    chrome.tabs.sendMessage(tabs[0].id, {greeting: "otv",vopr:request.url,otv:ss});
                });


            });

        }
    }
)
;
