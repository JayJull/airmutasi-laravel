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
            document.querySelector(`#${id}_file_button`).innerHTML = "✅️ Ubah";
            document.querySelector(`#${id}_errors`).classList.add("hidden");
            onChange();
        });
    document
        .querySelector(`#${id}_file`)
        .addEventListener("change", function () {
            var file = this.files[0];
            if (!file) return;
            document.querySelector(`#${id}_file_button`).innerHTML = "⏳";
            if (file.size > 2 * 1024 * 1024) {
                document.querySelector(`#${id}_errors`).innerHTML =
                    "Ukuran berkas terlalu besar (max 2MB)";
                document
                    .querySelector(`#${id}_errors`)
                    .classList.remove("hidden");
                document.querySelector(`#${id}_file_button`).innerHTML = "❌️";
                return;
            }
            const formData = new FormData();
            formData.append("file", file);
            fetch("/api/upload-doc", {
                method: "POST",
                body: formData,
            })
                .then(async (response) => {
                    if (!response.ok) {
                        throw await response.json();
                    }
                    return response.json();
                })
                .then((data) => {
                    document.querySelector(`#${id}_popover`).hidePopover();
                    document.querySelector(`#${id}_url`).value = data.url;
                    document.querySelector(`#${id}_file_button`).innerHTML =
                        "✅️ Ubah";
                    document
                        .querySelector(`#${id}_errors`)
                        .classList.add("hidden");
                    onChange();
                })
                .catch((error) => {
                    document.querySelector(`#${id}_errors`).innerHTML =
                        error.message;
                    document
                        .querySelector(`#${id}_errors`)
                        .classList.remove("hidden");
                    document.querySelector(`#${id}_file_button`).innerHTML =
                        "❌️";
                });
        });
}
