<?php
/**
 * Render callback for the related posts block.
 */

// Get attributes
$postCount = isset($attributes['postCount']) ? intval($attributes['postCount']) : 6;
$fontFamily = isset($attributes['fontFamily']) ? sanitize_text_field($attributes['fontFamily']) : 'Inter, sans-serif';
$textColor = isset($attributes['textColor']) ? sanitize_text_field($attributes['textColor']) : '#000000';
$backgroundColor = isset($attributes['backgroundColor']) ? sanitize_text_field($attributes['backgroundColor']) : '#FFFFFF';
$backgroundOpacity = isset($attributes['backgroundOpacity']) ? floatval($attributes['backgroundOpacity']) : 1;

// Convert background color to RGBA format
$rgbaBackgroundColor = sprintf(
    'rgba(%d, %d, %d, %.2f)',
    hexdec(substr($backgroundColor, 1, 2)), 
    hexdec(substr($backgroundColor, 3, 2)), 
    hexdec(substr($backgroundColor, 5, 2)), 
    $backgroundOpacity
);

// Get the current post ID and data
$post_id = get_the_ID();
$post = get_post($post_id);
$related_posts = [];

if ($post) {
    $tag_ids = wp_get_post_tags($post_id, ['fields' => 'ids']);
    $category_ids = wp_get_post_categories($post_id);

    if ($tag_ids || $category_ids) {
        $query_args = [
            'post_type'           => 'post',
            'posts_per_page'      => $postCount,
            'tag__in'             => $tag_ids,
            'category__in'        => $category_ids,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'post__not_in'        => [$post_id],
            'ignore_sticky_posts' => true,
        ];

        $query = new WP_Query($query_args);
        $related_posts = $query->have_posts() ? $query->posts : [];
    }
}

// Set container class based on post count
$container_class = 'related_contain';
?>

<div <?php echo get_block_wrapper_attributes(); ?> style="font-family: <?php echo esc_attr($fontFamily); ?>;">
    <div class="<?php echo esc_attr($container_class); ?>">
        <?php if (empty($related_posts)) : ?>
            <p><?php esc_html_e('No related posts available.', 'custom-posts-block'); ?></p>
        <?php else : ?>
            <ul class="related-posts-list">
                <?php foreach ($related_posts as $related_post) : 
                    setup_postdata($related_post);
                    $featured_image = get_the_post_thumbnail_url($related_post->ID, 'medium') ?: '/default-image.jpg';
                    $author_name = get_the_author_meta('display_name', $related_post->post_author) ?: 'Unknown';
                    $post_date = get_the_date('', $related_post->ID);
                    $formatted_date = date_i18n('j F Y', strtotime($post_date));
                    
                    $byline = sprintf(__('By %s on %s', 'custom-posts-block'), $author_name, $formatted_date);
                ?>
                    <li class="related-post-item">
                        <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>" class="related-post-link">
                            <div style="background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>;">
                                <?php if ($featured_image !== '/default-image.jpg') : ?>
                                    <img src="<?php echo esc_url($featured_image); ?>" 
                                        alt="<?php echo esc_attr(get_the_title($related_post->ID)); ?>" 
                                        class="related-post-image">
                                <?php else : ?>
                                    <div class="no-image">&nbsp;</div>
                                <?php endif; ?>
                                <?php
                                // Get the current year
                                $currentYear = date("Y");

                                // Get the post's publication year
                                $postDate = get_the_date('Y', $related_post->ID);// Retrieves the year of the post
                                $archiveYear = intval($postDate);// Ensure it's an integer

                                // Check if the current year is greater than the post's year
                                if ($currentYear > $archiveYear) {
                                echo "<div class='achrive_post'><h4>ARCHIVE </h4></div>";
                                }   
                                ?>
                                <h4 class="related_card_byline" ><?php
                                    // Get the categories for the post
                                    $categories = get_the_category($post->ID);

                                    if (!empty($categories)) {
                                    // Get the name of the first category
                                    $category_name = esc_html($categories[0]->name);
                                    echo $category_name;
                                    }
                                ?></h4>
                                <h3 class='.related-card_title'>
                                    <?php echo esc_html(get_the_title($related_post->ID)); ?>
                                </h3>

                                <h4 class="related_card_byline">
                                    <?php echo esc_html($byline); ?>
                                </h4>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
