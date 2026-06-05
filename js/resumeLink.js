document.addEventListener("DOMContentLoaded", function () {
    const resumeLink = document.getElementById("resumeLink");
    resumeLink.addEventListener("click", function (e) {
        e.preventDefault();
        const file = resumeLink.getAttribute("data-pdf");
        window.open(file, "_blank", "noopener");
    });
});

