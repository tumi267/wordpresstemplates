<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Get attributes
$posts_per_page = isset($attributes['postsPerPage']) ? intval($attributes['postsPerPage']) : 5; // Default to 5 posts
$fontFamily = isset($attributes['fontFamily']) ? sanitize_text_field($attributes['fontFamily']) : 'Inter, sans-serif'; // Default font
$textColor = isset($attributes['textColor']) ? sanitize_text_field($attributes['textColor']) : '#000000'; // Default text color
$backgroundColor = isset($attributes['backgroundColor']) ? sanitize_text_field($attributes['backgroundColor']) : '#FFFFFF'; // Default background color
$backgroundOpacity = isset($attributes['backgroundOpacity']) ? floatval($attributes['backgroundOpacity']) : 1; // Default opacity
$cutoffdate =isset($attributes['cutoffdate']) ? sanitize_text_field($attributes['cutoffdate']) : '';
// Convert background color to RGBA format
$rgbaBackgroundColor = sprintf(
    'rgba(%d, %d, %d, %.2f)',
    hexdec(substr($backgroundColor, 1, 2)), // Red
    hexdec(substr($backgroundColor, 3, 2)), // Green
    hexdec(substr($backgroundColor, 5, 2)), // Blue
    $backgroundOpacity // Opacity
);

// Fetch initial posts
$current_year = date('Y');

$posts = get_posts([
    'numberposts' => $posts_per_page,
    'post_status' => 'publish',
    'date_query'  => [
        [
            'before' => "$current_year-01-01", // Before January 1st of the current year
            'inclusive' => false,
        ]
    ]
]);

// Output the hidden div with all attributes
echo '<div id="infinite-scroll-attributes" style="display:none;" 
    data-font-family="' . esc_attr($fontFamily) . '"
    data-text-color="' . esc_attr($textColor) . '"
    data-rgba-background-color="' . esc_attr($rgbaBackgroundColor) . '"
    data-posts-per-page="' . esc_attr($posts_per_page) . '"
    data-cutoffdate="' . esc_attr($cutoffdate) . '"></div>';
?>

<div class='infinite_contain' style="font-family: <?php echo esc_attr($fontFamily); ?>;">
<div class="display-box">
        <h3>BUBBLEGUMCLUB ARCHIVE 2014-2024</h3>
        <p id="toggle-filters" style="cursor: pointer;">SHOW FILTERS</p>
    </div>
    <!-- Filter Section -->
    <div class="filter-container " id="filter-container" style="display: none;">
    
    
        <div class="filter_box">
            <h3 class="filter_head" style="color: <?php echo esc_attr($textColor); ?>;">YEARS</h3>
            <ul class='filter_item_box' id="year-filter" style="color: <?php echo esc_attr($textColor); ?>;">
                <li data-value="">All Years</li>
                <!-- Years will be populated dynamically -->
            </ul>
        </div>
        <div>
            <h3 class="filter_head" style="color: <?php echo esc_attr($textColor); ?>;">CATEGORIES</h3>
            <ul class='filter_item_box' id="category-filter" style="color: <?php echo esc_attr($textColor); ?>;">
                <li data-value="">All Categories</li>
                <!-- Categories will be populated dynamically -->
            </ul>
        </div>
        <!-- <div>
            <h3 class="filter_head" style="color: <?php echo esc_attr($textColor); ?>;">AUTHORS</h3>
            <ul class='filter_item_box' id="author-filter" style="color: <?php echo esc_attr($textColor); ?>;">
                <li data-value="">All Authors</li> -->
                <!-- Authors will be populated dynamically -->
            <!-- </ul>
        </div> -->
        <div class='search-filter-contain'>
           
            <input class='search_input_infinte infinte_srcoll_search' placeholder='Filter by search' />
            <div>&nbsp;</div>
            <button id="clear-filters" style="color: <?php echo esc_attr($textColor); ?>;">Clear Filters</button>
        </div>
    
</div>

    <!-- Infinite Scroll Section -->
    <div id="infinite-scroll-container" style="color: <?php echo esc_attr($textColor); ?>;">
        <?php if (empty($posts)) : ?>
            <p><?php esc_html_e('No posts found.', 'custom-posts-block'); ?></p>
        <?php else : ?>
            <?php foreach ($posts as $post) : ?>
                <?php
                $featured_image = get_the_post_thumbnail_url($post->ID, 'large') ?: '';
                $author_name = get_the_author_meta('display_name', $post->post_author) ?: 'Unknown';
                $post_date = get_the_date('', $post->ID);
                $post_permalink = get_permalink($post->ID); // Get the post's permalink
                ?>
                <a class="infinite_scroll_card short_tag" href="<?php echo esc_url($post_permalink); ?>" style="background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>;" data-postid="<?php echo esc_attr($post->ID); ?>">
                    <?php if ($featured_image) : ?>
                        <img class="infinite_scroll_card_image" src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>" />
                    <?php else : ?>
                        <div class="no-image">&nbsp;</div>
                    <?php endif; ?>
                    <?php
                    // Get the current year
                    $currentYear = date("Y");

                    // Get the post's publication year
                    $archiveYear = intval($postDate); // Ensure it's an integer

                    // Check if the current year is greater than the post's year
                    if (2024 > $archiveYear) {
                    echo "<div class='achrive_post'><h4>ARCHIVE</h4></div>";
                    }   
                    ?>
                   
                    <h4 class="infinite_scroll_card_byline" ><?php
                    // Get the categories for the post
                    $categories = get_the_category($post->ID);

                    if (!empty($categories)) {
                    // Get the name of the first category
                    $category_name = esc_html($categories[0]->name);
                    echo $category_name;
                    }
                    ?></h4>
                    <h3 class="infinite_scroll_card_text" style="color: <?php echo esc_attr($textColor); ?>;"><?php echo esc_html(get_the_title($post->ID)); ?></h3>
                    <h4 class="infinite_scroll_card_author" >by <?php echo esc_html($author_name); ?> on <?php echo esc_html($post_date); ?></h4>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Loading Indicator -->
    <div id="loading-indicator" style="display: none; color: <?php echo esc_attr($textColor); ?>;">Loading...</div>

    <!-- Sentinel Element -->
    <div id="sentinel" style="height: 1px;"></div>
</div>