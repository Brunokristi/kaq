import '../css/app.css'
import 'bootstrap-icons/font/bootstrap-icons.css'


document.addEventListener("DOMContentLoaded", () => {

    const toggle = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");
    const categoryToggles = document.querySelectorAll(".sidebar-toggle");

    toggle?.addEventListener("click", () => {

        if (sidebar.classList.contains("w-0")) {
            sidebar.classList.remove("w-0");
            sidebar.classList.add("w-72");
            toggle.classList.add("bi-x");
        } else {
            sidebar.classList.remove("w-72", "w-64");
            sidebar.classList.add("w-0");
            toggle.classList.remove("bi-x");
        }

    });

    categoryToggles.forEach((categoryToggle) => {
        categoryToggle.addEventListener("click", () => {
            const content = categoryToggle.nextElementSibling;
            const icon = categoryToggle.querySelector("i");

            if (!content?.classList.contains("sidebar-content")) {
                return;
            }

            const isHidden = content.classList.contains("hidden");
            content.classList.toggle("hidden", !isHidden);

            if (icon) {
                icon.classList.toggle("bi-plus-lg", !isHidden);
                icon.classList.toggle("bi-dash-lg", isHidden);
            }
        });
    });

});