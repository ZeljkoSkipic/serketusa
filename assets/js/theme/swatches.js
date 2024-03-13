jQuery(document).ready(function ($) {
    const swatchesLabels = $('.single-product .product-swatches .product-swatches__label');
    const swatchesLabelsContentProduct = $('.archive .product .product-swatches .product-swatches__label');
    const defaultVariations = $('.variations select')
    const resetLink = '.reset_variations'

    const triggerWooAttributeSelectChange = (e) => {
        const currentTerm = $(e.currentTarget)
        const value = currentTerm.data('value')
        const taxonomy = currentTerm.data('attribute-name')
        const siblingsTerms = currentTerm.parent().find(swatchesLabels)

        if (!currentTerm.hasClass('selected')) {
            $(`#${taxonomy}`).val(value)
            $(`#${taxonomy}`).trigger('change')
            siblingsTerms.removeClass('selected')
            currentTerm.addClass('selected')
        }
    }

     // Remove not available available

     const disableAttributes = () => {
        setTimeout(() => {
            const optionsValues = [];
            const defaultVariations = $('.variations select');
            const swatchesLabels = $('.single-product .product-swatches .product-swatches__label');
            const options = defaultVariations.find('option')


            Object.keys(options).forEach(index => {
                optionsValues.push(options[index].value)
            });

            const optionValuesFormated = optionsValues.filter((option) => {
                return option != "" && option !== undefined
            })
            $.each(swatchesLabels, (index, label) => {

                if ($.inArray($(label).attr('data-value'), optionValuesFormated) === -1) {
                    $(label).addClass('disabled')
                }

                else {
                    $(label).removeClass('disabled')
                }
            })

        }, 200)
    }

    const swatchesInit = () => {
        $.each(defaultVariations, (defaultVariationIndex, defaultVariation) => {
            const currentTerm = $(defaultVariation)
            const currentTermValue = currentTerm.val()
            if (currentTermValue) {
                $(`.product-swatches__label[data-value=${currentTermValue}]`).addClass('selected');
            }
        })

        disableAttributes()
    }

    const resetVariation = () => {
        swatchesLabels.removeClass('selected')
    }

    const contentProductColorPreselect = (e) => {
        e.stopPropagation()
        e.preventDefault()

        const currentTerm = $(e.currentTarget)
        const siblingsTerms = currentTerm.parent().find(swatchesLabelsContentProduct)
        const productUrlElement = currentTerm.closest('.woocommerce-loop-product__link')
        const selectOptions = productUrlElement.parent().find('.product_type_variable.add_to_cart_button');
        const productUrl = currentTerm.closest('.woocommerce-loop-product__link').attr('href')
        const colorSlug = currentTerm.data('value')

        if (!currentTerm.hasClass('selected')) {

            siblingsTerms.removeClass('selected')
            currentTerm.addClass('selected')

            // Add query arg to url

            const url = new URL(productUrl);
            url.searchParams.delete('productColor');
            url.searchParams.append('productColor', colorSlug);
            productUrlElement.attr('href', url)
            selectOptions.attr(url);
        }
    }

    swatchesInit()
    $('body').on('click', resetLink, resetVariation);
    swatchesLabels.on('click', triggerWooAttributeSelectChange);
    swatchesLabelsContentProduct.on('click', contentProductColorPreselect);
    $(".variations_form").on("woocommerce_variation_select_change", disableAttributes);

});
