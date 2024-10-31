<?php 
if (!defined('ABSPATH')) {
    exit;
}

$accordion_block_title = 'add_action: Lista dostępnych akcji';
$accordion_block_content = '<p><strong>Opis:</strong> Akcje dostępne za pomocą <code class="code-tag">add_action</code> w <strong>Quick Ajax Post Loader</strong> pozwalają na wprowadzenie niestandardowych modyfikacji w kluczowych momentach działania pluginu. Dzięki tym hookom, deweloperzy mogą dostosowywać proces renderowania filtrów, zawartości postów oraz innych elementów, zapewniając większą elastyczność i możliwości rozszerzenia funkcjonalności.</p>';
$accordion_block_content .= '<h4>Dostępne Akcje</h4>';
$accordion_block_content .= '<ul>';

// Filter wrapper actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_pre</strong></code>: Przed renderowaniem wrappera filtrów AJAX. Idealne do dodawania niestandardowego HTML.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_open</strong></code>: Na początku renderowania wrappera filtrów. Umożliwia wstawienie zawartości na początku.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_close</strong></code>: Na końcu renderowania wrappera filtrów. Pozwala na dodanie zawartości przed zamknięciem wrappera.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_filter_wrapper_complete</strong></code>: Po wyrenderowaniu wrappera filtrów.</li>';

// Posts wrapper actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_pre</strong></code>: Przed renderowaniem wrappera postów AJAX.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_open</strong></code>: Zaraz po otwarciu wrappera postów. Idealne do dodawania własnej zawartości na początku sekcji.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_close</strong></code>: Zaraz przed zamknięciem wrappera postów. Pozwala na dodanie zawartości na końcu sekcji postów.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_posts_wrapper_complete</strong></code>: Po wyrenderowaniu wrappera postów AJAX.</li>';

// Load more button actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_load_more_button_pre</strong></code>: Przed wyrenderowaniem przycisku "Załaduj więcej". Umożliwia dodanie treści przed przyciskiem.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_load_more_button_complete</strong></code>: Po wyrenderowaniu przycisku "Załaduj więcej". Pozwala na dodanie treści po przycisku.</li>';

// Loader icon actions
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_loader_icon_pre</strong></code>: Przed wyrenderowaniem ikony ładowania. Idealne do dodania treści przed ikoną.</li>';
$accordion_block_content .= '<li><code class="no-background"><strong>qapl_loader_icon_complete</strong></code>: Po wyrenderowaniu ikony ładowania. Umożliwia dodanie treści po ikonie.</li>';

$accordion_block_content .= '</ul>';
$accordion_block_content .= '<h4>Jak Korzystać</h4>';
$accordion_block_content .= '<p>Dodanie własnych akcji jest proste za pomocą funkcji <code class="code-tag">add_action()</code>. Poniżej przykład, jak dodać niestandardowy tekst przed wrappera filtrów AJAX:</p>';
$accordion_block_content .= '<pre><code class="no-background">';
$accordion_block_content .= htmlentities("add_action('qapl_filter_wrapper_pre', function() {") . "\n";
$accordion_block_content .= htmlentities("    echo 'Niestandardowy tekst przed nawigacją filtrów';") . "\n";
$accordion_block_content .= htmlentities('});') . "\n";
$accordion_block_content .= '</code></pre>';
$accordion_block_content .= '<p>Korzystanie z odpowiednich hooków umożliwia łatwe dostosowanie różnych aspektów działania pluginu, zgodnie z potrzebami Twojej witryny.</p>';

return [
    'title' => $accordion_block_title,
    'content' => $accordion_block_content,
];
