<?php
/**
 * Title: Get Posts by tag
 * Slug: themeslug/post_tag
 * Categories: featured
 */

$args = array(
    'tag'            => 'tag-one', // Use commas to separate multiple tags
    'posts_per_page' => 6, // Fetch 6 posts
    'orderby'        => 'date', // Order by latest posts
    'order'          => 'DESC', // Show newest posts first
);

$query = new WP_Query($args);
echo '<div class="card-container">';

if ($query->have_posts()) :
    while ($query->have_posts()) :
        $query->the_post();
        ?>
        <div class="card">
            <div class="card-image">
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php the_title_attribute(); ?>">
                <?php else : ?>
                    <img src="https://via.placeholder.com/300/cccccc/ffffff?text=No+Image" alt="Placeholder Image">
                <?php endif; ?>
            </div>
            <div class="card-content">
                <h3><?php the_title(); ?></h3>
                <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                <p>Posted on: <?php echo get_the_date(); ?> by <?php the_author(); ?></p>
                <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata(); // Reset post data after loop
else :
    echo '<p>No posts found in this category.</p>';
endif;

echo '</div>';
?>