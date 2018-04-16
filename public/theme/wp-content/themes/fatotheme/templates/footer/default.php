<?php 
$col_footer = 0;
for ($i=1; $i<=6; $i++) {
    if(is_active_sidebar('footer-'. $i)) {
        $col_footer +=1;
    }
}
$col_footer_class = '';
if ($col_footer > 0){
    switch ($col_footer){
        case 1 :
            $col_footer_class = 'col-sm-12';
            break;
        case 2 :
            $col_footer_class = 'col-sm-6';
            break;
        case 3 :
            $col_footer_class = 'col-sm-4';
            break;
        case 4 :
            $col_footer_class = 'col-md-3 col-sm-6';
            break;
        case 5 :
            $col_footer_class = 'col-md-2 col-sm-6';
            break;
        case 6 :
            $col_footer_class = 'col-md-2 col-sm-6';
            break;
    }
}
?>
<div class="footer-content clear-footer">
    <?php if(is_active_sidebar('footer-top')): ?>
        <div class="footer-blocks footer-top">
            <?php dynamic_sidebar('footer-top'); ?>
        </div>
    <?php endif; ?>
    <?php if(is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') || is_active_sidebar('footer-5') || is_active_sidebar('footer-6')): ?>
    <div class="footer-blocks">
        <div class="container">
            <div class="row">
                <?php
                for ($j=1; $j<=6; $j++) {
                    if (($col_footer==5) && ($j===1 || $j===5)) {
                        $col_class = 'col-md-3 col-sm-6';
                    }else{
                        $col_class = $col_footer_class;
                    }
                    if(is_active_sidebar('footer-'. $j)) {
                        echo '<div class="'. esc_attr($col_class . ' footer-'.$j).'">';
                            dynamic_sidebar('footer-'. $j);
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php endif; //Active  ?>
</div>


