function show_window(window) {
    window.style.opacity = "0";
    window.style.display = "block";
    let start = Date.now();

    let timer = setInterval(function () {
        let now = Date.now() - start;

        if (now >= 300) {
            clearInterval(timer);
            window.style.opacity = "1";
            return;
        }

        window.style.opacity = ((now / 3) / 100).toString();
    }, 10);
}

function hide_window(window) {
    window.style.opacity = "1";
    let start = Date.now();
    let timer = setInterval(function () {
        let now = Date.now() - start;

        if (now >= 300) {
            clearInterval(timer);
            window.style.opacity = "0";
            window.style.display = "none";
            return;
        }

        window.style.opacity = (1 - (now / 3) / 100).toString();
    }, 10);
}