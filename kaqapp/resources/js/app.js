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

    const hideToast = (toast) => {
        toast.classList.remove("opacity-100", "translate-y-0");
        toast.classList.add("opacity-0", "-translate-y-2");

        window.setTimeout(() => {
            toast.remove();
        }, 200);
    };

    const initToast = (toast) => {
        requestAnimationFrame(() => {
            toast.classList.remove("opacity-0", "-translate-y-2");
            toast.classList.add("opacity-100", "translate-y-0");
        });

        const closeButton = toast.querySelector("[data-toast-close]");
        closeButton?.addEventListener("click", () => hideToast(toast));

        const autoclose = Number(toast.getAttribute("data-autoclose") || 0);
        if (autoclose > 0) {
            window.setTimeout(() => hideToast(toast), autoclose);
        }
    };

    const getToastContainer = () => {
        let container = document.getElementById("toast-container");

        if (!container) {
            container = document.createElement("div");
            container.id = "toast-container";
            container.className = "pointer-events-none fixed top-4 right-4 z-50 flex w-[calc(100%-2rem)] max-w-sm flex-col gap-2 sm:w-full";
            document.body.appendChild(container);
        }

        return container;
    };

    const createToastElement = ({ type = "success", message = "", autoclose = 4000 }) => {
        const isError = type === "error";
        const wrapper = document.createElement("div");

        wrapper.setAttribute("data-toast", "");
        wrapper.setAttribute("data-autoclose", String(autoclose));
        wrapper.className = "pointer-events-auto w-full max-w-sm border border-black bg-black text-white shadow-sm transition-all duration-200 opacity-0 -translate-y-2";
        wrapper.setAttribute("role", "alert");
        wrapper.setAttribute("aria-live", "assertive");

        wrapper.innerHTML = `
            <div class="flex items-start gap-3 p-3 align-middle">
                <i class="bi ${isError ? "bi-exclamation-triangle" : "bi-check-circle"} text-sm mt-0.5"></i>
                <p class="text-xs leading-5 flex-1"></p>
                <button type="button" class="text-white hover:text-brand" data-toast-close aria-label="Close">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;

        const textNode = wrapper.querySelector("p");
        if (textNode) {
            textNode.textContent = message;
        }

        return wrapper;
    };

    const showToast = ({ type = "success", message = "", autoclose = 4000 }) => {
        if (!message) {
            return;
        }

        const container = getToastContainer();
        const toast = createToastElement({ type, message, autoclose });
        container.appendChild(toast);
        initToast(toast);
    };

    window.kaqToast = {
        show: showToast,
    };

    const toasts = document.querySelectorAll("[data-toast]");

    toasts.forEach((toast) => {
        initToast(toast);
    });

});