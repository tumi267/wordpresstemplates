<?php
// Get attributes
$postTitle   = isset($attributes['postTitle']) ? $attributes['postTitle'] : '';
$postExcerpt = isset($attributes['postExcerpt']) ? $attributes['postExcerpt'] : '';
$postImage   = isset($attributes['postImage']) ? $attributes['postImage'] : '';
$postArticle = isset($attributes['postArticle']) ? $attributes['postArticle'] : '';
$postCategory = isset($attributes['postCategory']) ? $attributes['postCategory'] : '';
$fontFamily  = isset($attributes['fontFamily']) ? $attributes['fontFamily'] : 'Inter, sans-serif';
$textColor   = isset($attributes['textColor']) ? $attributes['textColor'] : '#000000'; // Default to black
$backgroundColor = isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : '#FFFFFF'; // Default to white
$backgroundOpacity = isset($attributes['backgroundOpacity']) ? $attributes['backgroundOpacity'] : 1; // Default to fully opaque
$showTitle   = isset($attributes['showTitle']) ? (bool) $attributes['showTitle'] : true; // Default to true if not provided
$showExcurpt = isset($attributes['showExcurpt']) ? (bool) $attributes['showExcurpt'] : true; // Default to true if not provided
$showByLine = isset($attributes['showByLine'])?(bool)$attributes['showByLine']:true;
// Convert background color to RGBA format
$rgbaBackgroundColor = sprintf(
    'rgba(%d, %d, %d, %.2f)',
    hexdec(substr($backgroundColor, 1, 2)), // Red
    hexdec(substr($backgroundColor, 3, 2)), // Green
    hexdec(substr($backgroundColor, 5, 2)), // Blue
    $backgroundOpacity // Opacity
);
$postUrl = '';
// If a specific category is provided, fetch the latest post from that category
if (!empty($postCategory)) {
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'category__in'   => [$postCategory],
        'no_found_rows'  => true,
        'cache_results'  => false,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Update variables with the latest post data from the category
            $postTitle   = get_the_title();
            $postExcerpt = get_the_excerpt();
            $postImage   = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: $postImage;
            $postUrl     = get_permalink();
            $byline = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
        }
        wp_reset_postdata();
    } else {
        echo '<h2>' . esc_html__('No posts found in the specified category.', 'custom-posts-block') . '</h2>';
    }
}
// If a specific article is provided, search for it by exact title
elseif (!empty($postArticle)) {
    global $wpdb;
    $post_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE post_title LIKE %s AND post_type = 'post' AND post_status = 'publish'",
            '%' . $wpdb->esc_like($postArticle) . '%'
        )
    );

    if ($post_id) {
        // If a post with the exact title is found, fetch its data
        $post = get_post($post_id);
        $postTitle   = $post->post_title;
        $postExcerpt = $post->post_excerpt;
        $postImage   = get_the_post_thumbnail_url($post_id, 'full') ?: $postImage;
        $postUrl = get_permalink($post_id);
        $byline = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
       
    } else {
        // If no exact match is found, fall back to fetching the latest post
        $fallback_args = [
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
            'cache_results'  => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ];
        
        $fallback_query = new WP_Query($fallback_args);

        if ($fallback_query->have_posts()) {
            while ($fallback_query->have_posts()) {
                $fallback_query->the_post();

                // Update variables with the latest post data
                $postTitle   = get_the_title();
                $postExcerpt = get_the_excerpt();
                $postImage   = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: $postImage;
                $postUrl     = get_permalink();
                $byline = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
            }
            wp_reset_postdata();
        } else {
            echo '<h2>' . esc_html__('No posts found. Check database.', 'custom-posts-block') . '</h2>';
        }
    }
} else {
    // If no postArticle or postCategory is provided, fetch the latest post
    $fallback_args = [
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
        'cache_results'  => false,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ];

    $fallback_query = new WP_Query($fallback_args);

    if ($fallback_query->have_posts()) {
        while ($fallback_query->have_posts()) {
            $fallback_query->the_post();

            // Update variables with the latest post data
            $postTitle   = get_the_title();
            $postExcerpt = get_the_excerpt();
            $postImage   = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: $postImage;
            $postUrl     = get_permalink();
            $byline = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
        }
        wp_reset_postdata();
    } else {
        echo '<h2>' . esc_html__('No posts found. Check database.', 'custom-posts-block') . '</h2>';
    }
}
?>

<div  <?php echo get_block_wrapper_attributes(); ?> style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo esc_attr($textColor); ?>; background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>;">
    <?php if (empty($postTitle) && empty($postExcerpt) && empty($postImage)) : ?>
        <p><?php esc_html_e('No post data available.', 'custom-posts-block'); ?></p>
    <?php else : ?>
        <div class="cover_contain">
            <?php if ($postImage) : ?>
                <img class='post_img'
                    src="<?php echo esc_url($postImage); ?>" 
                    alt="<?php echo esc_attr($postTitle); ?>" 
                >

            <?php endif; ?>
            <a class='cover_a_contain' href="<?php echo esc_url($postUrl); ?>" style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo esc_attr($textColor); ?>; ">
            <?php
                                // Get the current year
                    $currentYear = date("Y");

                                // Get the post's publication year
                    $postDate = get_the_date('Y', $post->ID);// Retrieves the year of the post
                    $archiveYear = intval($postDate);// Ensure it's an integer

                                // Check if the current year is greater than the post's year
                                if ($currentYear > $archiveYear) {
                                echo "<div class='cover_achrive_post'><h3>ARCHIVE</h3></div>";
                                }   
                ?>
            <div class="cover_text">
                <?php if ($showTitle && $postTitle) : ?>
                    <h1><?php echo esc_html($postTitle); ?></h1>
                <?php endif; ?>

                <?php if ($showExcurpt && $postExcerpt) : ?>
                    <h3 class='cover_text excurpt_cover'><?php echo wp_kses_post(wp_trim_words($postExcerpt, 20)); ?></h3>
                <?php endif; ?>
                <?php if ($showByLine && $byline) : ?>
                    <h4><?php echo esc_html($byline); ?></h4>
                <?php endif; ?>
               
            </div>
            </a>
        </div>
    <?php endif; ?>
</div>