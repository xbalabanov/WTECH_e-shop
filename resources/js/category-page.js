const initCategoryPage = () => {
    const filterForm = document.getElementById("category-filter-form");
    const minRange = document.getElementById("filter-min-price");
    const maxRange = document.getElementById("filter-max-price");
    const minLabel = document.getElementById("price-min-label");
    const maxLabel = document.getElementById("price-max-label");
    const resetPriceBtn = document.getElementById("filter-price-reset-btn");
    const sortForm = document.querySelector(".category-main-sort-container form");

    if (!filterForm && !sortForm) {
        return;
    }

    const collapsibleGroups = Array.from(
        document.querySelectorAll(".filter-group"),
    ).filter((group) => group.querySelector(".filter-group-header"));

    const applyCollapseState = (group, collapsed) => {
        group.classList.toggle("is-collapsed", collapsed);

        Array.from(group.children).forEach((child) => {
            if (!child.classList.contains("filter-group-header")) {
                child.hidden = collapsed;
            }
        });

        group
            .querySelector(".filter-group-header")
            ?.setAttribute("aria-expanded", String(!collapsed));
    };

    const buildCategoryUrl = (form) => {
        const url = new URL(form.action, window.location.origin);
        const params = new URLSearchParams();

        Array.from(new FormData(form).entries()).forEach(([key, value]) => {
            if (String(value).trim() !== "") {
                params.append(key, value);
            }
        });

        url.search = params.toString();
        return url.toString();
    };

    const fetchCategoryContent = async (url, { pushState } = { pushState: true }) => {
        const response = await fetch(url, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        if (!response.ok) {
            throw new Error("Failed to load category results");
        }

        const html = await response.text();
        const doc = new DOMParser().parseFromString(html, "text/html");

        const freshContent = doc.querySelector(".category-main-content");
        const currentContent = document.querySelector(".category-main-content");

        if (freshContent && currentContent) {
            currentContent.replaceWith(freshContent);
        }

        if (pushState) {
            window.history.pushState({}, "", url);
        }

        window.initCategoryTemplate?.();
        window.bindAjaxForms?.();
    };

    const submitCategoryForm = async (form) => {
        if (!form) {
            return;
        }

        const url = buildCategoryUrl(form);
        await fetchCategoryContent(url);
    };

    window.refreshCategoryContent = async (url) => {
        await fetchCategoryContent(url, { pushState: false });
    };

    window.initCategoryTemplate = () => {
        const select = document.getElementById("sort-select");

        if (select && !select.dataset.bound) {
            select.dataset.bound = "true";
            select.addEventListener("change", () => submitCategoryForm(sortForm));
        }

        const moreBtn = document.getElementById("category-more-btn");
        const productsContainer = document.getElementById(
            "category-products-container",
        );
        const pagerPages = document.getElementById("category-pager-pages");

        if (moreBtn && productsContainer && pagerPages && !moreBtn.dataset.bound) {
            moreBtn.dataset.bound = "true";
            moreBtn.addEventListener("click", async () => {
                const nextUrl = moreBtn.dataset.nextUrl;

                if (!nextUrl) {
                    return;
                }

                moreBtn.disabled = true;

                try {
                    const response = await fetch(nextUrl, {
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                    });

                    if (!response.ok) {
                        throw new Error("Failed to load next page");
                    }

                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, "text/html");

                    const newRows = doc.querySelectorAll(
                        "#category-products-container .category-main-products-row",
                    );
                    newRows.forEach((row) => productsContainer.appendChild(row));

                    const newPagerPages = doc.getElementById("category-pager-pages");
                    if (newPagerPages) {
                        pagerPages.innerHTML = newPagerPages.innerHTML;
                    }

                    const newMoreBtn = doc.getElementById("category-more-btn");
                    const newNextUrl = newMoreBtn?.dataset?.nextUrl ?? "";

                    if (newNextUrl) {
                        moreBtn.dataset.nextUrl = newNextUrl;
                        moreBtn.disabled = false;
                    } else {
                        moreBtn.dataset.nextUrl = "";
                        moreBtn.style.display = "none";
                    }
                } catch (error) {
                    console.error(error);
                    moreBtn.disabled = false;
                }
            });
        }
    };

    if (collapsibleGroups.length) {
        collapsibleGroups.forEach((group, index) => {
            const header = group.querySelector(".filter-group-header");
            const hasSelectedOption = !!group.querySelector(
                'input[type="checkbox"]:checked',
            );
            const startsCollapsed = !hasSelectedOption && index !== 0;

            applyCollapseState(group, startsCollapsed);

            header?.addEventListener("click", () => {
                const isCollapsed = group.classList.contains("is-collapsed");

                collapsibleGroups.forEach((otherGroup) => {
                    if (otherGroup !== group) {
                        applyCollapseState(otherGroup, true);
                    }
                });

                applyCollapseState(group, !isCollapsed);
            });
        });
    }

    if (filterForm) {
        filterForm
            .querySelectorAll('input[type="checkbox"]')
            .forEach((checkbox) => {
                checkbox.addEventListener("change", () =>
                    submitCategoryForm(filterForm),
                );
            });
    }

    if (minRange && maxRange && minLabel && maxLabel && filterForm) {
        const syncLabels = () => {
            let min = Number(minRange.value);
            let max = Number(maxRange.value);

            if (min > max) {
                [min, max] = [max, min];
                minRange.value = String(min);
                maxRange.value = String(max);
            }

            minLabel.textContent = `${min}€`;
            maxLabel.textContent = `${max}€`;
        };

        minRange.addEventListener("input", syncLabels);
        maxRange.addEventListener("input", syncLabels);
        minRange.addEventListener("change", () => submitCategoryForm(filterForm));
        maxRange.addEventListener("change", () => submitCategoryForm(filterForm));

        resetPriceBtn?.addEventListener("click", () => {
            minRange.value = minRange.min;
            maxRange.value = maxRange.max;
            syncLabels();
            submitCategoryForm(filterForm);
        });

        syncLabels();
    }

    window.initCategoryTemplate();
};

document.addEventListener("DOMContentLoaded", initCategoryPage);
