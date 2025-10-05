/* Admin products JS - single implementation
   Handles view/edit/delete/create modals, fetches, category toggles, and toasts.
*/

function showToast(message, type = "success") {
    let container = document.getElementById("toast-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "toast-container";
        container.className = "fixed top-6 right-6 z-50 space-y-2";
        document.body.appendChild(container);
    }
    const toast = document.createElement("div");
    toast.className = `px-4 py-2 rounded shadow text-sm text-white ${
        type === "success" ? "bg-green-600" : "bg-red-600"
    }`;
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}

async function fetchProduct(productId) {
    try {
        const res = await fetch(`/api/products/${productId}`);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return await res.json();
    } catch (err) {
        console.error("Failed to fetch product", err);
        showToast("Failed to load product data", "error");
        return null;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // View
    document.querySelectorAll(".view-product").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const id = this.dataset.id;
            const p = await fetchProduct(id);
            if (!p) return;
            document.getElementById("view-product-id").textContent = p.id ?? "";
            document.getElementById("view-product-name").textContent =
                p.name ?? "";
            document.getElementById("view-product-price").textContent =
                p.price !== undefined ? `$${Number(p.price).toFixed(2)}` : "";
            document.getElementById("view-product-stock").textContent =
                p.stock ?? "";
            document.getElementById("view-product-category").textContent =
                p.category ?? "";
            document.getElementById("view-product-description").textContent =
                p.description ?? "";
            document.getElementById("view-product-image-url").textContent =
                p.image_url ?? "";
            const img = document.getElementById("view-product-image");
            if (p.image_url) {
                img.src = p.image_url;
                img.alt = p.name ?? "";
                img.classList.remove("hidden");
            } else {
                img.src = "";
                img.alt = "";
                img.classList.add("hidden");
            }
            window.dispatchEvent(
                new CustomEvent("open-modal", { detail: "view-product-modal" })
            );
        });
    });

    // Edit
    document.querySelectorAll(".edit-product").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const id = this.dataset.id;
            const p = await fetchProduct(id);
            if (!p) return;
            const form = document.getElementById("edit-product-form");
            form.action = `/admin/products/${id}`;
            document.getElementById("edit_name").value = p.name ?? "";
            document.getElementById("edit_price").value = p.price ?? "";
            document.getElementById("edit_stock").value = p.stock ?? "";

            // populate category select/other
            const editSelect = document.getElementById("edit_category_select");
            const editOtherWrap = document.getElementById(
                "edit_category_other_wrap"
            );
            const editOther = document.getElementById("edit_category_other");
            const cat = p.category ?? "";
            let found = false;
            if (editSelect) {
                for (let i = 0; i < editSelect.options.length; i++) {
                    if (
                        editSelect.options[i].value.toLowerCase() ===
                        cat.toLowerCase()
                    ) {
                        editSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
            }
            if (!found) {
                if (editSelect) editSelect.selectedIndex = 0;
                if (editOther) {
                    editOther.value = cat;
                    editOtherWrap.classList.remove("hidden");
                }
            } else {
                if (editOther) {
                    editOther.value = "";
                    editOtherWrap.classList.add("hidden");
                }
            }

            document.getElementById("edit_description").value =
                p.description ?? "";
            document.getElementById("edit_image_url").value = p.image_url ?? "";
            window.dispatchEvent(
                new CustomEvent("open-modal", { detail: "edit-product-modal" })
            );
        });
    });

    // Delete
    document.querySelectorAll(".delete-product").forEach((btn) => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const form = document.getElementById("delete-product-form");
            form.action = `/admin/products/${id}`;
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: "delete-product-modal",
                })
            );
        });
    });

    // Create open
    const openCreate = document.getElementById("open-create-product");
    if (openCreate) {
        openCreate.addEventListener("click", function () {
            // If create select is empty (server didn't render options), try copying from edit select
            const createSelect = document.getElementById(
                "create_category_select"
            );
            const editSelect = document.getElementById("edit_category_select");
            if (
                createSelect &&
                editSelect &&
                createSelect.options.length <= 1
            ) {
                // copy options from editSelect
                for (let i = 0; i < editSelect.options.length; i++) {
                    const opt = editSelect.options[i];
                    const copy = document.createElement("option");
                    copy.value = opt.value;
                    copy.text = opt.text;
                    createSelect.add(copy);
                }
                const other = document.createElement("option");
                other.value = "__other";
                other.text = "Other...";
                createSelect.add(other);
            }
            const createForm = document.getElementById("create-product-form");
            if (createForm && !createForm.action) {
                try {
                    createForm.action = window.location.pathname.replace(
                        /\/admin\/products(\/.*)?$/,
                        "/admin/products"
                    );
                } catch (e) {}
            }
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: "create-product-modal",
                })
            );
        });
    }

    // category toggles
    const createSelect = document.getElementById("create_category_select");
    const createOtherWrap = document.getElementById(
        "create_category_other_wrap"
    );
    const createOther = document.getElementById("create_category_other");
    if (createSelect)
        createSelect.addEventListener("change", function () {
            if (this.value === "__other") {
                createOtherWrap.classList.remove("hidden");
                createOther.required = true;
            } else {
                createOtherWrap.classList.add("hidden");
                createOther.required = false;
                createOther.value = "";
            }
        });

    const editSelect = document.getElementById("edit_category_select");
    const editOtherWrap = document.getElementById("edit_category_other_wrap");
    const editOther = document.getElementById("edit_category_other");
    if (editSelect)
        editSelect.addEventListener("change", function () {
            if (this.value === "__other") {
                editOtherWrap.classList.remove("hidden");
                editOther.required = true;
            } else {
                editOtherWrap.classList.add("hidden");
                editOther.required = false;
                editOther.value = "";
            }
        });

    // show toasts from session (fallback: query params handled elsewhere)
    // no-op
});
/* Admin products JS
   - Handles View/Edit/Delete/Create modal flows
   - Robust fetch handling and form population
   - Category select + Other toggles
*/

function showToast(message, type = "success") {
    let container = document.getElementById("toast-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "toast-container";
        container.className = "fixed top-6 right-6 z-50 space-y-2";
        document.body.appendChild(container);
    }
    const toast = document.createElement("div");
    toast.className = `px-4 py-2 rounded shadow text-sm text-white ${
        type === "success" ? "bg-green-600" : "bg-red-600"
    }`;
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => {
        toast.remove();
    }, 3500);
}

async function fetchProduct(productId) {
    try {
        const res = await fetch(`/api/products/${productId}`);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return await res.json();
    } catch (err) {
        console.error("Failed to fetch product", err);
        showToast("Failed to load product data", "error");
        return null;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // view
    document.querySelectorAll(".view-product").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const productId = this.dataset.id;
            const product = await fetchProduct(productId);
            if (!product) return;
            document.getElementById("view-product-id").textContent =
                product.id ?? "";
            document.getElementById("view-product-name").textContent =
                product.name ?? "";
            document.getElementById("view-product-price").textContent =
                product.price !== undefined
                    ? `$${Number(product.price).toFixed(2)}`
                    : "";
            document.getElementById("view-product-stock").textContent =
                product.stock ?? "";
            document.getElementById("view-product-category").textContent =
                product.category ?? "";
            document.getElementById("view-product-description").textContent =
                product.description ?? "";
            document.getElementById("view-product-image-url").textContent =
                product.image_url ?? "";
            const img = document.getElementById("view-product-image");
            if (product.image_url) {
                img.src = product.image_url;
                img.alt = product.name ?? "Product image";
                img.classList.remove("hidden");
            } else {
                img.src = "";
                img.alt = "";
                img.classList.add("hidden");
            }
            window.dispatchEvent(
                new CustomEvent("open-modal", { detail: "view-product-modal" })
            );
        });
    });

    // edit
    document.querySelectorAll(".edit-product").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const productId = this.dataset.id;
            const product = await fetchProduct(productId);
            if (!product) return;
            const form = document.getElementById("edit-product-form");
            form.action = `/admin/products/${productId}`;
            document.getElementById("edit_name").value = product.name ?? "";
            document.getElementById("edit_price").value = product.price ?? "";
            document.getElementById("edit_stock").value = product.stock ?? "";

            // populate category select/other
            const editSelect = document.getElementById("edit_category_select");
            const editOtherWrap = document.getElementById(
                "edit_category_other_wrap"
            );
            const editOther = document.getElementById("edit_category_other");
            const cat = product.category ?? "";
            let found = false;
            if (editSelect) {
                for (let i = 0; i < editSelect.options.length; i++) {
                    if (
                        editSelect.options[i].value.toLowerCase() ===
                        cat.toLowerCase()
                    ) {
                        editSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
            }
            if (!found) {
                if (editSelect) editSelect.selectedIndex = 0;
                if (editOther) {
                    editOther.value = cat;
                    editOtherWrap.classList.remove("hidden");
                }
            } else {
                if (editOther) {
                    editOther.value = "";
                    editOtherWrap.classList.add("hidden");
                }
            }

            document.getElementById("edit_description").value =
                product.description ?? "";
            document.getElementById("edit_image_url").value =
                product.image_url ?? "";

            window.dispatchEvent(
                new CustomEvent("open-modal", { detail: "edit-product-modal" })
            );
        });
    });

    // delete
    document.querySelectorAll(".delete-product").forEach((btn) => {
        btn.addEventListener("click", function () {
            const productId = this.dataset.id;
            const form = document.getElementById("delete-product-form");
            form.action = `/admin/products/${productId}`;
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: "delete-product-modal",
                })
            );
        });
    });

    // create - open modal button
    const openCreate = document.getElementById("open-create-product");
    if (openCreate) {
        openCreate.addEventListener("click", function () {
            // ensure create form points to the store route if available
            const createForm = document.getElementById("create-product-form");
            if (createForm && !createForm.action) {
                try {
                    createForm.action = window.location.pathname.replace(
                        /\/admin\/products(\/.*)?$/,
                        "/admin/products"
                    );
                } catch (e) {}
            }
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: "create-product-modal",
                })
            );
        });
    }

    // category select toggles for create/edit
    const createSelect = document.getElementById("create_category_select");
    const createOtherWrap = document.getElementById(
        "create_category_other_wrap"
    );
    const createOther = document.getElementById("create_category_other");
    if (createSelect) {
        createSelect.addEventListener("change", function () {
            if (this.value === "__other") {
                createOtherWrap.classList.remove("hidden");
                createOther.required = true;
            } else {
                createOtherWrap.classList.add("hidden");
                createOther.required = false;
                createOther.value = "";
            }
        });
    }

    const editSelect = document.getElementById("edit_category_select");
    const editOtherWrap = document.getElementById("edit_category_other_wrap");
    const editOther = document.getElementById("edit_category_other");
    if (editSelect) {
        editSelect.addEventListener("change", function () {
            if (this.value === "__other") {
                editOtherWrap.classList.remove("hidden");
                editOther.required = true;
            } else {
                editOtherWrap.classList.add("hidden");
                editOther.required = false;
                editOther.value = "";
            }
        });
    }

    // show toast from query params (status/message)
    (function () {
        const params = new URLSearchParams(window.location.search);
        const status = params.get("status");
        const message = params.get("message");
        if (status && message) {
            showToast(
                decodeURIComponent(message),
                status === "success" ? "success" : "error"
            );
            params.delete("status");
            params.delete("message");
            const newUrl =
                window.location.pathname +
                (params.toString() ? `?${params.toString()}` : "");
            window.history.replaceState({}, document.title, newUrl);
        }
    })();
});
/**
 * Products management for admin panel
 * Handles search, filters, viewing, editing, and deleting products via modals.
 */

let searchTimeout;
function debounce(form, delay = 200) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        form.submit();
    }, delay);
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-product").forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.dataset.id;
            fetch(`/api/products/${productId}`)
                .then((response) => response.json())
                .then((product) => {
                    document.getElementById("view-product-id").textContent =
                        product.id;
                    document.getElementById("view-product-name").textContent =
                        product.name;
                    document.getElementById(
                        "view-product-price"
                    ).textContent = `$${product.price.toFixed(2)}`;
                    document.getElementById("view-product-stock").textContent =
                        product.stock;
                    document.getElementById(
                        "view-product-category"
                    ).textContent = product.category;
                    document.getElementById(
                        "view-product-description"
                    ).textContent = product.description;
                    document.getElementById(
                        "view-product-image-url"
                    ).textContent = product.image_url;
                    document.getElementById("view-product-image").src =
                        product.image_url;
                    document.getElementById("view-product-image").alt =
                        product.name;

                    window.dispatchEvent(
                        new CustomEvent("open-modal", {
                            detail: "view-product-modal",
                        })
                    );
                });
        });
    });

    document.querySelectorAll(".edit-product").forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.dataset.id;
            fetch(`/api/products/${productId}`)
                .then((response) => response.json())
                .then((product) => {
                    const form = document.getElementById("edit-product-form");
                    form.action = `/admin/products/${productId}`;
                    document.getElementById("edit_name").value = product.name;
                    document.getElementById("edit_price").value = product.price;
                    document.getElementById("edit_stock").value = product.stock;
                    document.getElementById("edit_category").value =
                        product.category;
                    document.getElementById("edit_description").value =
                        product.description;
                    document.getElementById("edit_image_url").value =
                        product.image_url;

                    window.dispatchEvent(
                        new CustomEvent("open-modal", {
                            detail: "edit-product-modal",
                        })
                    );
                });
        });
    });

    document.querySelectorAll(".delete-product").forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.dataset.id;
            const form = document.getElementById("delete-product-form");
            form.action = `/admin/products/${productId}`;
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: "delete-product-modal",
                })
            );
        });
    });
});
