<?php
/**
 * The template for displaying widget category
 *
 * @package Bootstrap4
 */

$categories = get_categories();
?>

<!-- Categories Widget -->
<div class="card mb-4">
<h5 class="card-header">Categories</h5>
    <div class="card-body">
        <div class="row">
        <?php
            foreach ($categories as $cat):
                $category_link = get_category_link($cat->cat_ID);
                echo '
                    <div class="col-lg-6">
                        <a href="'.esc_url( $category_link ).'" title="'.esc_attr($cat->name).'"> '.$cat->name.'</a>
                    </div>
                ';
            endforeach;
        ?>
        </div>
    </div>
</div>