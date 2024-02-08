<?php

// Add new field to edit and add attribues form

function woo_attributes_swatches_type_field_edit()
{
    $id = isset($_GET['edit']) ? absint($_GET['edit']) : 0;
    $value = $id ? get_option("wc_attribute_swatched-type-$id") : '';
?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="swatched"><?php esc_html_e('Swaches Type', 'serketusa'); ?></label>
        </th>
        <td>
            <select name="swatched-type" id="swatched">
                <option <?php if ($value == 'name') echo 'selected=selected'; ?> value="name"><?php esc_html_e('Name', 'serketusa'); ?></option>
                <option <?php if ($value == 'color') echo 'selected=selected'; ?> value="color"><?php esc_html_e('Color', 'serketusa'); ?></option>
            </select>
        </td>
    </tr>
<?php
}

function woo_attributes_swatches_type_field_add()
{
    $id = isset($_GET['edit']) ? absint($_GET['edit']) : 0;
    $value = $id ? get_option("wc_attribute_swatched-type-$id") : '';
?>
    <div class="form-field">
        <label for="swatched"><?php esc_html_e('Swaches Type', 'serketusa'); ?></label>
        <select name="swatched-type" id="swatched">
            <option <?php if ($value == 'name') echo 'selected=selected'; ?> value="name"><?php esc_html_e('Name', 'serketusa'); ?></option>
            <option <?php if ($value == 'color') echo 'selected=selected'; ?> value="color"><?php esc_html_e('Color', 'serketusa'); ?></option>
        </select>
    </div>
<?php
}

add_action('woocommerce_after_add_attribute_fields', 'woo_attributes_swatches_type_field_add');
add_action('woocommerce_after_edit_attribute_fields', 'woo_attributes_swatches_type_field_edit');

// Save field value to edit and add attribues form

function woo_attributes_swatches_type_field_save($id)
{
    if (is_admin() && isset($_POST['swatched-type'])) {
        $option = "wc_attribute_swatched-type-$id";
        update_option($option, sanitize_text_field($_POST['swatched-type']));
    }
}

add_action('woocommerce_attribute_added', 'woo_attributes_swatches_type_field_save');
add_action('woocommerce_attribute_updated', 'woo_attributes_swatches_type_field_save');

// Delete Value when attribute is deleted on edit and add attribues form

add_action('woocommerce_attribute_deleted', function ($id) {
    delete_option("wc_attribute_swatched-type-$id");
});

// Enqueue Color Picker Script

add_action('admin_enqueue_scripts', 'swatches_admin_scripts');
function swatches_admin_scripts($hook_suffix)
{
    if ($hook_suffix == 'term.php' || $hook_suffix == 'edit-tags.php') {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('swatches-admin-scripts', get_template_directory_uri() . '/assets/js/admin/swatchesColorPicker.js', array('wp-color-picker'), false, true);
    }
}

// Render Picker View

function render_color_picker($term = "")
{
    if($term) {
        $color_picker_value = get_term_meta($term->term_id, 'color', true);
    }
?>
    <tr class="form-field">
        <th>
            <label for="color"><?php echo esc_html__('Color', 'etoiles'); ?></label>
        </th>
        <td>
            <input name="swatches-color-picker" type="text" value="<?php echo isset($color_picker_value) ? $color_picker_value : ""; ?>" class="swatches-color-picker" data-default-color="#effeff" />
            <p class="description"><?php echo esc_html__('Choose the appropriate color for this term.', 'serketusa'); ?></p>
        </td>
    </tr>

    <?php
}

// Add custom color picker to Woo Attribute Term

if (is_admin() && isset($_GET['taxonomy'], $_GET['post_type']) && $_GET['post_type'] === 'product') {
    $taxonomy_name = sanitize_text_field($_GET['taxonomy']);
    add_action($taxonomy_name . '_edit_form_fields', 'woo_attributes_term_fields_edit_form', 10, 2);
    add_action($taxonomy_name . '_add_form_fields', 'woo_attributes_term_fields_add_form', 10, 1);


    function woo_attributes_term_fields_edit_form($term, $taxonomy)
    {
        $attr_id = wc_attribute_taxonomy_id_by_name($taxonomy);
        $attribute_swatches_type = get_option("wc_attribute_swatched-type-$attr_id");
        if ($attribute_swatches_type != 'color') return;
        render_color_picker($term);
    }

    function woo_attributes_term_fields_add_form($taxonomy)
    {
        $attr_id = wc_attribute_taxonomy_id_by_name($taxonomy);
        $attribute_swatches_type = get_option("wc_attribute_swatched-type-$attr_id");
        if ($attribute_swatches_type != 'color') return;
        render_color_picker();
    }
}

// Save Color Picker Value

add_action('saved_term', 'woo_swatches_term_field_save', 10 , 5);

function woo_swatches_term_field_save($term_id, $tt_id, $taxonomy, $update, $args) {
    if (is_admin() && isset($_POST['swatches-color-picker'])) {
        $color_picker_value = wp_strip_all_tags($_POST['swatches-color-picker']);
        if($color_picker_value) {
            update_term_meta($term_id, 'color', $color_picker_value);
        }
    }
}

// Add Swatches action

add_action('product_swatches', 'add_swatches', 10, 3);

function add_swatches($options, $attribute_name, $attribute_swatches_type)
{
    ?>
    <div class="product-swatches">
        <?php
        if ($options) {
            foreach ($options as $option) {
                $term = get_term_by('slug', $option, $attribute_name);
                if ($attribute_swatches_type == 'name') {
        ?>
                    <span data-attribute-name="<?php echo $attribute_name; ?>" data-value="<?php echo $option; ?>" class="product-swatches__label"><?php echo $term->name; ?></span>

                <?php
                } else if ($attribute_swatches_type == 'color') {

                    $term_color = get_term_meta( $term->term_id,'color', true );
                ?>
                    <span data-attribute-name="<?php echo $attribute_name; ?>" style="<?php echo 'background-color:' . $term_color ?>" data-value="<?php echo $option; ?>" class="product-swatches__label">&nbsp;</span>

        <?php
                }
            }
        }
        ?>
    </div>
<?php
}

// Add Swatches to content product


function swatches_content_product()
{
    global $product;
    if ($product->is_type('variable')) {
        $product_variable = new WC_Product_Variable($product);
        $variation_attributes = $product_variable->get_variation_attributes();

        if ($variation_attributes && isset($variation_attributes['pa_colors']) && $variation_attributes['pa_colors']) {
            $attr_id = wc_attribute_taxonomy_id_by_name('pa_colors');
            $attribute_swatches_type = get_option("wc_attribute_swatched-type-$attr_id");
            do_action('product_swatches', $variation_attributes['pa_colors'], 'pa_colors', $attribute_swatches_type);
        }
    }
}

add_action('woocommerce_before_shop_loop_item_title', 'swatches_content_product', 11);


// Preselect Color Attribute

function preSelectColorAttribute($args)
{

    if (isset($_GET['productColor']) && $_GET['productColor']) {
        $color_slug = wp_strip_all_tags($_GET['productColor']);

        if (count($args['options']) > 0) {
            foreach ($args['options'] as $key => $option) {

                if ($option === $color_slug) {
                    $args['selected'] = $args['options'][$key];
                }
            }
        }
    }

    return $args;
}

add_filter('woocommerce_dropdown_variation_attribute_options_args',  'preSelectColorAttribute');
