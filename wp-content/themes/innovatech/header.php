<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--innovatech STYLES-->
	<link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/animate.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/innovatech.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/chat-widget.css">
	<link rel=”SHORTCUT ICON” href=”<?php bloginfo('template_url');?>/images/favicon.ico” />
	<link href="<?php bloginfo('template_url');?>/slider/src/css/prrple.slider.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
	 crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

	<!-- Java Script -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-121972187-1');
	</script>
	<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/07507342aa50b9da3337415bd/cfbbb4dca3a365d81cb6e4774.js");</script>

	
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php bloginfo('template_url');?>/css/modal.css">
</head>

<body <?php body_class(); ?>>
	<noscript><iframe src="[https://www.googletagmanager.com/ns.html?id=GTM-WVRN23F]" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#main">
			<?php esc_html_e( 'Skip to content', 'specia' ); ?></a>

		<header>
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-xs-8 logo"><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/images/01_innovatech_Logo.png"
							 srcset="<?php bloginfo('template_url');?>/images/01_innovatech_Logo.png 1x,<?php bloginfo('template_url');?>/images/01_innovatech_Logo@2x.png 2x"
							 alt="innovatech"></a>
					</div>
					<div class="col-md-8 col-xs-4">
						<div class="contact-btn" style="float:right">
							<?php echo do_shortcode( '[contact-form-7 id="38" title="Contact Us"]' ); ?>
						</div>
						<div class="gNavi">
							<?php wp_nav_menu( array('menu' => 'gNavi' ) ); ?>
							<!-- <div class="lang">
								<a href="https://innovatech.studio/en/">EN</a>
								<a href="https://innovatech.studio/" class="active">JP</a>
							</div> -->
						</div>

					</div>
				</div>
		</header>

		<div id="content" class="site-content" role="main">