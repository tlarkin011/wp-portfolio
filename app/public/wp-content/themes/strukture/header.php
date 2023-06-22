<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-0RWEY63KPM"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-0RWEY63KPM');
	</script>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>



    <header class="site-header" role="banner">
        <div class="row row-middle row-wrap">
            <div class="columns-4 logo-column">

               <?php anvil_site_logo(); ?>

                <a class="fs-menu-trigger" href="#">
                    <span class="burger-menu-text">Menu</span>

                    <span class="fs-burger-menu">
                        <span class="burger-line"></span>
                    </span>
                </a>
            </div>

            <nav class="columns-8  navigation-column" role="navigation">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'menu_class'     => 'nav-menu main-menu'
                ]);
                ?>
            </nav>
        </div>
    </header>

    <section id="main" class="site-main">
