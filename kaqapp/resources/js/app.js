import '../css/app.css'
import 'bootstrap-icons/font/bootstrap-icons.css'


document.addEventListener("DOMContentLoaded", () => {

    const toggle = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");

    toggle?.addEventListener("click", () => {

        if (sidebar.classList.contains("w-0")) {
            sidebar.classList.remove("w-0");
            sidebar.classList.add("w-64");
            toggle.classList.add("bi-x");
        } else {
            sidebar.classList.remove("w-64");
            sidebar.classList.add("w-0");
            toggle.classList.remove("bi-x");
        }

    });

});