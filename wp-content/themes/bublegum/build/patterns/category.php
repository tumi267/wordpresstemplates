<!-- wp:group {"style":{"spacing":{"blockGap":"10px"},"dimensions":{"minHeight":"537px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" >
    <div class="catagory_header">
    <!-- Category Title -->
    <!-- wp:query-title {"type":"archive", "showPrefix":false} /-->
    </div>
    <!-- Query Block with Dynamic Category Filtering -->
    <!-- wp:query {"query":{"perPage":10,"postType":"post","inherit":true},"displayPagination":true} -->
    <div class="wp-block-query post_contain">
        
        <!-- wp:post-template -->
        <a href="<!-- wp:post-url /-->">
        <div class="category_post_card">
            <!-- wp:post-featured-image /-->
            <!-- wp:post-title {"isLink":true} /-->
            <p class="post-excerpt"><!-- wp:post-excerpt /--></p>
        </div>
        </a>
        <!-- /wp:post-template -->
        
        <div>
        <!-- Message when no posts are found -->
        <!-- wp:query-no-results -->
        <p>No posts in this category.</p>
        <!-- /wp:query-no-results -->
        </div>
        <!-- Pagination -->
        <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
            <div class="wp-block-query-pagination">
                <button>
                <!-- wp:query-pagination-previous /-->
                </button>
                <button>
                <!-- wp:query-pagination-next /-->
                </button>
            </div>
        <!-- /wp:query-pagination -->

    </div>
    <!-- /wp:query -->

</div>
<!-- /wp:group -->


