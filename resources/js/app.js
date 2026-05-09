import "./bootstrap";
import "./layout-loader";

window.addEventListener("pageshow", (event) => {
    const navigationType = performance.getEntriesByType("navigation")[0]?.type;

    if (event.persisted || navigationType === "back_forward") {
        window.location.reload();
    }
});
