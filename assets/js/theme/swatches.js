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

        if(!currentTerm.hasClass('selected')) {
            $(`#${taxonomy}`).val(value)
            $(`#${taxonomy}`).trigger('change')
            siblingsTerms.removeClass('selected')
            currentTerm.addClass('selected')
        }
    }

    const swatchesInit = () => {
        $.each(defaultVariations, (defaultVariationIndex, defaultVariation ) => {
            const currentTerm = $(defaultVariation)
            const currentTermValue = currentTerm.val()
            console.log(currentTermValue);
            if(currentTermValue) {
                $(`.product-swatches__label[data-value=${currentTermValue}]`).addClass('selected');
            } 
        })
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
        const productUrl = currentTerm.closest('.woocommerce-loop-product__link').attr('href')
        const colorSlug = currentTerm.data('value')

        if(!currentTerm.hasClass('selected')) {
           
            siblingsTerms.removeClass('selected')
            currentTerm.addClass('selected')

            // Add query arg to url

            const url = new URL(productUrl);
            url.searchParams.delete('productColor'); 
            url.searchParams.append('productColor', colorSlug); 
            productUrlElement.attr('href', url)
        }
    }

    swatchesInit()
    $('body').on('click', resetLink, resetVariation);
    swatchesLabels.on('click', triggerWooAttributeSelectChange);
    swatchesLabelsContentProduct.on('click', contentProductColorPreselect);

});