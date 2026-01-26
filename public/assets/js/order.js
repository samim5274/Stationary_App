function calculateAmount() {
    const subtotalText = (document.getElementById('cart-total')?.innerText || '0').replace(/,/g, '');
    const subtotal = parseFloat(subtotalText) || 0;

    const vatPercent = parseFloat(document.getElementById('num4')?.value) || 0;
    const discount   = parseFloat(document.getElementById('num3')?.value) || 0;
    const pay        = parseFloat(document.getElementById('num2')?.value) || 0;

    const confirmBtn   = document.getElementById('confirmBtn');
    const result       = document.getElementById('result');
    const customerInfo = document.getElementById('customer-info');

    // helper: reset + set result color (Tailwind)
    function setResultColor(type) {
        if (!result) return;

        // remove both (light + dark optional)
        result.classList.remove(
            "text-red-500", "text-green-500",
            "dark:text-red-400", "dark:text-green-400"
        );

        if (type === "red") {
            result.classList.add("text-red-500", "dark:text-red-400");
        } else if (type === "green") {
            result.classList.add("text-green-500", "dark:text-green-400");
        }
    }

    // Validation
    if (vatPercent < 0 || discount < 0 || pay < 0) {
        if (result) result.innerText = "Negative values are not allowed.";
        setResultColor("red");
        if (confirmBtn) confirmBtn.disabled = true;
        // if (customerInfo) customerInfo.classList.remove("hidden"); // optional
        return;
    }

    // Calculate VAT and grand total
    const vatAmount = (subtotal * vatPercent) / 100;
    const grandTotal = Math.max(0, subtotal + vatAmount - discount);

    // Update VAT & Discount display
    const vatEl = document.getElementById('vat-amount');
    const discEl = document.getElementById('discount-amount');
    const subEl = document.getElementById('cart-subtotal');

    if (vatEl)  vatEl.innerText  = vatAmount.toFixed(2);
    if (discEl) discEl.innerText = discount.toFixed(2);
    if (subEl)  subEl.innerText  = grandTotal.toFixed(2);

    // Determine due or return
    const balance = pay - grandTotal;
    let message = "";

    if (balance > 0) {
        message = "Return: ৳" + balance.toFixed(2) + "/-";
        setResultColor("green");
        if (confirmBtn) confirmBtn.disabled = false;
        // if (customerInfo) customerInfo.classList.add("hidden");
    } else if (balance < 0) {
        message = "Due: ৳" + Math.abs(balance).toFixed(2) + "/-";
        setResultColor("red");
        if (confirmBtn) confirmBtn.disabled = false;
        // if (customerInfo) customerInfo.classList.remove("hidden");
    } else {
        message = "Fully Paid: ৳0.00/-";
        setResultColor("green");
        if (confirmBtn) confirmBtn.disabled = false;
        // if (customerInfo) customerInfo.classList.add("hidden");
    }

    if (result) result.innerText = message;
}
