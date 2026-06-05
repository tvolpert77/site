document.addEventListener("DOMContentLoaded", () => {
    const currentProject = document.body.dataset.project;
    const navContainer = document.querySelector(".project-nav");

    if (!currentProject || !navContainer) return;

    fetch("index.html")
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            const links = [...doc.querySelectorAll(".project-link")]
                .map(link => link.getAttribute("href"));

            const currentIndex = links.indexOf(currentProject);
            if (currentIndex === -1) return;

            const prev = links[currentIndex - 1];
            const next = links[currentIndex + 1];

            navContainer.innerHTML = `
                ${prev ? `<a href="${prev}" class="nav-btn">⬅️ Prev</a>` : ""}
                ${next ? `<a href="${next}" class="nav-btn">Next ➡️</a>` : ""}
            `;
        })
        .catch(err => {
            console.error("Failed to load index.html for nav links", err);
        });
});
