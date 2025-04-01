<?php
/**
 * Render callback for the Randomized Archive Block.
 */

// Get attributes with defaults
$post_count = isset($attributes['postCount']) ? intval($attributes['postCount']) : 6;
$current_year = date('Y');

// Fetch posts before the current year
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 100, // Fetch a large set for better randomization
    'orderby'        => 'date',
    'order'          => 'DESC',
    'date_query'     => array(
        array(
            'before' => "$current_year-01-01",
            'inclusive' => false,
        ),
    ),
);

$query = new WP_Query($args);
$posts = $query->posts;

// Shuffle and limit to desired count
shuffle($posts);
$random_posts = array_slice($posts, 0, $post_count);

?>

<div class="card-contain" <?php echo get_block_wrapper_attributes(); ?>>
    <?php foreach ($random_posts as $post) : 
        $post_id = $post->ID;
        $post_link = get_permalink($post_id);
        $post_title = get_the_title($post_id);
        $featured_image = get_the_post_thumbnail_url($post_id, 'full');
        $author_name = get_the_author_meta('display_name', $post->post_author);
        $post_date = get_the_date('F j, Y', $post_id); // Formats as "Month Day, Year"
        $categories = get_the_category($post_id);
        $category_name = !empty($categories) ? esc_html($categories[0]->name) : __('Uncategorized', 'randomized-archive-block');

        // Limit title to 20 words
        $words = explode(' ', wp_strip_all_tags($post_title));
        $limited_title = implode(' ', array_slice($words, 0, 20));
    ?>
        <div class="card">
            <a href="<?php echo esc_url($post_link); ?>">
                <div>
                    <?php if ($featured_image) : ?>
                        <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($post_title); ?>" style="width: 100%;" />
                    <?php else : ?>
                        <div class="no-image-posts">&nbsp;</div>
                    <?php endif; ?>

                    <div class="achrive_post"><h4>ARCHIVE</h4></div>
                    <h4 class="card_article_title"><?php echo esc_html($category_name); ?></h4>
                    <h3 class="card_article_text"><?php echo esc_html($limited_title); ?></h3>
                    <h4 class="card_article_title"><?php echo sprintf(__('By %s | %s', 'randomized-archive-block'), esc_html($author_name), esc_html($post_date)); ?></h4>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>
