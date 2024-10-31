(function($) {
    // Define a unique namespace for your plugin's functions
    var qapl_quick_ajax_post_loader_admin_scripts = {
        init: function() {
            this.click_and_select_shortcode();
            this.click_and_select_all();
            this.handle_post_type_change();
            this.show_hide_element_on_change();
            this.quick_ajax_tabs();
            this.copy_code();
            this.quick_ajax_function_generator();
            this.accordion_block_toggle();
            // Any other functions you want to initialize
        },
        handle_post_type_change: function() {
            if (typeof qapl_quick_ajax_helper !== 'undefined' && qapl_quick_ajax_helper) {
                if ($('#'+qapl_quick_ajax_helper.quick_ajax_settings_wrapper+' #'+qapl_quick_ajax_helper.quick_ajax_post_type).length) {
                    $('#'+qapl_quick_ajax_helper.quick_ajax_settings_wrapper+' #'+qapl_quick_ajax_helper.quick_ajax_post_type).on('change', function () {
                        var postType = $(this).val();
                        $.ajax({
                            url: qapl_quick_ajax_helper.ajax_url,
                            type: 'POST',
                            data: {
                            action: 'qapl_quick_ajax_get_taxonomies_by_post_type',
                            post_type: postType,
                            nonce: qapl_quick_ajax_helper.nonce
                            },
                            success: function (response) {
                                if (response && response.data) {
                                    var taxonomySelect = $('#'+qapl_quick_ajax_helper.quick_ajax_settings_wrapper+' #'+qapl_quick_ajax_helper.quick_ajax_taxonomy);
                                    taxonomySelect.empty();
                                    taxonomySelect.append(response.data);
                                }
                                else {
                                    console.error('Quick Ajax Post Loader: Invalid response structure');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
                }
            }
        },
        show_hide_element_on_change: function() {
            $('.show-hide-element').each(function () {
                var checkbox = $(this).find('input');
                var targetID = checkbox.attr('id'); 
                checkbox.change(function () {
                    if (checkbox.is(':checked')) {
                    $('div[data-item="' + targetID + '"]').removeClass('inactive');
                    } else {
                    $('div[data-item="' + targetID + '"]').addClass('inactive');
                    }
                });
            });
        },
        quick_ajax_tabs: function() {
            if ($(".quick-ajax-tabs").length) {
                const tabButtons = $(".quick-ajax-tab-button");
                const tabContents = $(".quick-ajax-tab-content");
                tabButtons.on("click", function (e) {
                e.preventDefault();
                const tabId = $(this).data("tab");
                // Deactivate all tabs and buttons
                tabButtons.removeClass("active");
                tabContents.removeClass("active");    
                // Activate the clicked tab and button
                $(this).addClass("active");
                $("#" + tabId).addClass("active");
                });
            }
        },
        copy_code: function() {
            $('.copy-button').on('click', function() {
                var codeToCopy = $('#' + $(this).data('copy'));
                // Create a temporary textarea
                var tempTextarea = $('<textarea>').val(codeToCopy.text()).appendTo('body').select();
                try {
                    // Use the new clipboard API to copy the selected text
                    navigator.clipboard.writeText(codeToCopy.text())
                        .then(() => {
                            //console.log('Text copied to clipboard');
                        })
                        .catch(error => {
                            console.error('Quick Ajax - Unable to copy text to clipboard', error);
                        });
                } finally {
                    // Clean up: remove the temporary textarea
                    tempTextarea.remove();
                    // Feedback to the user
                    $(this).text('Code Copied');
                    setTimeout(() => {
                        $(this).text('Copy Code');
                    }, 2000);
                }
            });
        },
        generateId: function(inputDataString) {
            let blockId = 0;    
            for (let i = 0; i < inputDataString.length; i++) {
                blockId += inputDataString.charCodeAt(i);
                if (i % 2 === 0) {
                    blockId += inputDataString.charCodeAt(i);
                } else {
                    blockId -= inputDataString.charCodeAt(i);
                }
            }
            return blockId;
        },
        getExcludedPostIds: function(excludedPostIds){
            var parts = excludedPostIds.split(/[,\s]+/);
            var postNotIn = [];
            parts.forEach(function(part) {
                if (/^\d+$/.test(part) && postNotIn.indexOf(part) === -1) { //postNotIn.indexOf(part) === -1 check and add if id doesn't exist in the array
                    postNotIn.push(part);
                }
            });
            var result = postNotIn.join(', ');
            return result;
        },
        cleanClassNames: function(inputDataString) {
            // Replace commas with spaces
            let cleaned = inputDataString.replace(/,/g, ' ');

            // Split string into array of class names
            let classNames = cleaned.split(/\s+/);

            // Filter out class names that start with a digit and remove duplicates
            classNames = classNames.filter((name, index, self) => {
                return !/^\d/.test(name) && name !== '' && self.indexOf(name) === index;
            });

            // Join the cleaned class names with a single space
            return classNames.join(' ');
        },
        quick_ajax_function_generator: function() {
            var self = this;
            $('.generate-function-button').on('click', function() {
                var button = $(this);
                var outputDiv = button.attr('data-output');
                button.prop('disabled', true);            
                var copyButton = $('.copy-button[data-copy="' + outputDiv+ '"]');
                copyButton.prop('disabled', true);
                var inputData = {};
                var inputs = $('.function-generator-wrap input, .function-generator-wrap select, .function-generator-wrap checkbox');
                inputs.each(function(index, input) {
                    if (input.type === 'checkbox') {
                        inputData[input.id] = input.checked ? 1 : 0;
                    } else {
                        inputData[input.id] = $(input).val();
                    }
                });
                let inputDataString = Object.values(inputData).join('');
                //quickAjaxArgs code
                var quickAjaxArgsText = "";
                quickAjaxArgsText += "$quick_ajax_args = array(\n";
                quickAjaxArgsText += "    'post_type' => '" + inputData.qapl_select_post_type + "',\n";
                quickAjaxArgsText += "    'post_status' => '" + inputData.qapl_select_post_status + "',\n";
                quickAjaxArgsText += "    'posts_per_page' => " + inputData.qapl_select_posts_per_page + ",\n";
                if (inputData.qapl_select_orderby !== 'none') {
                    quickAjaxArgsText += "    'orderby' => '" + inputData.qapl_select_orderby + "',\n";
                }         
                quickAjaxArgsText += "    'order' => '" + inputData.qapl_select_order + "',\n";
                if (inputData.qapl_select_post_not_in !== '') {
                    var excludedPostIds = self.getExcludedPostIds(inputData.qapl_select_post_not_in);
                    quickAjaxArgsText += "    'post__not_in' => array(" + excludedPostIds + "),\n";
                }   
                if (inputData.qapl_ignore_sticky_posts === 1) {
                    quickAjaxArgsText += "    'ignore_sticky_posts' => " + inputData.qapl_ignore_sticky_posts + ",\n";
                }   
                quickAjaxArgsText += ");";
                if (typeof qapl_quick_ajax_helper !== 'undefined' && qapl_quick_ajax_helper) {
                    var quickAjaxAttributes = {};
                    quickAjaxAttributes[qapl_quick_ajax_helper.quick_ajax_id] = self.generateId(inputDataString);
                    if (inputData.qapl_layout_quick_ajax_css_style === 1) {
                        quickAjaxAttributes[qapl_quick_ajax_helper.quick_ajax_css_style] = inputData.qapl_layout_quick_ajax_css_style;
                        quickAjaxAttributes[qapl_quick_ajax_helper.grid_num_columns] = inputData.qapl_layout_select_columns_qty;
                    }
                    if (inputData.qapl_layout_quick_ajax_post_item_template) {
                        var clearContainerClass = inputData.qapl_layout_quick_ajax_post_item_template;
                        quickAjaxAttributes[qapl_quick_ajax_helper.post_item_template] = clearContainerClass;
                    }
                    if (inputData.qapl_layout_add_taxonomy_filter_class && inputData.qapl_layout_add_taxonomy_filter_class !== '') {
                        var clearContainerClass = self.cleanClassNames(inputData.qapl_layout_add_taxonomy_filter_class);
                        quickAjaxAttributes[qapl_quick_ajax_helper.taxonomy_filter_class] = clearContainerClass;
                    }
                    if (inputData.qapl_layout_add_container_class && inputData.qapl_layout_add_container_class !== '') {
                        var clearContainerClass =  self.cleanClassNames(inputData.qapl_layout_add_container_class);
                        quickAjaxAttributes[qapl_quick_ajax_helper.container_class] = clearContainerClass;
                    }
                    if (inputData.qapl_show_custom_load_more_post_quantity === 1) {
                        quickAjaxAttributes[qapl_quick_ajax_helper.load_more_posts] = inputData.qapl_select_custom_load_more_post_quantity;
                    }
                    if (inputData.qapl_override_global_loader_icon === 1) {
                        quickAjaxAttributes[qapl_quick_ajax_helper.loader_icon] = inputData.qapl_loader_icon;
                    }
                }
                //quickAjaxAttributes code
                var quickAjaxAttributesText = "";
                if (Object.keys(quickAjaxAttributes).length > 0) {
                    quickAjaxAttributesText = "";
                    quickAjaxAttributesText += "$quick_ajax_attributes = array(\n";
                    Object.entries(quickAjaxAttributes).forEach(([key, value]) => {
                        let AttributesValue;                 
                        // Check if the resulting value is a finite number
                        if (self.quick_ajax_is_numeric(value)) {
                            // Use the numeric value if the conversion was possible
                            AttributesValue = parseInt(value);
                        } else if (typeof value === 'string') {
                            // Otherwise, if the value is a string, add quotes
                            AttributesValue = `'${value}'`;
                        } else {
                            // For other data types, use the value unchanged
                            AttributesValue = value;
                        }
                        quickAjaxAttributesText += `    '${key}' => ${AttributesValue},\n`;
                    });
                    //remove last comma
                    quickAjaxAttributesText = quickAjaxAttributesText.slice(0, -2) + "\n";
                    quickAjaxAttributesText += ");";
                }
                //quickAjaxTaxonomy code
                var quickAjaxTaxonomy = null;
                if (inputData.qapl_show_select_taxonomy === 1) {
                    var quickAjaxTaxonomy = inputData.qapl_select_taxonomy;
                }
                var quickAjaxTaxonomyFilterText = "";
                var quickAjaxTermFilterText = "";
                if (quickAjaxTaxonomy !== null) {
                    quickAjaxTaxonomyFilterText = "";
                    quickAjaxTaxonomyFilterText += `$quick_ajax_taxonomy = '${quickAjaxTaxonomy}';`;
                    //qapl_quick_ajax_term_filter     
                    quickAjaxTermFilterText = "";
                    quickAjaxTermFilterText += "if(function_exists('qapl_quick_ajax_term_filter')):\n";
                    quickAjaxTermFilterText += "    qapl_quick_ajax_term_filter(\n";
                    quickAjaxTermFilterText += "        $quick_ajax_args,\n";
                    quickAjaxTermFilterText += "        $quick_ajax_attributes,\n";
                    quickAjaxTermFilterText += "        $quick_ajax_taxonomy,\n";
                    //remove last comma
                    quickAjaxTermFilterText = quickAjaxTermFilterText.slice(0, -2) + "\n";
                    quickAjaxTermFilterText += "    );\n";
                    quickAjaxTermFilterText += "endif;";
                }
                //qapl_quick_ajax_post_grid
                var quick_ajax_post_gridText = "";
                    quick_ajax_post_gridText += "if(function_exists('qapl_quick_ajax_post_grid')):\n";
                    quick_ajax_post_gridText += "   qapl_quick_ajax_post_grid(\n";
                    quick_ajax_post_gridText += "       $quick_ajax_args,\n";
                    if (quickAjaxAttributesText !== '') {
                        quick_ajax_post_gridText += "       $quick_ajax_attributes,\n";
                    }
                    //remove last comma
                    quick_ajax_post_gridText = quick_ajax_post_gridText.slice(0, -2) + "\n";
                    quick_ajax_post_gridText += "   );\n";
                    quick_ajax_post_gridText += "endif;";
    
                var formattedText = "";
                if (quickAjaxArgsText.trim() !== "") {
                    formattedText += "\n// Define AJAX query parameters for '"+inputData.qapl_select_post_type+"' type posts.\n";
                    formattedText += quickAjaxArgsText.trim() + "\n";
                }
                if (quickAjaxAttributesText.trim() !== "") {
                    formattedText += "\n// Define attributes for AJAX.\n";
                    formattedText += quickAjaxAttributesText.trim() + "\n";
                }
                if (quickAjaxTaxonomyFilterText.trim() !== "") {
                    formattedText += "\n// Set the taxonomy for filtering posts.\n";
                    formattedText += quickAjaxTaxonomyFilterText.trim() + "\n";
                }          
                if (quickAjaxTermFilterText.trim() !== "") {
                    formattedText += "\n// Render the navigation for '"+inputData.qapl_select_taxonomy+"' terms.\n";
                    formattedText += quickAjaxTermFilterText.trim() + "\n";
                }
                if (quick_ajax_post_gridText.trim() !== "") {
                    formattedText += "\n// Render the grid for '"+inputData.qapl_select_post_type+"' type posts.\n";
                    formattedText += quick_ajax_post_gridText.trim() + "\n";
                }
                var targetDiv = $('#'+outputDiv);
                targetDiv.empty();
                var lines = formattedText.split('\n');
                for (var i = 0; i < lines.length; i++) {
                    (function (index) {
                        setTimeout(function () {
                            targetDiv.append(lines[index] + '\n');
                         //scroll to the line
                         //   targetDiv.scrollTop(targetDiv[0].scrollHeight);
                            if(index === lines.length - 1){
                                button.prop('disabled', false);
                                copyButton.prop('disabled', false);
                            }
                        }, i * 50);
                    })(i);
                }
            });
        },
        quick_ajax_is_numeric: function(value) {
            return /^-?\d+(\.\d+)?$/.test(value);
        },
        quick_ajax_color_picker: function() {
            $('.color-picker-field').wpColorPicker();
        },
        quick_ajax_select_text: function(element) {
            var range, selection;
            if (document.body.createTextRange) {
                range = document.body.createTextRange();
                range.moveToElementText(element);
                range.select();
            } else if (window.getSelection) {
                selection = window.getSelection();
                range = document.createRange();
                range.selectNodeContents(element);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        },
        click_and_select_shortcode: function() {
            var self = this;
            $('.quick-ajax-shortcode').on('click', function() {
                self.quick_ajax_select_text(this);
            });
        },
        click_and_select_all: function() {
            var self = this;
            $('.click-and-select-all').on('click', function() {
                var code = $(this).find('code').get(0);
                self.quick_ajax_select_text(code);
            });
        },
        accordion_block_toggle: function() {
            // Adjusts min-height of #wpbody-content to fix sticky sidebar issue.
            var wpBodyContent = $('#wpbody-content');
            if (wpBodyContent.find('.quick-ajax-tabs').length > 0) {
                var adminMenuWrapHeight = $('#adminmenuwrap').outerHeight();
                wpBodyContent.css('min-height', adminMenuWrapHeight);
            }
            $('.quick-ajax-accordion-toggle').click(function() {
                $(this).toggleClass('active').next('.quick-ajax-accordion-content').slideToggle(200);
            });
        },
        // Define other functions here
    };

    $(document).ready(function() {
        qapl_quick_ajax_post_loader_admin_scripts.init(); // Initialize all your functions
    });
})(jQuery);
