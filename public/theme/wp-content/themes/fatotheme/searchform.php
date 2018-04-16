<form data-role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="lane-search">
		<input type="text" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="<?php echo esc_attr__( 'Search', 'fatotheme' ); ?>" />
		<i class="fa fa-search"></i>
	</div>
</form>