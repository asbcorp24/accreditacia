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
        let ss =
          (ms.otvet1 && ms.otvet1.startsWith("*") && ms.otvet1) ||
          (ms.otvet2 && ms.otvet2.startsWith("*") && ms.otvet2) ||
          (ms.otvet3 && ms.otvet3.startsWith("*") && ms.otvet3) ||
          (ms.otvet4 && ms.otvet4.startsWith("*") && ms.otvet4) ||
          null;
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
