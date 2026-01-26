$(function () {
    // ---- CSRF ----
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }
    });

    // ---- URL (from blade) ----
    const updateUrl = window.CART_UPDATE_URL;
    if (!updateUrl) {
        console.error("CART_UPDATE_URL missing!");
        return;
    }

    // ---- Helpers ----
    function clampQty(v) {
        const n = parseInt(v, 10);
        if (isNaN(n) || n < 1) return 1;
        return n;
    }

    function setMsg(id, msg, type = "info") {
        const el = $("#qty-msg-" + id);
        if (!el.length) return;

        el.text(msg || "");
        el.removeClass("text-red-500 text-emerald-600 dark:text-red-400 dark:text-emerald-400");

        if (type === "error") el.addClass("text-red-500 dark:text-red-400");
        if (type === "success") el.addClass("text-emerald-600 dark:text-emerald-400");
    }

    function updateRowSubtotal(row, qty) {
        const price = parseFloat(row.find("[data-price]").data("price")) || 0;
        const subtotal = Math.round(price * qty);
        row.find(".item-subtotal").text("৳" + subtotal + "/-");
    }

    function updateCartTotal() {
        let total = 0;

        $('tr[data-cart-row="1"]').each(function () {
            const row = $(this);
            const price = parseFloat(row.find("[data-price]").data("price")) || 0;
            const qty = clampQty(row.find(".qty-input").val());
            total += price * qty;
        });

        total = Math.round(total);
        $("#cart-subtotal").text(total);
        $("#cart-total").text(total);
        $("#cart-total-input").val(total);
    }

    // ---- Core AJAX ----
    function updateQuantity(id, qty, input) {
        qty = clampQty(qty);

        // prevent spamming same input
        if (input.data("loading") === 1) return;

        input.data("loading", 1);
        input.prop("disabled", true);
        setMsg(id, "Updating...", "info");

        $.ajax({
            url: updateUrl,
            type: "POST",
            dataType: "json",
            // ✅ form-data style (most compatible)
            data: { id: id, quantity: qty },

            success: function (res) {
                if (res && res.status === "success") {
                    const finalQty = clampQty(res.quantity ?? qty);
                    input.val(finalQty);

                    const row = input.closest("tr");
                    updateRowSubtotal(row, finalQty);
                    updateCartTotal();

                    setMsg(id, "Updated", "success");
                    setTimeout(() => setMsg(id, ""), 800);
                } else {
                    setMsg(id, (res && res.message) ? res.message : "Update failed", "error");
                }
            },

            error: function (xhr) {
                let msg = "Something went wrong!";
                try {
                    const r = JSON.parse(xhr.responseText);
                    msg = r.message || r.error || msg;
                } catch (e) {}
                setMsg(id, msg, "error");
                console.error(xhr.responseText);
            },

            complete: function () {
                input.data("loading", 0);
                input.prop("disabled", false);
            }
        });
    }

    // ---- Plus / Minus ----
    $(document).on("click", ".btn-plus, .btn-minus", function () {
        const id = $(this).data("id");
        const input = $('.qty-input[data-id="' + id + '"]');
        if (!input.length) return;

        const current = clampQty(input.val());
        let next = current;

        if ($(this).hasClass("btn-plus")) next = current + 1;
        if ($(this).hasClass("btn-minus")) next = Math.max(1, current - 1);

        if (next === current) return;
        updateQuantity(id, next, input);
    });

    // ---- Typing (debounce per input) ----
    $(document).on("input", ".qty-input", function () {
        const input = $(this);
        const id = input.data("id");

        clearTimeout(input.data("typingTimer"));
        input.data("typingTimer", setTimeout(function () {
            const qty = clampQty(input.val());
            input.val(qty);
            updateQuantity(id, qty, input);
        }, 400));
    });

    // ---- On blur force update ----
    $(document).on("blur", ".qty-input", function () {
        const input = $(this);
        const id = input.data("id");
        const qty = clampQty(input.val());
        input.val(qty);
        updateQuantity(id, qty, input);
    });
});
