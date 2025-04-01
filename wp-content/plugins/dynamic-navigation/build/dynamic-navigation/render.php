<?php
/**
 * Render callback for the custom navigation block.
 */
// Fetch custom navigation attributes from the database
$nav_attributes = get_option('custom_site_attributes', []);

// Ensure it's an array
$nav_attributes = is_array($nav_attributes) ? $nav_attributes : [];

// Merge with block attributes, giving priority to block settings
$attributes = array_merge($nav_attributes, $attributes ?? []);

// Extract attributes with defaults
$selectedPages      = $attributes['selectedPages']      ?? [];
$fontFamily        = $nav_attributes['fontFamily']        ?? 'Inter, sans-serif';
$textColor         = $nav_attributes['textColor']         ?? '#000000';
$backgroundColor   = $nav_attributes['backgroundColor']   ;
$backgroundOpacity = $nav_attributes['backgroundOpacity'] ?? 1;
$logoUrl           = $nav_attributes['logoUrl']           ?? '';

$home_url = home_url();
// Convert background color to RGBA format
$rgbaBackgroundColor = sprintf(
    'rgba(%d, %d, %d, %.2f)',
    hexdec(substr($backgroundColor, 1, 2)), 
    hexdec(substr($backgroundColor, 3, 2)), 
    hexdec(substr($backgroundColor, 5, 2)), 
    $backgroundOpacity
);

// Check if category display is enabled
$categoryDisplay = isset($attributes['categorydisplay']) ? $attributes['categorydisplay'] : false;
$categoryData = [];

// Fetch categories ONLY if category display is enabled
if ($categoryDisplay) {
    $categories = get_categories([
        'hide_empty' => false, // Fetch all categories, including empty ones
    ]);

    foreach ($categories as $category) {
        $categoryData[] = [
            'id'   => $category->term_id,
            'name' => $category->name,
            'link' => get_category_link($category->term_id),
        ];
    }
}
    
?>

<nav class="nav_contain" <?php echo get_block_wrapper_attributes(); ?> style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo esc_attr($textColor); ?>; background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>;">
    <div class="nav_contain_content">

        <!-- Logo Section -->
        <?php if (!empty($logoUrl)) : ?>
            <a href="<?php echo esc_url( $home_url ); ?>">  <img src="<?php echo esc_attr($logoUrl); ?>" alt="Logo" class="nav_logo" style="height: 21.54px; width: 118.53px;"/></a>
        <?php else : ?>
            <h2 class="nav_a_text" style="color: <?php echo esc_attr($textColor); ?>;">logo</h2>
        <?php endif; ?>

        <!-- Page Links -->
        <?php foreach ($selectedPages as $page) : ?>
            <?php if (!empty($page['url']) && !empty($page['title'])) : ?>
                <span>
                    <a class="nav_a" href="<?php echo esc_url($page['url']); ?>" style="color: <?php echo esc_attr($textColor); ?>;">
                        <h2 class="nav_a_text" style="color: <?php echo esc_attr($textColor); ?>;">
                            <?php echo esc_html($page['customName'] ?? $page['title']); ?>
                        </h2>
                    </a>
                </span>
            <?php endif; ?>
            
        <?php endforeach; ?>
     
        <!-- Category Dropdown (Shown Only if categorydisplay is true) -->
        <!-- <?php if ($categoryDisplay && !empty($categoryData)) : ?>
            <div id="category-data" data-categories='<?php echo json_encode($categoryData, JSON_HEX_APOS | JSON_HEX_QUOT); ?>' style="display: none;"></div>

            <select id="category-select">
                <option value="">Select Category</option>
            </select>
        <?php endif; ?> -->

        <!-- 🔍 Search Section -->
        <span class="search">
           

            <input class="search_input" type="text" placeholder="Search here" id="search-input" style="color: <?php echo esc_attr($textColor); ?>;" > <svg class="search_icon" id="search-icon" width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.555744 18.1521L5.18212 13.5258C4.37662 12.2215 3.88963 10.7001 3.88963 9.05491C3.88963 4.32997 7.71972 0.5 12.4448 0.5C17.1699 0.5 21 4.32997 21 9.05491C21 13.7799 17.1699 17.6098 12.4448 17.6098C10.7996 17.6098 9.27808 17.1229 7.97506 16.3187L3.34736 20.9449C2.97494 21.305 2.47591 21.5043 1.95788 21.4999C1.43984 21.4955 0.944284 21.2877 0.578051 20.9213C0.211817 20.5549 0.00423622 20.0593 6.48499e-05 19.5413C-0.00410843 19.0232 0.195459 18.5243 0.555744 18.1521ZM12.4448 14.9775C15.7155 14.9775 18.3676 12.3255 18.3676 9.05491C18.3676 5.7843 15.7155 3.13228 12.4448 3.13228C9.1741 3.13228 6.522 5.7843 6.522 9.05491C6.522 12.3255 9.1741 14.9775 12.4448 14.9775Z" fill="<?php echo esc_attr($textColor); ?>"/>
            </svg></input>
            <div id="search_results" style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo esc_attr($textColor); ?>; background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>;"></div>
        </span>
        
    </div>
    <div class='nav-small-burger'>
            <!-- Logo Section -->
    <?php if (!empty($logoUrl)) : ?>
        <a href="<?php echo esc_url( $home_url ); ?>">  <img src="<?php echo esc_attr($logoUrl); ?>" alt="Logo" class="nav_logo" style="height: 21.54px; width: 118.53px;"/></a>
    <?php else : ?>
        <h2 class="nav_a_text" style="color: <?php echo esc_attr($textColor); ?>;">logo</h2>
    <?php endif; ?>

    <button id='burger'>
    <Svg width="38" height="17" viewBox='003825'fill="none" xmlns="fttp:www.w3.org/200/svg"><rect width="38" height="6" fill="#909090"/><rect width="38" height="6" transform="translate(0 11)" fill="#909090"/></svg>
    </button>
    </div>
    <div class="nav_contain_content_small" style="font-family: <?php echo esc_attr($fontFamily); ?>; color: <?php echo esc_attr($textColor); ?>; background-color: <?php echo esc_attr($rgbaBackgroundColor); ?>;">


        <!-- Page Links -->
        <?php foreach ($selectedPages as $page) : ?>
            <?php if (!empty($page['url']) && !empty($page['title'])) : ?>
                <span>
                    <a class="nav_a" href="<?php echo esc_url($page['url']); ?>" style="color: <?php echo esc_attr($textColor); ?>;">
                        <h3 class="nav_a_text" style="color: <?php echo esc_attr($textColor); ?>;">
                            <?php echo esc_html($page['customName'] ?? $page['title']); ?>
                        </h3>
                    </a>
                </span>
            <?php endif; ?>
            
        <?php endforeach; ?>
     
        <!-- Category Dropdown (Shown Only if categorydisplay is true) -->
        <!-- <?php if ($categoryDisplay && !empty($categoryData)) : ?>
            <div id="category-data" data-categories='<?php echo json_encode($categoryData, JSON_HEX_APOS | JSON_HEX_QUOT); ?>' style="display: none;"></div>

            <select id="category-select">
                <option value="">Select Category</option>
            </select>
        <?php endif; ?> -->
        
    </div>
</nav>


