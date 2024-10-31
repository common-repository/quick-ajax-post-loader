<?php 
if (!defined('ABSPATH')) {
    exit;
}

$accordion_block_title = 'add_action: List of Available Actions';
$accordion_block_content = '<p><strong>Description:</strong> The actions available through <code class="code-tag">add_action</code> in <strong>Quick Ajax Post Loader</strong> allow for custom modifications at key moments of the plugin\'s operation. These hooks enable developers to customize the rendering process of filters, post content, and other elements, providing greater flexibility and possibilities for extending functionality.</p>';
$accordion_block_content .= '<h4>Available Actions</h4>';
$accordion_block_content .= '<ul>';

// Filter wrapper actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_pre</strong></code>: Before rendering the AJAX filter wrapper. Perfect for adding custom HTML.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_open</strong></code>: At the beginning of the AJAX filter wrapper rendering. Allows for inserting content at the start.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_close</strong></code>: At the end of the AJAX filter wrapper rendering. Enables adding content before closing the wrapper.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_complete</strong></code>: After rendering the AJAX filter wrapper.</li>';

// Posts wrapper actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_pre</strong></code>: Before rendering the AJAX posts wrapper.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_open</strong></code>: Right after opening the posts wrapper. Ideal for adding your own content at the beginning of the section.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_close</strong></code>: Just before closing the posts wrapper. Allows for adding content at the end of the posts section.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_complete</strong></code>: After rendering the AJAX posts wrapper.</li>';

// Load more button actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_load_more_button_pre</strong></code>: Before rendering the "Load More" button. Allows for adding content before the button.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_load_more_button_complete</strong></code>: After rendering the "Load More" button. Allows for adding content after the button.</li>';

// Loader icon actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_loader_icon_pre</strong></code>: Before rendering the loading icon. Perfect for adding content before the icon.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_loader_icon_complete</strong></code>: After rendering the loading icon. Enables adding content after the icon.</li>';

$accordion_block_content .= '</ul>';
$accordion_block_content .= '<h4>How to Use</h4>';
$accordion_block_content .= '<p>Adding your own actions is straightforward using the <code class="code-tag">add_action()</code> function. Below is an example of how to add custom text before the AJAX filter wrapper:</p>';
$accordion_block_content .= '<pre><code class="no-background">';
$accordion_block_content .= htmlentities("add_action('qapl_filter_wrapper_pre', function() {") . "\n";
$accordion_block_content .= htmlentities("    echo 'Custom text before the filter navigation';") . "\n";
$accordion_block_content .= htmlentities('});') . "\n";
$accordion_block_content .= '</code></pre>';
$accordion_block_content .= '<p>Using the appropriate hooks makes it easy to customize different aspects of the plugin\'s operation according to the needs of your site.</p>';

return [
    'title' => $accordion_block_title,
    'content' => $accordion_block_content,
];
