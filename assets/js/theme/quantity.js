(function ($) {
    function updateQuantity() {
        $('.quantity').off('click', 'button.plus, button.minus');
        $('.quantity').on('click', 'button.plus, button.minus', function () {
            var qty = $(this).closest('.quantity').find('.qty');
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr('max'));
            var min = parseFloat(qty.attr('min'));
            var step = parseFloat(qty.attr('step'));
            if ($(this).is('.plus')) {
                if (max && (max <= val)) {
                    qty.val(max);
                } else {
                    qty.val(val + step).trigger('change');
                }
            } else {
                if (min && (min >= val)) {
                    qty.val(min);
                } else if (val > 1) {
                    qty.val(val - step).trigger('change');
                }
            }
        });
    }

    $(document).ready(function () {
        updateQuantity();

        // Re-bind the quantity buttons after the cart is updated
        $(document.body).on('updated_cart_totals', function () {
            updateQuantity();
        });
    });
})(jQuery);
