(function (w, d, s, ...args) {
    var div = d.createElement("div");
    div.id = "aichatbot";
    d.body.appendChild(div);
    w.chatbotConfig = args;
    var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s);
    j.defer = true;
    j.type = "module";
    j.src = "https://aichatbot.sendbird.com/index.js";
    f.parentNode.insertBefore(j, f);
})(
    window,
    document,
    "script",
    "482DAF0D-2F31-435B-B5EB-6DFF2ED5000D",
    "onboarding_bot",
    {
        apiHost: "https://api-cf-ap-5.sendbird.com",
    }
);
