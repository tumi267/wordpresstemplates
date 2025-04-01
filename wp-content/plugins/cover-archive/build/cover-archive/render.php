<?php
// Get attributes passed from the block editor (from edit.js)
$postTitle        = isset($attributes['postTitle']) ? $attributes['postTitle'] : '';
$postExcerpt      = isset($attributes['postExcerpt']) ? $attributes['postExcerpt'] : '';
$postImage        = isset($attributes['postImage']) ? $attributes['postImage'] : '';
$postArticle      = isset($attributes['postArticle']) ? $attributes['postArticle'] : '';
$postCategory     = isset($attributes['postCategory']) ? $attributes['postCategory'] : '';
$fontFamily       = isset($attributes['fontFamily']) ? $attributes['fontFamily'] : 'Inter, sans-serif';
$textColor        = isset($attributes['textColor']) ? $attributes['textColor'] : '#000000'; // Default to black
$backgroundColor  = isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : '#FFFFFF'; // Default to white
$backgroundOpacity = isset($attributes['backgroundOpacity']) ? $attributes['backgroundOpacity'] : 1; // Default to fully opaque
$showTitle        = isset($attributes['showTitle']) ? (bool) $attributes['showTitle'] : true;
$showExcerpt      = isset($attributes['showExcerpt']) ? (bool) $attributes['showExcerpt'] : true;
$showByLine       = isset($attributes['showByLine']) ? (bool) $attributes['showByLine'] : true;
$postId           =isset($attributes['postId'])?$attributes['postId']:'0';
// Convert background color to RGBA format (for opacity)
$rgbaBackgroundColor = sprintf(
    'rgba(%d, %d, %d, %.2f)',
    hexdec(substr($backgroundColor, 1, 2)), // Red
    hexdec(substr($backgroundColor, 3, 2)), // Green
    hexdec(substr($backgroundColor, 5, 2)), // Blue
    $backgroundOpacity // Opacity
);

$postUrl = '';
$post_id = 0; // Initialize $post_id

// Fetch posts based on category or specific article (postArticle)
if (!empty($postCategory)) {
    // Query posts by category
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
            $post_id    = get_the_ID(); // Set $post_id
            $postTitle   = get_the_title();
            $postExcerpt = get_the_excerpt();
            $postImage   = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: $postImage;
            $postUrl     = get_permalink();
            $byline      = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
        }
        wp_reset_postdata();
    }
} elseif (!empty($postArticle)) {
    // Query posts by title (exact match for article)
    global $wpdb;
    $post_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE post_title LIKE %s AND post_type = 'post' AND post_status = 'publish'",
            '%' . $wpdb->esc_like($postArticle) . '%'
        )
    );

    if ($post_id) {
        // If found, fetch post data
        $post = get_post($post_id);
        $postTitle   = $post->post_title;
        $postExcerpt = get_the_excerpt();
        $postImage   = get_the_post_thumbnail_url($post_id, 'full') ?: $postImage;
        $postUrl     = get_permalink($post_id);
        $byline      = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
    } else {
        // If no match, fall back to latest post
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
                $post_id    = get_the_ID(); // Set $post_id
                $postTitle   = get_the_title();
                $postExcerpt = get_the_excerpt();
                $postImage   = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: $postImage;
                $postUrl     = get_permalink();
                $byline      = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
            }
            wp_reset_postdata();
        } else {
            echo '<h2>' . esc_html__('No posts found. Check database.', 'custom-posts-block') . '</h2>';
        }
    }
} else {
    // Fallback to latest post if no category or article provided
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
            $post_id    = get_the_ID(); // Set $post_id
            $postTitle   = get_the_title();
            $postExcerpt = get_the_excerpt();
            $postImage   = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: $postImage;
            $postUrl     = get_permalink();
            $byline      = sprintf(__('By %s on %s', 'custom-posts-block'), get_the_author_meta('display_name', $post->post_author), get_the_date('', $post->ID));
        }
        wp_reset_postdata();
    } else {
        echo '<h2>' . esc_html__('No posts found. Check database.', 'custom-posts-block') . '</h2>';
    }
}
?>

<div <?php echo get_block_wrapper_attributes(); ?> style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo esc_attr($textColor); ?>; background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>;">
    <?php if (empty($postTitle) && empty($postExcerpt) && empty($postImage)) : ?>
        <p><?php esc_html_e('No post data available.', 'custom-posts-block'); ?></p>
    <?php else : ?>
        <div class="cover_contain_archive" data-postid="<?php echo esc_attr($postId); ?>" >
            <a class="cover_contain_atag" href="<?php echo esc_url($postUrl); ?>" style="font-family: <?php echo esc_attr($fontFamily); ?>; 
            color: <?php echo esc_attr($textColor); ?>; 
            ">


                <div class="cover_text" >
                <?php
                // Check if the post is from a previous year
                $currentYear = date('Y');
                $postYear = date('Y', strtotime($postDate));
                if ($currentYear > $postYear) {
                    echo '<div class="cover_achrive_post_cover"><h3 >ARCHIVE</h3></div>';
                }
                ?>
                    <?php if ($showTitle && $postTitle) : ?>
                        <h1><?php echo esc_html($postTitle); ?></h1>
                    <?php endif; ?>

                    <?php if ($showExcerpt && $postExcerpt) : ?>
                        <h3 class="excurpt_cover"><?php echo wp_kses_post($postExcerpt); ?></h3>
                    <?php endif; ?>

                    <?php if ($showByLine) : ?>
                        <h4> By: <span ><?php echo esc_html(get_the_author_meta('display_name', $post->post_author)); ?></span> <span ><?php echo esc_html(get_the_date('', $post_id)); ?></span></h4>
                    <?php endif; ?>
                </div>
            </a>

            <?php if ($postImage) : ?>
                <img class="post_img" src="<?php echo esc_url($postImage); ?>" alt="<?php echo esc_attr($postTitle); ?>" />
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>