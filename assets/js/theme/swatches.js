jQuery(document).ready(function ($) {
	const swatchesLabels = $(
		".single-product .summary .product-swatches .product-swatches__label"
	);
	const swatchesLabelsContentProduct = $(
		".archive .product .product-swatches .product-swatches__label"
	);
	const swatchesLabelsContentProductCatalog = $(
		".archive .product .product-swatches-catalog .product-swatches-catalog__label"
	);
	const swatchesLabelsContentProductCatalogRelated = $(
		".related .product .product-swatches-catalog .product-swatches-catalog__label"
	);
	const swatchesLabelsContentRelated = $(
		".related .product .product-swatches .product-swatches__label"
	);
	const swatchesCatalog = $(
		".product-swatches-catalog .product-swatches-catalog__label"
	);
	const defaultVariations = $(".variations select");
	const resetLink = ".reset_variations";

	const triggerWooAttributeSelectChange = (e) => {
		const currentTerm = $(e.currentTarget);
		const value = currentTerm.data("value");
		const taxonomy = currentTerm.data("attribute-name");
		const siblingsTerms = currentTerm.parent().find(swatchesLabels);

		if (!currentTerm.hasClass("selected")) {
			$(`#${taxonomy}`).val(value);
			$(`#${taxonomy}`).trigger("change");
			siblingsTerms.removeClass("selected");
			currentTerm.addClass("selected");
		}
	};

	// Remove not available available

	const disableAttributes = () => {
		setTimeout(() => {
			const optionsValues = [];
			const defaultVariations = $(".variations select");
			const swatchesLabels = $(
				".single-product .summary .product-swatches .product-swatches__label"
			);
			const options = defaultVariations.find("option");

			Object.keys(options).forEach((index) => {
				optionsValues.push(options[index].value);
			});

			const optionValuesFormated = optionsValues.filter((option) => {
				return option != "" && option !== undefined;
			});
			$.each(swatchesLabels, (index, label) => {
				if (
					$.inArray($(label).attr("data-value"), optionValuesFormated) === -1
				) {
					$(label).addClass("disabled");
				} else {
					$(label).removeClass("disabled");
				}
			});
		}, 200);
	};

	const swatchesInit = () => {
		$.each(defaultVariations, (defaultVariationIndex, defaultVariation) => {
			const currentTerm = $(defaultVariation);
			const currentTermValue = currentTerm.val();
			if (currentTermValue) {
				$(`.product-swatches__label[data-value=${currentTermValue}]`).addClass(
					"selected"
				);
			}
		});

		disableAttributes();
	};

	const resetVariation = () => {
		swatchesLabels.removeClass("selected");
	};

	const contentProductColorPreselect = (e) => {
		e.stopPropagation();
		e.preventDefault();

		const currentTerm = $(e.currentTarget);
		const siblingsTerms = currentTerm.parent().find(".product-swatches__label");
		const productUrlElement = currentTerm.closest(
			".woocommerce-loop-product__link"
		);
		const selectOptions = productUrlElement
			.parent()
			.find(".product_type_variable.add_to_cart_button");
		const productUrl = currentTerm
			.closest(".woocommerce-loop-product__link")
			.attr("href");
		const colorSlug = currentTerm.data("value");
		const productImageUrl = currentTerm.data("image-url");
		const productImageSrcset = currentTerm.data("image-src");

		if (!currentTerm.hasClass("selected")) {
			siblingsTerms.removeClass("selected");
			currentTerm.addClass("selected");

			// Add query arg to url

			const url = new URL(productUrl);
			url.searchParams.delete("productColor");
			url.searchParams.append("productColor", colorSlug);
			productUrlElement.attr("href", url);
			productUrlElement.find("img").attr("src", productImageUrl);
			productUrlElement.find("img").attr("srcset", productImageSrcset);
			selectOptions.attr("href", url);
		}
	};

	const catalogSwatchesInit = () => {
		const url = new URL(window.location.href);
		if (
			url.searchParams.get("productColor") &&
			$(".product-template-single-product-catalog").length
		) {
			$(
				`.summary span[data-color-name=${url.searchParams.get(
					"productColor"
				)}].product-swatches-catalog__label`
			).trigger("click");
		}
	};

	const contentProductColorPreselectCatalog = (e) => {
		e.stopPropagation();
		e.preventDefault();

		const currentTerm = $(e.currentTarget);
		const siblingsTerms = currentTerm
			.parent()
			.find(".product-swatches-catalog__label");
		const productUrlElement = currentTerm.closest(
			".woocommerce-loop-product__link"
		);
		const selectOptions = productUrlElement.parent().find(".button");
		const productUrl = currentTerm
			.closest(".woocommerce-loop-product__link")
			.attr("href");
		const colorSlug = currentTerm.data("color-name");
		const imageUrl = currentTerm.data("image-url");
		const imageSrcset = currentTerm.data("image-srcset");
		const defaultImageUrl = currentTerm.data("default-image-url");
		const DefaultImageSrcset = currentTerm.data("default-image-srcset");

		if (!currentTerm.hasClass("selected")) {
			siblingsTerms.removeClass("selected");
			currentTerm.addClass("selected");

			// Add query arg to url

			const url = new URL(productUrl);
			url.searchParams.delete("productColor");
			url.searchParams.append("productColor", colorSlug);
			productUrlElement.attr("href", url);
			productUrlElement
				.find("img")
				.attr("src", imageUrl ? imageUrl : defaultImageUrl);
			productUrlElement
				.find("img")
				.attr("srcset", imageSrcset ? imageSrcset : DefaultImageSrcset);
			selectOptions.attr("href", url);
		}
	};

	const colorSwatchesCatalog = (e) => {
		const currentTerm = $(e.currentTarget);
		const imageUrl = currentTerm.data("image-url");
		const imageUrlWooSize = currentTerm.data("image-woo-size");
		const imageSrcset = currentTerm.data("image-srcset");
		const defaultImageUrl = currentTerm.data("default-image-url");
		const DefaultImageUrlWooSize = currentTerm.data("default-image-woo-size");
		const DefaultImageSrcset = currentTerm.data("default-image-srcset");

		if (!currentTerm.hasClass("selected")) {
			swatchesCatalog.removeClass("selected");
			currentTerm.addClass("selected");

			// Image Title

			const imageTitleSplit = imageUrl.split("/");
			const imageTitle = imageTitleSplit[imageTitleSplit.length - 1];

			// Default Image Title

			const defaultImageTitleSplit = defaultImageUrl.split("/");
			const defaultImageTitle =
				defaultImageTitleSplit[imageTitleSplit.length - 1];

			const productMainImage = $(".wp-post-image");
			const mainImageWrapper = productMainImage.closest(
				".woocommerce-product-gallery__image"
			);
			const navImage = $(".flex-control-thumbs li img").eq(0);
			const navImages = $(".flex-control-thumbs li img");
			const previewImage = $(".pswp__item").find("img");

			// Do we have same variation image as navImage

			let navImagePreselect = false;

			$.each(navImages, (key, val) => {
				const navImageSrc = $(val).attr("src");
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
				productMainImage.attr(
					"src",
					imageUrlWooSize ? imageUrlWooSize : DefaultImageUrlWooSize
				);
				productMainImage.attr(
					"data-src",
					imageSrcset ? imageSrcset : DefaultImageSrcset
				);
				productMainImage.attr(
					"srcset",
					imageSrcset ? imageSrcset : defaultImageUrl
				);
				productMainImage.attr(
					"data-large_image",
					imageUrl ? imageUrl : defaultImageUrl
				);
				productMainImage.attr("title", imageTitle);
				mainImageWrapper
					.find(".zoomImg")
					.attr("src", imageUrl ? imageUrl : defaultImageUrl);
				mainImageWrapper
					.find("a")
					.attr("href", imageUrl ? imageUrl : defaultImageUrl);
				mainImageWrapper.attr(
					"data-thumb",
					imageUrl ? imageUrl : defaultImageUrl
				);
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
	swatchesLabelsContentProductCatalog.on(
		"click",
		contentProductColorPreselectCatalog
	);
	swatchesLabelsContentProductCatalogRelated.on(
		"click",
		contentProductColorPreselectCatalog
	);
	swatchesCatalog.on("click", colorSwatchesCatalog);
	$(".variations_form").on(
		"woocommerce_variation_select_change",
		disableAttributes
	);
	catalogSwatchesInit();
});
