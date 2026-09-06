import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Existing app.js content (if any) stays above this

if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker
            .register("/sw.js")
            .then(() => console.log("Service worker registered"))
            .catch((err) =>
                console.error("Service worker registration failed:", err),
            );
    });
}
