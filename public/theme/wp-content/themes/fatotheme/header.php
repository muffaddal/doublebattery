<!DOCTYPE html>
<html <?php language_attributes() ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head() ?>
</head>
<body <?php body_class() ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
    <?php do_action('fatotheme_before_wrapper'); ?>
    <!-- START Wrapper -->
	<div class="page-wrapper clearfix">
		<!-- HEADER -->
        <?php get_template_part( 'templates/header/header', apply_filters( 'header_layout', 1 ) ); ?>
		<!-- //HEADER -->