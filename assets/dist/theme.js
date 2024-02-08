"use strict";

jQuery(document).ready(function ($) {
  var swatchesLabels = $('.single-product .product-swatches .product-swatches__label');
  var swatchesLabelsContentProduct = $('.archive .product .product-swatches .product-swatches__label');
  var defaultVariations = $('.variations select');
  var resetLink = '.reset_variations';
  var triggerWooAttributeSelectChange = function triggerWooAttributeSelectChange(e) {
    var currentTerm = $(e.currentTarget);
    var value = currentTerm.data('value');
    var taxonomy = currentTerm.data('attribute-name');
    var siblingsTerms = currentTerm.parent().find(swatchesLabels);
    if (!currentTerm.hasClass('selected')) {
      $("#".concat(taxonomy)).val(value);
      $("#".concat(taxonomy)).trigger('change');
      siblingsTerms.removeClass('selected');
      currentTerm.addClass('selected');
    }
  };
  var swatchesInit = function swatchesInit() {
    $.each(defaultVariations, function (defaultVariationIndex, defaultVariation) {
      var currentTerm = $(defaultVariation);
      var currentTermValue = currentTerm.val();
      console.log(currentTermValue);
      if (currentTermValue) {
        $(".product-swatches__label[data-value=".concat(currentTermValue, "]")).addClass('selected');
      }
    });
  };
  var resetVariation = function resetVariation() {
    swatchesLabels.removeClass('selected');
  };
  var contentProductColorPreselect = function contentProductColorPreselect(e) {
    e.stopPropagation();
    e.preventDefault();
    var currentTerm = $(e.currentTarget);
    var siblingsTerms = currentTerm.parent().find(swatchesLabelsContentProduct);
    var productUrlElement = currentTerm.closest('.woocommerce-loop-product__link');
    var productUrl = currentTerm.closest('.woocommerce-loop-product__link').attr('href');
    var colorSlug = currentTerm.data('value');
    if (!currentTerm.hasClass('selected')) {
      siblingsTerms.removeClass('selected');
      currentTerm.addClass('selected');

      // Add query arg to url

      var url = new URL(productUrl);
      url.searchParams.delete('productColor');
      url.searchParams.append('productColor', colorSlug);
      productUrlElement.attr('href', url);
    }
  };
  swatchesInit();
  $('body').on('click', resetLink, resetVariation);
  swatchesLabels.on('click', triggerWooAttributeSelectChange);
  swatchesLabelsContentProduct.on('click', contentProductColorPreselect);
});
"use strict";

jQuery(document).ready(function ($) {
  // Mobile navigation

  $(".menu-toggle").click(function () {
    $("#primary-menu").fadeToggle();
    $(this).toggleClass('menu-open');
  });
  // Sub Menu Trigger

  $("#primary-menu li.menu-item-has-children > a").after('<span class="sub-menu-trigger"><svg xmlns="http://www.w3.org/2000/svg" width="18.816" height="11.628" viewBox="0 0 18.816 11.628"><path id="Path_1" data-name="Path 1" d="M922,78.5l8.229,8.433,8.454-8.433" transform="translate(-920.927 -77.438)" fill="none" stroke="#fff" stroke-width="3"/></svg></span>');
  $(".sub-menu-trigger").click(function () {
    $(this).parent().toggleClass('sub-menu-open');
    $(this).siblings(".sub-menu").slideToggle();
  });

  // WooCommerce Quantity

  $('form.cart').on('click', 'button.plus, button.minus', function () {
    var qty = $(this).closest('form.cart').find('.qty');
    var val = parseFloat(qty.val());
    var max = parseFloat(qty.attr('max'));
    var min = parseFloat(qty.attr('min'));
    var step = parseFloat(qty.attr('step'));
    if ($(this).is('.plus')) {
      if (max && max <= val) {
        qty.val(max);
      } else {
        qty.val(val + step);
      }
    } else {
      if (min && min >= val) {
        qty.val(min);
      } else if (val > 1) {
        qty.val(val - step);
      }
    }
  });
});