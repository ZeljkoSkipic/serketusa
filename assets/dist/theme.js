"use strict";

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
        if (max && max <= val) {
          qty.val(max);
        } else {
          qty.val(val + step).trigger('change');
        }
      } else {
        if (min && min >= val) {
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
"use strict";

jQuery(document).ready(function ($) {
  var swatchesLabels = $(".single-product .summary .product-swatches .product-swatches__label");
  var swatchesLabelsContentProduct = $(".archive .product .product-swatches .product-swatches__label");
  var swatchesLabelsContentProductCatalog = $(".archive .product .product-swatches-catalog .product-swatches-catalog__label");
  var swatchesLabelsContentProductCatalogRelated = $(".related .product .product-swatches-catalog .product-swatches-catalog__label");
  var swatchesLabelsContentRelated = $(".related .product .product-swatches .product-swatches__label");
  var swatchesCatalog = $(".product-swatches-catalog .product-swatches-catalog__label");
  var defaultVariations = $(".variations select");
  var resetLink = ".reset_variations";
  var triggerWooAttributeSelectChange = function triggerWooAttributeSelectChange(e) {
    var currentTerm = $(e.currentTarget);
    var value = currentTerm.data("value");
    var taxonomy = currentTerm.data("attribute-name");
    var siblingsTerms = currentTerm.parent().find(swatchesLabels);
    if (!currentTerm.hasClass("selected")) {
      $("#".concat(taxonomy)).val(value);
      $("#".concat(taxonomy)).trigger("change");
      siblingsTerms.removeClass("selected");
      currentTerm.addClass("selected");
    }
  };

  // Remove not available available

  var disableAttributes = function disableAttributes() {
    setTimeout(function () {
      var optionsValues = [];
      var defaultVariations = $(".variations select");
      var swatchesLabels = $(".single-product .summary .product-swatches .product-swatches__label");
      var options = defaultVariations.find("option");
      Object.keys(options).forEach(function (index) {
        optionsValues.push(options[index].value);
      });
      var optionValuesFormated = optionsValues.filter(function (option) {
        return option != "" && option !== undefined;
      });
      $.each(swatchesLabels, function (index, label) {
        if ($.inArray($(label).attr("data-value"), optionValuesFormated) === -1) {
          $(label).addClass("disabled");
        } else {
          $(label).removeClass("disabled");
        }
      });
    }, 200);
  };
  var swatchesInit = function swatchesInit() {
    $.each(defaultVariations, function (defaultVariationIndex, defaultVariation) {
      var currentTerm = $(defaultVariation);
      var currentTermValue = currentTerm.val();
      if (currentTermValue) {
        $(".product-swatches__label[data-value=".concat(currentTermValue, "]")).addClass("selected");
      }
    });
    disableAttributes();
  };
  var resetVariation = function resetVariation() {
    swatchesLabels.removeClass("selected");
  };
  var contentProductColorPreselect = function contentProductColorPreselect(e) {
    e.stopPropagation();
    e.preventDefault();
    var currentTerm = $(e.currentTarget);
    var siblingsTerms = currentTerm.parent().find(".product-swatches__label");
    var productUrlElement = currentTerm.closest(".woocommerce-loop-product__link");
    var selectOptions = productUrlElement.parent().find(".product_type_variable.add_to_cart_button");
    var productUrl = currentTerm.closest(".woocommerce-loop-product__link").attr("href");
    var colorSlug = currentTerm.data("value");
    var productImageUrl = currentTerm.data("image-url");
    var productImageSrcset = currentTerm.data("image-src");
    if (!currentTerm.hasClass("selected")) {
      siblingsTerms.removeClass("selected");
      currentTerm.addClass("selected");

      // Add query arg to url

      var url = new URL(productUrl);
      url.searchParams.delete("productColor");
      url.searchParams.append("productColor", colorSlug);
      productUrlElement.attr("href", url);
      productUrlElement.find("img").attr("src", productImageUrl);
      productUrlElement.find("img").attr("srcset", productImageSrcset);
      selectOptions.attr("href", url);
    }
  };
  var catalogSwatchesInit = function catalogSwatchesInit() {
    var url = new URL(window.location.href);
    if (url.searchParams.get("productColor") && $(".product-template-single-product-catalog").length) {
      $(".summary span[data-color-name=".concat(url.searchParams.get("productColor"), "].product-swatches-catalog__label")).trigger("click");
    }
  };
  var contentProductColorPreselectCatalog = function contentProductColorPreselectCatalog(e) {
    e.stopPropagation();
    e.preventDefault();
    var currentTerm = $(e.currentTarget);
    var siblingsTerms = currentTerm.parent().find(".product-swatches-catalog__label");
    var productUrlElement = currentTerm.closest(".woocommerce-loop-product__link");
    var selectOptions = productUrlElement.parent().find(".button");
    var productUrl = currentTerm.closest(".woocommerce-loop-product__link").attr("href");
    var colorSlug = currentTerm.data("color-name");
    var imageUrl = currentTerm.data("image-url");
    var imageSrcset = currentTerm.data("image-srcset");
    var defaultImageUrl = currentTerm.data("default-image-url");
    var DefaultImageSrcset = currentTerm.data("default-image-srcset");
    if (!currentTerm.hasClass("selected")) {
      siblingsTerms.removeClass("selected");
      currentTerm.addClass("selected");

      // Add query arg to url

      var url = new URL(productUrl);
      url.searchParams.delete("productColor");
      url.searchParams.append("productColor", colorSlug);
      productUrlElement.attr("href", url);
      productUrlElement.find("img").attr("src", imageUrl ? imageUrl : defaultImageUrl);
      productUrlElement.find("img").attr("srcset", imageSrcset ? imageSrcset : DefaultImageSrcset);
      selectOptions.attr("href", url);
    }
  };
  var colorSwatchesCatalog = function colorSwatchesCatalog(e) {
    var currentTerm = $(e.currentTarget);
    var imageUrl = currentTerm.data("image-url");
    var imageUrlWooSize = currentTerm.data("image-woo-size");
    var imageSrcset = currentTerm.data("image-srcset");
    var defaultImageUrl = currentTerm.data("default-image-url");
    var DefaultImageUrlWooSize = currentTerm.data("default-image-woo-size");
    var DefaultImageSrcset = currentTerm.data("default-image-srcset");
    if (!currentTerm.hasClass("selected")) {
      swatchesCatalog.removeClass("selected");
      currentTerm.addClass("selected");

      // Image Title

      var imageTitleSplit = imageUrl.split("/");
      var imageTitle = imageTitleSplit[imageTitleSplit.length - 1];

      // Default Image Title

      var defaultImageTitleSplit = defaultImageUrl.split("/");
      var defaultImageTitle = defaultImageTitleSplit[imageTitleSplit.length - 1];
      var productMainImage = $(".wp-post-image");
      var mainImageWrapper = productMainImage.closest(".woocommerce-product-gallery__image");
      var navImage = $(".flex-control-thumbs li img").eq(0);
      var navImages = $(".flex-control-thumbs li img");
      var previewImage = $(".pswp__item").find("img");

      // Do we have same variation image as navImage

      var navImagePreselect = false;
      $.each(navImages, function (key, val) {
        var navImageSrc = $(val).attr("src");
        if (navImageSrc == imageUrl) {
          $(val).trigger("click");
          navImagePreselect = true;
          navImage.attr("src", defaultImageUrl);
          productMainImage.attr("src", DefaultImageUrlWooSize);
          productMainImage.attr("data-src", DefaultImageSrcset);
          productMainImage.attr("srcset", defaultImageUrl);
          productMainImage.attr("data-large_image", defaultImageUrl);
          productMainImage.attr("title", defaultImageTitle);
          mainImageWrapper.find(".zoomImg").attr("src", defaultImageUrl);
          mainImageWrapper.find("a").attr("href", defaultImageUrl);
          mainImageWrapper.attr("data-thumb", defaultImageUrl);
          previewImage.attr("src", defaultImageUrl);
        }
      });
      if (!navImagePreselect) {
        productMainImage.attr("src", imageUrlWooSize ? imageUrlWooSize : DefaultImageUrlWooSize);
        productMainImage.attr("data-src", imageSrcset ? imageSrcset : DefaultImageSrcset);
        productMainImage.attr("srcset", imageSrcset ? imageSrcset : defaultImageUrl);
        productMainImage.attr("data-large_image", imageUrl ? imageUrl : defaultImageUrl);
        productMainImage.attr("title", imageTitle);
        mainImageWrapper.find(".zoomImg").attr("src", imageUrl ? imageUrl : defaultImageUrl);
        mainImageWrapper.find("a").attr("href", imageUrl ? imageUrl : defaultImageUrl);
        mainImageWrapper.attr("data-thumb", imageUrl ? imageUrl : defaultImageUrl);
        navImage.attr("src", imageUrl ? imageUrl : defaultImageUrl);
        navImage.trigger("click");
        previewImage.attr("src", imageUrl ? imageUrl : defaultImageUrl);
      }
    }
  };
  swatchesInit();
  $("body").on("click", resetLink, resetVariation);
  swatchesLabels.on("click", triggerWooAttributeSelectChange);
  swatchesLabelsContentProduct.on("click", contentProductColorPreselect);
  swatchesLabelsContentRelated.on("click", contentProductColorPreselect);
  swatchesLabelsContentProductCatalog.on("click", contentProductColorPreselectCatalog);
  swatchesLabelsContentProductCatalogRelated.on("click", contentProductColorPreselectCatalog);
  swatchesCatalog.on("click", colorSwatchesCatalog);
  $(".variations_form").on("woocommerce_variation_select_change", disableAttributes);
  catalogSwatchesInit();
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
  var $temp = $("<input>");
  var $url = $(location).attr('href');
  $('#btn').click(function () {
    $("body").append($temp);
    $temp.val($url).select();
    document.execCommand("copy");
    $temp.remove();
    $(".result").text("URL copied!");
  });
});