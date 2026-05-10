const injectFragment = async (selector, url) => {
    const target = document.querySelector(selector);

    if (!target) {
        return;
    }

    try {
        const response = await fetch(url, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        if (!response.ok) {
            throw new Error(`Failed to load ${url}`);
        }

        target.innerHTML = await response.text();
    } catch (error) {
        console.error(error);
    }
};

const applyHeaderNavigationLinks = () => {
    const navLinks = document.querySelectorAll("[data-header-nav]");

    if (!navLinks.length) {
        return;
    }

    const destinations = {
        trending: "/category-template.html?category=trending",
        "new-arrivals": "/category-template.html?category=new-arrivals",
        "coming-soon": "/category-template.html?category=coming-soon",
        sale: "/category-template.html?category=sale",
    };

    navLinks.forEach((link) => {
        const key = String(link.getAttribute("data-header-nav") ?? "").trim();
        const href = destinations[key];

        if (href) {
            link.setAttribute("href", href);
        }
    });
};

const injectCategoriesDropdown = async () => {
    const dropdown = document.querySelector("[data-genres-dropdown]");

    if (!dropdown) {
        return;
    }

    try {
        const response = await fetch("/genres-menu.json", {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        if (!response.ok) {
            throw new Error("Failed to load categories menu");
        }

        const categories = await response.json();

        if (!Array.isArray(categories) || categories.length === 0) {
            dropdown.innerHTML =
                '<li><a href="/category-template.html">All Books</a></li>';
            return;
        }

        dropdown.innerHTML = categories
            .map((category) => {
                const name = String(category.name ?? "").trim();
                const slug = encodeURIComponent(
                    String(category.slug ?? "").trim(),
                );

                if (!name || !slug) {
                    return "";
                }

                return `<li><a href="/category-template.html?category=${slug}">${name}</a></li>`;
            })
            .filter(Boolean)
            .join("");
    } catch (error) {
        console.error(error);
    }
};

const injectCartCount = async () => {
    const badges = document.querySelectorAll("[data-cart-count], .icon-badge");

    if (!badges.length) {
        return;
    }

    try {
        const response = await fetch("/cart-summary.json", {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        if (!response.ok) {
            throw new Error("Failed to load cart summary");
        }

        const payload = await response.json();
        const count = Math.max(0, Number(payload?.item_count ?? 0));

        badges.forEach((badge) => {
            badge.textContent = String(count);
            badge.setAttribute(
                "aria-label",
                `${count} item${count === 1 ? "" : "s"} in cart`,
            );
        });
    } catch (error) {
        console.error(error);
    }
};

const hydrateHeaderSearch = () => {
    const input = document.querySelector(
        '.header-search input[name="q"], .header-search .search-input',
    );

    if (!input) {
        return;
    }

    const params = new URLSearchParams(window.location.search);
    const q = (params.get("q") ?? "").trim();

    if (q) {
        input.value = q;
    }
};

document.addEventListener("DOMContentLoaded", async () => {
    await Promise.all([
        injectFragment("[data-site-header]", "/fragments/header.html"),
        injectFragment("[data-site-footer]", "/fragments/footer.html"),
    ]);

    applyHeaderNavigationLinks();
    await injectCategoriesDropdown();
    await injectCartCount();
    hydrateHeaderSearch();
});
