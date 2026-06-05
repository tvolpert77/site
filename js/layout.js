document.addEventListener("DOMContentLoaded", () => {
    // Inject header
    const header = document.getElementById("main-header");
    if (header) {
        header.innerHTML = `
            <div class="container">
                <h1><a href="index.html"> Tyler Volpert | Portfolio</a></h1>
            </div>
        `;
    }

    // Inject footer
    const footer = document.getElementById("main-footer");
    if (footer) {
        footer.innerHTML = `
            <p>&copy; 2025 Tyler Volpert | All rights reserved</p>
        `;
    }
});