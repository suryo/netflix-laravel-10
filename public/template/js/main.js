/**
 * Netflixku Template – Main JavaScript
 * Utilities shared across all pages.
 */

/* ── Navbar scroll shadow ───────────────────────── */
window.addEventListener("scroll", () => {
    const nav = document.getElementById("navbar");
    if (!nav) return;
    if (window.scrollY > 50) {
        nav.classList.add("shadow-2xl");
        nav.style.background = "rgba(10,10,10,0.98)";
    } else {
        nav.classList.remove("shadow-2xl");
        nav.style.background = "rgba(10,10,10,0.85)";
    }
});

/* ── Search toggle ──────────────────────────────── */
function toggleSearch() {
    const input = document.getElementById("search-input");
    if (!input) return;
    if (input.classList.contains("w-0")) {
        input.classList.remove("w-0", "opacity-0");
        input.classList.add("w-48", "opacity-100", "pl-2");
        input.focus();
    } else {
        input.classList.add("w-0", "opacity-0");
        input.classList.remove("w-48", "opacity-100", "pl-2");
    }
}

/* ── Mobile menu toggle ─────────────────────────── */
function toggleMobileMenu() {
    const menu = document.getElementById("mobile-menu");
    if (menu) menu.classList.toggle("hidden");
}

/* ── Copy to clipboard ──────────────────────────── */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text || window.location.href).then(() => {
        alert("Link berhasil disalin!");
    });
}

/* ── Admin sidebar toggle (mobile) ─────────────── */
function toggleAdminSidebar() {
    const sidebar = document.getElementById("admin-sidebar");
    if (sidebar) sidebar.classList.toggle("hidden");
}

/* ── Utility: format number ─────────────────────── */
function formatNumber(n) {
    if (n >= 1000000) return (n / 1000000).toFixed(1) + "M";
    if (n >= 1000) return (n / 1000).toFixed(1) + "K";
    return n;
}

/* ── City/Country Hub ────────────────────────────── */
function initHub({ containerId, searchId, cardClass, fetchUrl, panelId }) {
    const search = document.getElementById(searchId);
    const cards = document.querySelectorAll("." + cardClass);

    if (search) {
        search.addEventListener("input", () => {
            const term = search.value.toLowerCase();
            cards.forEach((card) => {
                const name = card.dataset.name?.toLowerCase() || "";
                card.closest("[data-item]").style.display = name.includes(term)
                    ? ""
                    : "none";
            });
        });
    }
}
