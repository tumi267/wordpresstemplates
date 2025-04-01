<?php
// Get attributes
$postTag      = isset($attributes['postTag']) ? sanitize_text_field($attributes['postTag']) : '';
$postCategory = isset($attributes['postCategory']) ? sanitize_text_field($attributes['postCategory']) : '';
$postCount    = isset($attributes['postCount']) ? intval($attributes['postCount']) : 6;
$fontFamily   = isset($attributes['fontFamily']) ? sanitize_text_field($attributes['fontFamily']) : 'Inter, sans-serif'; // Default font
$textColor    = isset($attributes['textColor']) ? sanitize_text_field($attributes['textColor']) : '#000000'; // Default text color
$backgroundColor = isset($attributes['backgroundColor']) ? sanitize_text_field($attributes['backgroundColor']) : '#FFFFFF'; // Default background color
$backgroundOpacity = isset($attributes['backgroundOpacity']) ? floatval($attributes['backgroundOpacity']) : 1; // Default opacity

// Convert background color to RGBA format
$rgbaBackgroundColor = sprintf(
    'rgba(%d, %d, %d, %.2f)',
    hexdec(substr($backgroundColor, 1, 2)), // Red
    hexdec(substr($backgroundColor, 3, 2)), // Green
    hexdec(substr($backgroundColor, 5, 2)), // Blue
    $backgroundOpacity // Opacity
);

// Fetch the tag ID based on the provided tag slug
$tag_id = null;
if ($postTag) {
    $tag = get_term_by('slug', $postTag, 'post_tag');
    if ($tag) {
        $tag_id = $tag->term_id;
    }
}

// Fetch the category ID based on the provided category slug
$category_id = null;
if ($postCategory) {
    $category = get_term_by('slug', $postCategory, 'category');
    if ($category) {
        $category_id = $category->term_id;
    }
}

// Build the query arguments
$query_args = [
    'post_type'      => 'post',
    'posts_per_page' => $postCount +1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_key'       => '_thumbnail_id', // Ensure posts with thumbnails are included
];

// Add tag filter if a tag is selected
if ($tag_id) {
    $query_args['tag_id'] = $tag_id;
}

// Add category filter if a category is selected
if ($category_id) {
    $query_args['cat'] = $category_id;
}

// Execute the query
$posts_query = new WP_Query($query_args);
$posts = $posts_query->have_posts() ? $posts_query->posts : [];

// Remove the first post from the fetched posts
if (!empty($posts)) {
    array_shift($posts); // Remove the first element from the array
}


// Determine the container class based on post count
$container_class = $postCount < 3 ? 'card-contain2' : 'card-contain';
?>

<div class='infinte_contain' <?php echo get_block_wrapper_attributes(); ?> style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo esc_attr($textColor); ?>;">
    <?php if (empty($posts)) : ?>
        <p><?php esc_html_e('No posts found.', 'custom-posts-block'); ?></p>
    <?php else : ?>
        <div class="<?php echo esc_attr($container_class); ?>">
            <?php foreach ($posts as $post) : ?>
                <?php
                    // Dynamically adjust image size based on post count
                    $image_size = $postCount == 1 ? 'large' : 'medium';
                    $featured_image = get_the_post_thumbnail_url($post->ID, $image_size) ?: '';
                    $byline = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
                    
                    // Set custom height if postCount is 1
                    $image_height = $postCount == 1 ? '250px' : '';  // Empty string for auto handling
                ?>
                <div class="card" style="background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>; color: <?php echo esc_attr($textColor); ?>;">
                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                        <div>
                            <?php if ($featured_image) : ?>
                                <img 
                                    src="<?php echo esc_url($featured_image); ?>" 
                                    alt="<?php echo esc_attr(get_the_title($post->ID)); ?>" 
                                    srcset="<?php echo esc_url($featured_image); ?> 1x, <?php echo esc_url($featured_image); ?> 2x"
                                    style="width: 100%; height: <?php echo esc_attr($image_height); ?>;">
                                <?php else : ?>
                                    <div class="no-image-post">&nbsp;</div>
                                <?php endif; ?>
                            <h4 class="card_artical_title" ><?php
                                                                // Get the categories for the post
                                                                $categories = get_the_category($post->ID);

                                                                if (!empty($categories)) {
                                                                // Get the name of the first category
                                                                $category_name = esc_html($categories[0]->name);
                                                                echo $category_name;
                                                                }
                                                                ?></h4>
                            
                            <h3 class="card_artical_text" style="color: <?php echo esc_attr($textColor); ?>;"><?php echo esc_html(get_the_title($post->ID)); ?></h3>

                            <h4 class="card_artical_title" ><?php echo esc_html($byline); ?></h4>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>