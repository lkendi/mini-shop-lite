/*Initializes the app theme*/

(function () {
    try {
        if (
            localStorage.getItem("dark-mode") === "true" ||
            (!("dark-mode" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    } catch (e) {
        console.warn("Theme init failed", e);
    }
})();
