<?php
$cat = '';
$term_link = '';
foreach ( $terms as $term ){
    $cat .= $term->name.', ';
    $term_link = get_term_link( $term );
    // If there was an error, continue to the next term.
    if ( is_wp_error( $term_link ) ) {
        continue;
    }
}
$cat = rtrim($cat,', ');
?>
<div class="entry-thumbnail title">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="entry-thumbnail-hover">
        <div class="entry-hover-wrapper">
            <div class="entry-hover-inner">
                <a href="<?php echo esc_url( $term_link ) ?>"><span class="category"><?php echo wp_kses_post($cat) ?></span></a>
                <a class="entry-title" href="<?php echo get_permalink(get_the_ID()) ?>"><div><?php the_title() ?></div> </a>
                <a class="view-now" href="<?php echo get_permalink(get_the_ID()) ?>"><?php echo esc_html__("View now","lanethemekit") ?></a>
            </div>
        </div>
    </div>

</div>