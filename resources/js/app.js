import "./bootstrap";
import "./layout-loader";
import "./category-page";

const updateCartCount = async () => {
	try {
		const response = await fetch("/cart-summary.json", {
			headers: { "X-Requested-With": "XMLHttpRequest" },
		});

		if (!response.ok) {
			return;
		}

		const payload = await response.json();
		const count = Math.max(0, Number(payload?.item_count ?? 0));

		document
			.querySelectorAll("[data-cart-count], .icon-badge")
			.forEach((badge) => {
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

const fetchHtmlDocument = async (url) => {
	const response = await fetch(url, {
		headers: { "X-Requested-With": "XMLHttpRequest" },
	});

	if (!response.ok) {
		throw new Error(`Failed to load ${url}`);
	}

	const html = await response.text();
	return new DOMParser().parseFromString(html, "text/html");
};

const refreshProductContent = async () => {
	const mainSection = document.querySelector(".main-product-section");
	const recommended = document.querySelector(".recomended-cards");

	if (!mainSection && !recommended) {
		return;
	}

	const doc = await fetchHtmlDocument(window.location.href);

	if (mainSection) {
		const freshMain = doc.querySelector(".main-product-section");
		if (freshMain) {
			mainSection.replaceWith(freshMain);
		}
	}

	if (recommended) {
		const freshRecommended = doc.querySelector(".recomended-cards");
		if (freshRecommended) {
			recommended.replaceWith(freshRecommended);
		}
	}
};

const refreshCartContent = async () => {
	const cartContainer = document.querySelector(".cart-container");

	if (!cartContainer) {
		return;
	}

	const doc = await fetchHtmlDocument(window.location.href);
	const freshContainer = doc.querySelector(".cart-container");

	if (freshContainer) {
		cartContainer.replaceWith(freshContainer);
		window.bindAjaxForms?.();
		window.bindAutoSubmitInputs?.();
	}
};

const handleAjaxSuccess = async () => {
	await updateCartCount();

	if (document.querySelector(".cart-page")) {
		await refreshCartContent();
		return;
	}

	if (typeof window.refreshCategoryContent === "function") {
		await window.refreshCategoryContent(window.location.href);
		return;
	}

	await refreshProductContent();
};

const bindAutoSubmitInputs = () => {
	document.querySelectorAll("input[data-auto-submit]").forEach((input) => {
		if (input.dataset.autoSubmitBound === "true") {
			return;
		}

		input.dataset.autoSubmitBound = "true";

		input.addEventListener("change", () => {
			const form = input.closest("form");

			if (form) {
				form.requestSubmit();
			}
		});
	});
};

const bindAjaxForms = () => {
	document.querySelectorAll("form[data-ajax-form]").forEach((form) => {
		if (form.dataset.ajaxBound === "true") {
			return;
		}

		form.dataset.ajaxBound = "true";

		form.addEventListener("submit", async (event) => {
			event.preventDefault();

			const submitButton = form.querySelector("button[type=submit]");
			submitButton?.setAttribute("disabled", "true");

			try {
				const formData = new FormData(form);
				const response = await fetch(form.action, {
					method: (form.getAttribute("method") || "POST").toUpperCase(),
					headers: { "X-Requested-With": "XMLHttpRequest" },
					body: formData,
				});

				if (!response.ok) {
					throw new Error("Request failed");
				}

				await handleAjaxSuccess();
			} catch (error) {
				console.error(error);
			} finally {
				submitButton?.removeAttribute("disabled");
				bindAjaxForms();
			}
		});
	});
};

window.bindAjaxForms = bindAjaxForms;
window.bindAutoSubmitInputs = bindAutoSubmitInputs;

document.addEventListener("DOMContentLoaded", () => {
	bindAjaxForms();
	bindAutoSubmitInputs();
});
