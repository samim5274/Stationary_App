$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ✅ Your correct route
    const updateUrl = "{{ route('cart.updateQty') }}"; // /sale/cart/set-qty

    // -----------------------------
    // Plus / Minus Click
    // -----------------------------
    $(document).on('click', '.btn-plus, .btn-minus', function () {
        var id = $(this).data('id');
        var input = $('input.qty-input[data-id="' + id + '"]');
        var currentQty = parseInt(input.val()) || 1;
        var newQty = currentQty;

        if ($(this).hasClass('btn-plus')) {
            newQty = currentQty + 1;
        } else if ($(this).hasClass('btn-minus') && currentQty > 1) {
            newQty = currentQty - 1;
        }

        if (newQty === currentQty) return;
        updateQuantity(id, newQty, input);
    });

    // -----------------------------
    // Manual typing (Live update)
    // -----------------------------
    let typingTimer = null;
    $(document).on('input', '.qty-input', function () {
        var input = $(this);
        var id = input.data('id');
        var newQty = parseInt(input.val());

        clearTimeout(typingTimer);

        // debounce typing
        typingTimer = setTimeout(function () {
            if (isNaN(newQty) || newQty < 1) {
                input.val(1);
                newQty = 1;
            }
            updateQuantity(id, newQty, input);
        }, 400);
    });

    // -----------------------------
    // Core AJAX update
    // -----------------------------
    function updateQuantity(id, newQty, input) {
        input.prop('disabled', true);

        $.ajax({
            url: updateUrl,
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({ id: id, quantity: newQty }),
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    input.val(response.quantity);

                    // ✅ Update item subtotal (only inside cart item card)
                    var card = input.closest('.cart-item-body');
                    var price = parseFloat(card.find('[data-price]').data('price')) || 0;
                    var subtotal = price * response.quantity;
                    card.find('.item-subtotal').text('৳' + subtotal.toFixed(2));

                    // ✅ Update totals
                    updateCartTotal();
                } else {
                    alert(response.message || 'Update failed');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                let msg = 'Something went wrong!';
                try {
                    const r = JSON.parse(xhr.responseText);
                    msg = r.message || r.error || msg;
                } catch(e) {}
                alert(msg);
            },
            complete: function () {
                input.prop('disabled', false);
            }
        });
    }

    // -----------------------------
    // Total update (ONLY items)
    // -----------------------------
    function updateCartTotal() {
        let total = 0;

        $('.cart-item-body').each(function () {
            const price = parseFloat($(this).find('[data-price]').data('price')) || 0;
            const qty = parseInt($(this).find('.qty-input').val()) || 0;
            total += price * qty;
        });

        $('#cart-subtotal').text(total.toFixed(0));
        $('#cart-total').text(total.toFixed(0));
        $('#cart-total-input').val(Math.round(total));
    }

});
