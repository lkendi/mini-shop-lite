/**
 * Scripts for the welcome page
 * includes theme toggle and mobile menu functionality
 */

document.addEventListener("DOMContentLoaded", function () {
    /*Theme Toggle*/
    const themeToggleBtn = document.getElementById("theme-toggle");
    const themeToggleDarkIcon = document.getElementById(
        "theme-toggle-dark-icon"
    );
    const themeToggleLightIcon = document.getElementById(
        "theme-toggle-light-icon"
    );

    if (themeToggleBtn) {
        if (!themeToggleDarkIcon || !themeToggleLightIcon) {
            const d = themeToggleBtn.querySelector('[data-theme="dark"]');
            const l = themeToggleBtn.querySelector('[data-theme="light"]');
            if (d && !themeToggleDarkIcon) themeToggleDarkIcon = d;
            if (l && !themeToggleLightIcon) themeToggleLightIcon = l;
        }

        if (
            localStorage.getItem("dark-mode") === "true" ||
            (!("dark-mode" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            if (themeToggleLightIcon)
                themeToggleLightIcon.classList.remove("hidden");
            if (themeToggleDarkIcon)
                themeToggleDarkIcon.classList.add("hidden");
        } else {
            if (themeToggleDarkIcon)
                themeToggleDarkIcon.classList.remove("hidden");
            if (themeToggleLightIcon)
                themeToggleLightIcon.classList.add("hidden");
        }

        themeToggleBtn.addEventListener("click", function () {
            if (themeToggleDarkIcon)
                themeToggleDarkIcon.classList.toggle("hidden");
            if (themeToggleLightIcon)
                themeToggleLightIcon.classList.toggle("hidden");

            document.documentElement.classList.toggle("dark");
            localStorage.setItem(
                "dark-mode",
                document.documentElement.classList.contains("dark")
                    ? "true"
                    : "false"
            );

            themeToggleBtn.setAttribute(
                "aria-pressed",
                document.documentElement.classList.contains("dark")
                    ? "true"
                    : "false"
            );
        });
    }

    /* Mobile Menu*/
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    const hamburgerIcon = document.getElementById("hamburger-icon");
    const closeIcon = document.getElementById("close-icon");

    if (mobileMenuButton) {
        mobileMenuButton.addEventListener("click", function () {
            if (mobileMenu) mobileMenu.classList.toggle("hidden");
            if (hamburgerIcon) hamburgerIcon.classList.toggle("hidden");
            if (closeIcon) closeIcon.classList.toggle("hidden");

            const expanded =
                mobileMenuButton.getAttribute("aria-expanded") === "true";
            mobileMenuButton.setAttribute(
                "aria-expanded",
                (!expanded).toString()
            );
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                if (mobileMenu && !mobileMenu.classList.contains("hidden")) {
                    mobileMenu.classList.add("hidden");
                    if (hamburgerIcon) hamburgerIcon.classList.remove("hidden");
                    if (closeIcon) closeIcon.classList.add("hidden");
                    mobileMenuButton.setAttribute("aria-expanded", "false");
                }
            }
        });

        document.addEventListener("click", function (e) {
            if (!mobileMenu) return;
            if (mobileMenu.classList.contains("hidden")) return;
            if (
                mobileMenu.contains(e.target) ||
                mobileMenuButton.contains(e.target)
            )
                return;

            mobileMenu.classList.add("hidden");
            if (hamburgerIcon) hamburgerIcon.classList.remove("hidden");
            if (closeIcon) closeIcon.classList.add("hidden");
            mobileMenuButton.setAttribute("aria-expanded", "false");
        });
    }
});
