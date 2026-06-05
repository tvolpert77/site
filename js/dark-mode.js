function setupDarkModeToggle() {
    const toggle = document.getElementById("mode-toggle");
    if (!toggle) return;

    // Set initial button text
    if (document.body.classList.contains("dark-mode")) {
        toggle.textContent = "☀️ Light Mode";
    } else {
        toggle.textContent = "🌙 Dark Mode";
    }

    toggle.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("dark-mode", "enabled");
            toggle.textContent = "☀️ Light Mode";
        } else {
            localStorage.setItem("dark-mode", "disabled");
            toggle.textContent = "🌙 Dark Mode";
        }
    });
}

// Apply dark mode immediately (before CSS loads to prevent flash)
if (localStorage.getItem("dark-mode") === "enabled") {
    document.body.classList.add("dark-mode");
}
