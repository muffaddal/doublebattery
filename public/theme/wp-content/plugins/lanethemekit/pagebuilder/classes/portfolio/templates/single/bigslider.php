<div class="portfolio-full big-slider" id="portfolio-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="post-slideshow ">
                    <?php
                    if(count($imgThumbs)>0){ ?>
                        <div class="item"><img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" /></div>
                    <?php }
                    if(count($meta_values) > 0){
                        foreach($meta_values as $image){
                            $urls = wp_get_attachment_image_src($image,'thumbnail-1170x774');
                            $img = '';
                            if(count($urls)>0)
                                $img = $urls[0];
                            ?>
                            <?php if($img): ?>
                            <div class="item"><img alt="portfolio" src="<?php echo esc_url($img) ?>" /></div>
                            <?php endif; ?>
                        <?php }
                    } ?>
                </div>
                <div class="portfolio-content clearfix">
                    <div class="row">
                        <div class="col-md-3 info">
                            <div class="entry-meta">
                                <span class="meta-date">
                                    <span class="meta-name"><?php esc_html_e('Date:','lanethemekit') ?></span>
                                    <?php the_date() ?>
                                </span>
                                <span class="meta-author">
                                    <span class="meta-name"><?php esc_html_e('Author:','lanethemekit') ?></span>
                                    <?php the_author_link() ?>
                                </span>
                                <span class="meta-category">
                                    <span class="meta-name"><?php esc_html_e('Category:','lanethemekit') ?></span>
                                    <?php echo wp_kses_post($cat); ?>
                                </span>
                            </div>
                            <div class="meta-social-link">
                                <ul>
                                    <li class="meta-name"><?php esc_html_e('Client:','lanethemekit') ?></li>
                                    <li><a title="" data-toggle="tooltip" href="https://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink($post_id))?>" target="_blank" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a title="" data-toggle="tooltip" href="https://twitter.com/share?url=<?php echo esc_url(get_permalink($post_id)) ?>" target="_blank" data-original-title="Twitter"><i class="fa fa-twitter "></i></a></li>
                                    <li><a title="" data-toggle="tooltip" href="https://www.linkedin.com/" target="_blank" data-original-title="Linked In"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a title="" data-toggle="tooltip" href="https://www.rss.com/" target="_blank" data-original-title="Linked In"><i class="fa fa-rss"></i></a></li>
                                    <li><a title="" data-toggle="tooltip" href="https://dribbble.com/" target="_blank" data-original-title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9 desc">
                            <h3 class="title"><?php echo get_the_title() ?></h3>
                            <?php the_content(); ?>
                        </div>                        
                    </div>
                </div>
                <div class="navigation post-nav">
                    <?php lane_post_nav() ?>
                </div>
                <div class="related">
                    <h3 class="widget-title"><span><?php esc_html_e('Related Works', 'lanethemekit') ?></span></h3>
                    <?php  include_once(plugin_dir_path( __FILE__ ).'/related.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
