<?php
/**
 * Render callback for the custom post hero block.
 */

// Get attributes with defaults
$fontFamily = isset($attributes['imageFontFamily']) ? sanitize_text_field($attributes['imageFontFamily']) : 'Inter, sans-serif';
$textColor = isset($attributes['imageTextColor']) ? sanitize_text_field($attributes['imageTextColor']) : '#000000';
$backgroundColor = isset($attributes['imageBackgroundColor']) ? sanitize_text_field($attributes['imageBackgroundColor']) : '#FFFFFF';
$backgroundOpacity = isset($attributes['imageBackgroundOpacity']) ? floatval($attributes['imageBackgroundOpacity']) : 1;
$contentFontFamily = isset($attributes['contentFontFamily']) ? sanitize_text_field($attributes['contentFontFamily']) : 'Inter, sans-serif';
$contentTextColor = isset($attributes['contentTextColor']) ? sanitize_text_field($attributes['contentTextColor']) : '#000000';
$contentBackgroundColor = isset($attributes['contentBackgroundColor']) ? sanitize_text_field($attributes['contentBackgroundColor']) : '#FFFFFF';
$contentBackgroundOpacity = isset($attributes['contentBackgroundOpacity']) ? floatval($attributes['contentBackgroundOpacity']) : 1;

// Convert hex to RGBA function
function hexToRgba($hex, $opacity) {
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) === 6) {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return "rgba($r, $g, $b, $opacity)";
    }
    return "rgba(255, 255, 255, $opacity)"; // Default to white
}

$rgbaBackgroundColor = hexToRgba($backgroundColor, $backgroundOpacity);
$rgbaContentBackgroundColor = hexToRgba($contentBackgroundColor, $contentBackgroundOpacity);

// Get the current post ID
$post_id = get_the_ID();

// Get the post title, featured image, and content
$postTitle = $post_id ? get_the_title($post_id) : __('Default Title', 'custom-posts-block');
$postImage = $post_id ? get_the_post_thumbnail_url($post_id, 'full') : null;
$postContent = $post_id ? apply_filters('the_content', get_post_field('post_content', $post_id)) : __('No content available', 'custom-posts-block');



// Get post data
$author_name = get_the_author();
$post_date = get_the_date('F j, Y'); // Formats as "Month Day, Year"

// Construct the byline with a line break
$byline = esc_html($author_name) . '<br>' . esc_html($post_date);

?>

<div class='post_conatin' <?php echo get_block_wrapper_attributes(); ?> style="font-family: <?php echo esc_attr($fontFamily); ?>;">
    <div class="post-hero" style="background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>; color: <?php echo esc_attr($textColor); ?>;">
        <?php if ($postImage) : ?>
            <img class="post-hero-image" src="<?php echo esc_url($postImage); ?>" alt="<?php echo esc_attr($postTitle); ?>">
        <?php else: ?>
            <div class="post-hero_noimage">&nbsp;</div>
        <?php endif; ?>
        <div class="post-hero-text" style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo empty($postImage) ? '#ffffff' : esc_attr($textColor); ?>;">
        <h1><?php echo esc_html($postTitle); ?></h1>
        </div>
    </div>
    
    <div class="post-content-box-conatin" style="font-family: <?php echo esc_attr($contentFontFamily); ?>; background-color: <?php echo esc_attr($rgbaContentBackgroundColor); ?>; color: <?php echo esc_attr($contentTextColor); ?>;">
        <div class="post-content-byline-box" style=', color: #B7B4B4'>  <?php echo wp_kses_post($byline); ?></div>
        <div class="post-content-box">
            <?php echo wp_kses_post($postContent); ?>
        </div>
    </div>
</div>


