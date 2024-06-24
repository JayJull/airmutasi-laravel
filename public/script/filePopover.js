var isSet = false;
var urlBuffer = "";

document.addEventListener(
    "beforetoggle",
    (event) => {
        const { newState } = event;
        const popover = event.target;
        if (newState === "closed") {
            const input = popover.querySelector("input");
            if (input && !isSet) {
                input.value = urlBuffer;
            }
            urlBuffer = "";
            if (isSet) isSet = false;
        } else if (newState === "open") {
            const input = popover.querySelector("input");
            if (input) {
                urlBuffer = input.value;
            }
        }
    },
    { capture: true }
);
function initFilePopover(id, onChange = () => {}) {
    document
        .querySelector(`#${id}_url_set`)
        .addEventListener("click", function () {
            isSet = true;
            document.querySelector(`#${id}_popover`).hidePopover();
            document.querySelector(`#${id}_file`).value = "";
            document.querySelector(`#${id}_file_button`).innerHTML =
                "✅️ Berkas";
            onChange();
        });
    document
        .querySelector(`#${id}_file`)
        .addEventListener("change", function () {
            var file = this.files[0];
            document.querySelector(`#${id}_popover`).hidePopover();
            document.querySelector(`#${id}_url`).value = "";
            document.querySelector(
                `#${id}_popover > div > label > span`
            ).innerHTML = file.name;
            document.querySelector(`#${id}_file_button`).innerHTML =
                "✅️ Berkas";
            onChange();
        });
}
