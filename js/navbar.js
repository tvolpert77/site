document.addEventListener("DOMContentLoaded", () => {
    const nav = document.getElementById("navbar");
    if (nav) {
        nav.innerHTML = `
            <ul>
                <li><a href="index.html">Projects</a></li>
                <li><a href="about_me.html">About Me</a></li>
                 <li><a href="resume.html">Resume</a></li>
                <li><a href="contact.html">Contact</a></li>               
                <button id="mode-toggle">🌙 Dark Mode</button>
            </ul>
        `;

        setupDarkModeToggle();
    }
});
