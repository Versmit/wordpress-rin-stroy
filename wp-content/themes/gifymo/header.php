<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="//gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body <?php body_class(); ?>>
<?php gifymo_wp_body_open(); ?>
<div id="wptime-plugin-preloader"></div>
<div class="opal-wrapper">
    <div id="page" class="site">
        <header id="masthead" class="site-header">
            <?php get_template_part('template-parts/header'); ?>
        </header>
        <?php if (!is_404()): ?>
            <div id="page-title-bar" class="page-title-bar">
                <?php get_template_part('template-parts/common/page-title'); ?>
            </div>
        <?php endif; ?>
        <div class="site-content-contain">
            <div id="content" class="site-content">
