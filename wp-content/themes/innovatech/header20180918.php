<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<script>(function(w,d,s,l,i)\{w\[l\]‌=w\[l\]‌\|\|\[\]‌;w\[l\].push(\{'gtm.start':new Date().getTime(),event:'gtm.js'\});var f=d.getElementsByTagName(s)\[0\],j=d.createElement(s),dl=l\!='dataLayer'?'&l='\+l:'';j.async=true;j.src='[https://www.googletagmanager.com/gtm.js?id='\+i+dl;f.parentNode.insertBefore(j,f);|https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);]\})(window,document,'script','dataLayer','GTM-WVRN23F');</script>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
		<!-- VIEWPORT -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- JQUERY -->
		<!--script src="<?php bloginfo('template_url');?>/slider/examples/js/jquery.1.11.1.min.js"></script>
		<!-- JQUERY TOUCHSWIPE -->
		<!--script src="<?php bloginfo('template_url');?>/slider/examples/js/jquery.touchSwipe.1.6.min.js"></script-->
		<!-- PRRPLE SLIDER -->
		<!--script src="<?php bloginfo('template_url');?>/slider/src/js/prrple.slider.js"></script-->
		<!-- CUSTOM SCRIPTS -->
		<script src="<?php bloginfo('template_url');?>/slider/examples/js/scripts.js"></script>
		<!-- STYLES -->
		<!--link href="<?php bloginfo('template_url');?>/slider/src/css/prrple.slider.css" rel="stylesheet" type="text/css"-->
		<!--link href="examples/css/styles.css" rel="stylesheet" type="text/css" /-->
		
		<!--innovatech STYLES-->
		<link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/animate.css">
		<link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/innovatech.css">
	</head>
	<body <?php body_class(); ?>>
		<noscript><iframe src="[https://www.googletagmanager.com/ns.html?id=GTM-WVRN23F]"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'specia' ); ?></a>
			<header>
				<div class="logo"> <a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/images/01_innovatech_Logo.png" srcset="<?php bloginfo('template_url');?>/images/01_innovatech_Logo.png 1x,<?php bloginfo('template_url');?>/images/01_innovatech_Logo@2x.png 2x" alt="innovatech"></a>
			</div>
			<div class="gNavi">
				<?php wp_nav_menu( array('menu' => 'gNavi' ) ); ?>
				<div class="lang">
					<!--<a href="#">EN</a>-->
					<a href="#" class="active">JP</a>
				</div>
			</div>
		</header>
		<div id="content" class="site-content" role="main">