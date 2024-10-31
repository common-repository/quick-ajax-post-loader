<?php 
if (!defined('ABSPATH')) {
    exit;
}
if (QAPL_Quick_Ajax_Helper::element_exists('class','QAPL_Quick_Ajax_Creator_Settings_Page')) {
    class QAPL_Quick_Ajax_Creator_Settings_Page extends QAPL_Quick_Ajax_Manage_Options_Form {
        private $tabIndex = 0;
        public function render_quick_ajax_page_heading() {
        return '<h1>'.esc_html__('Quick AJAX settings', 'quick-ajax-post-loader').'</h1>';
        }
        public function init_quick_ajax_creator_fields(){            
            //select custom load more post quantity
            $field_properties = QAPL_Quick_Ajax_Fields::get_global_field_select_loader_icon();
            $this->create_field($field_properties);
            //select post type
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_post_type();
            $this->create_field($field_properties);
            //show taxonomy checkbox
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_show_taxonomy_filter();
            $this->create_field($field_properties);
            //select taxonomy
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_taxonomy();
            $this->create_field($field_properties);
            //post per page number
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_posts_per_page();
            $this->create_field($field_properties);
            //select post order
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_order();        
            $this->create_field($field_properties);
            //select post orderby
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_orderby();    
            $this->create_field($field_properties);
            //select post status
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_post_status();
            $this->create_field($field_properties);
            //add Excluded Post IDs
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_set_post_not_in();
            $this->create_field($field_properties);
            //set ignore sticky
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_set_ignore_sticky_posts();
            $this->create_field($field_properties);
            //apply quick ajax css style
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_layout_quick_ajax_css_style();
            $field_properties['default'] = 0;
            $this->create_field($field_properties);
            //select number of columns
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_layout_select_columns_qty();  
            $this->create_field($field_properties);
            //select post item template
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_layout_post_item_template();
            $this->create_field($field_properties);
            //add custom class for taxonomy filter
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_layout_taxonomy_filter_class();
            $this->create_field($field_properties);
            //add custom class for container
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_layout_container_class();
            $this->create_field($field_properties);
            //show custom load more post quantity
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_show_custom_load_more_post_quantity();
            $this->create_field($field_properties);
            //select custom load more post quantity
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_custom_load_more_post_quantity();
            $this->create_field($field_properties);
            //override loader icon
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_override_global_loader_icon();
            $this->create_field($field_properties);
            //select loader icon
            $field_properties = QAPL_Quick_Ajax_Fields::get_field_select_loader_icon();
            $this->create_field($field_properties);
        }
        
        public function init_quick_ajax_content(){
            $tab_title = esc_html__('Global Options', 'quick-ajax-post-loader');
            $this->add_quick_ajax_page_content($this->tabIndex++, $tab_title,  $this->quick_ajax_content_global_options());
            $tab_title = esc_html__('Function Generator', 'quick-ajax-post-loader');
            $this->add_quick_ajax_page_content($this->tabIndex++, $tab_title, $this->quick_ajax_content_function_generator());
            $tab_title = esc_html__('Help', 'quick-ajax-post-loader');
            $this->add_quick_ajax_page_content($this->tabIndex++, $tab_title, $this->quick_ajax_content_help());
        }

        private function quick_ajax_content_global_options() {
            $content = '<div id="quick-ajax-example-code"><h3>'.__('Global Options', 'quick-ajax-post-loader').'</h3></div>';
            $content .= $this->add_field(QAPL_Quick_Ajax_Helper::global_options_field_select_loader_icon());
            $content .= get_submit_button(esc_html__('Save Settings', 'quick-ajax-post-loader'), 'primary', 'save_settings_button', false);
            return $content;
        }
        
        private function quick_ajax_content_function_generator() {
            $form_tab_function_generator = '<h3>'.esc_html__('Function Generator', 'quick-ajax-post-loader').'</h3>
            <div class="function-generator-wrap">
                <div class="function-generator-options" id="'.QAPL_Quick_Ajax_Helper::settings_wrapper_id().'">';
            $form_tab_function_generator .= '<div class="quick-ajax-layout-settings">';
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_post_type());
            //show taxonomy checkbox
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_show_taxonomy_filter(), true);
            //select taxonomy
            $taxonomies = array();
            $selected_option = $this->get_the_value_if_exist(QAPL_Quick_Ajax_Helper::shortcode_page_select_post_type());
            if (empty($selected_option)) {
            $selected_option = QAPL_Quick_Ajax_Helper::shortcode_page_select_post_type_default_value();
            }
            $post_type_object = get_post_type_object($selected_option);
            if ($post_type_object) {
            $taxonomies = get_object_taxonomies($selected_option);
            }
            $taxonomy_options = array();
            if (!empty($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    $taxonomy_object = get_taxonomy($taxonomy);
                    if ($taxonomy_object) {
                        $taxonomy_options[] = array(
                            'label' => esc_html($taxonomy_object->label),
                            'value' => esc_attr($taxonomy)
                        );
                    }
                }
            }            
            $this->fields[QAPL_Quick_Ajax_Helper::shortcode_page_select_taxonomy()]['options'] = $taxonomy_options;
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_taxonomy(), QAPL_Quick_Ajax_Helper::shortcode_page_show_taxonomy_filter());
            $form_tab_function_generator .= '</div>';
            //post settings
            $form_tab_function_generator .= '<div class="quick-ajax-layout-settings" style="margin-top:20px">';
            $form_tab_function_generator .= '<h4>'.__('Query Settings', 'quick-ajax-post-loader').'</h4>';            
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_post_status());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_posts_per_page());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_order());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_orderby());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_set_post_not_in());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_ignore_sticky_posts());
            $form_tab_function_generator .= '</div>';
            $form_tab_function_generator .= '<div class="quick-ajax-layout-settings" style="margin-top:20px">';
            $form_tab_function_generator .= '<h4>'.__('Layout Settings', 'quick-ajax-post-loader').'</h4>';
            //Layout Settings
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_layout_quick_ajax_css_style(), true);
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_layout_select_columns_qty(), QAPL_Quick_Ajax_Helper::shortcode_page_layout_quick_ajax_css_style());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_layout_post_item_template());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_layout_taxonomy_filter_class(), QAPL_Quick_Ajax_Helper::shortcode_page_show_taxonomy_filter());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_layout_container_class());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_show_custom_load_more_post_quantity(), true);
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_custom_load_more_post_quantity(), QAPL_Quick_Ajax_Helper::shortcode_page_show_custom_load_more_post_quantity());
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_override_global_loader_icon(),true);
            $form_tab_function_generator .= $this->add_field(QAPL_Quick_Ajax_Helper::shortcode_page_select_loader_icon(), QAPL_Quick_Ajax_Helper::shortcode_page_override_global_loader_icon());
            $form_tab_function_generator .= '</div>';
            $form_tab_function_generator .= '</div>';
            $form_tab_function_generator .= '<div class="function-generator-result">';  
            $form_tab_function_generator .= '<div class="function-generator-buttons">
                            <button class="generate-function-button button button-primary" data-output="code-snippet-2" type="button">'.__('Generate Function', 'quick-ajax-post-loader').'</button>
                            <button class="copy-button button button-primary" data-copy="code-snippet-2" type="button">'.__('Copy Code', 'quick-ajax-post-loader').'</button>
                        </div>';  
            $form_tab_function_generator .= '<pre id="code-snippet-2" style="margin-top:20px"></pre>';
            $form_tab_function_generator .= '</div>';
            $form_tab_function_generator .= '</div>';
            return $form_tab_function_generator;
        }

        private function quick_ajax_content_help() {
            $content = '<h3>'.__('Help', 'quick-ajax-post-loader').'</h3>';
            $base_help_dir = plugin_dir_path(__FILE__) . 'help/';
            $locale = get_locale();
            switch ($locale) {
                case 'pl_PL':
                    $help_dir = $base_help_dir . 'pl_PL/';
                    break;
                default:
                    $help_dir = $base_help_dir;
                    break;
            }
            // Paths to files
            $help_files = [
                'help-quick-ajax-intro.php',
                'help-quick-ajax-templates-post-item.php',
                'help-quick-ajax-templates-loader-icon.php',
                'help-quick-ajax-templates-term-filter-button.php',
                'help-quick-ajax-function-generator.php',
                'help-quick-ajax-post-grid.php',
                'help-quick-ajax-term-filter.php',                
                'help-quick-ajax-args.php',
                'help-quick-ajax-attributes.php',
                'help-quick-ajax-add-action.php',
                'help-quick-ajax-add-filters-quick-ajax-modify-query.php',
                'help-quick-ajax-add-filters-quick-ajax-modify-term-buttons.php',
            ];
            // Loop the files and create accordion blocks
            foreach ($help_files as $file) {
                $file_path = realpath($help_dir . $file);
                if ($file_path && strpos($file_path, realpath($base_help_dir)) === 0 && file_exists($file_path)) {
                    $accordion_content = include_once $file_path; // Include returns array with 'title' and 'content'
                    // Check if array exists
                    if (is_array($accordion_content) && isset($accordion_content['title'], $accordion_content['content'])) {
                        $accordion_block = $this->create_accordion_block(esc_html($accordion_content['title']), wp_kses_post($accordion_content['content']));
                        $content .= $accordion_block; 
                    }
                }
            }
            return $content;
        }
    }
}