chrome.runtime.onMessage.addListener((request, sender) => {
  if (request.message === "open_new_tab") {
    const url = `http://priem.medzel.ru/get_vopr.php?vopros=${encodeURIComponent(request.url)}`;
    fetch(url, { method: "GET" })
      .then(response => response.text())
      .then(msg => {
        if (msg === "0") return;
        let ms;
        try {
          ms = JSON.parse(msg);
        } catch (e) {
          console.error("Invalid JSON:", msg);
          return;
        }
        // выбираем ответ, начинающийся с '*'
       let ss = null;
if (ms.otv1 && ms.otv1.startsWith("*")) ss = ms.otv1;
else if (ms.otv2 && ms.otv2.startsWith("*")) ss = ms.otv2;
else if (ms.otv3 && ms.otv3.startsWith("*")) ss = ms.otv3;
else if (ms.otv4 && ms.otv4.startsWith("*")) ss = ms.otvЦ4;

if (!ss) return;

        // отправляем сообщение в активную вкладку
        chrome.tabs.query({ active: true, currentWindow: true }, tabs => {
          if (tabs[0]?.id != null) {
            chrome.tabs.sendMessage(
              tabs[0].id,
              { greeting: "otv", vopr: request.url, otv: ss },
              () => {}
            );
          }
        });
      })
      .catch(err => console.error("Fetch error:", err));
  }
});
