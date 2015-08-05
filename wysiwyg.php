<?php
/*
Plugin Name: WP Taxonomy Description (WYSIWYG)
Description: Adds a tinymce editor to the category description box
Author: Charly Capillanes
Author URI: https://charlycapillanes.wordpress.com/
Version: 1.0
License: GPL1
*/

// http://adambrown.info/p/wp_hooks/hook/edit_category_form_fields

// remove the html filtering

$tax = isset( $_GET['taxonomy'] ) ? $_GET['taxonomy'] : null;

// $edit_tax = 'edit_'.$tax.'_form_fields';
$edit_tax = $tax.__( '_edit_form_fields' );

remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );

/**
    function {taxonomy}_edit_form_fields
**/

add_filter($edit_tax, 'cat_description');
function cat_description($tag)
{
    $tx = isset( $_GET['taxonomy'] ) ? $_GET['taxonomy'] : null;  
    ?>
            <!-- wp editor form field layout -->

            <tr class="form-field">
                <th scope="row" valign="top"><label for="description"><?php _e('Description', 'Taxonomy Description'); ?></label></th>
                <td>
                <?php
                    $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );
                    wp_editor(wp_kses_post($tag->description , ENT_QUOTES, 'UTF-8'), $tx . '_description', $settings);
                ?>
                <br />
                <span class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></span>
                </td>
            </tr>
            
            <!-- wp editor form field layout END -->
            
    <?php
}

add_action('admin_head', 'remove_default_category_description');
function remove_default_category_description()
{
    global $current_screen;
    
    if ( $current_screen->id )
    {
    ?>
        <script type="text/javascript">
        jQuery(function($) {
            $('textarea#description').closest('tr.form-field').remove();
        });
        </script>
    <?php
    }
}
?>