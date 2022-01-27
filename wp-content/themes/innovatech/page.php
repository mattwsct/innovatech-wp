<?php get_header(); ?>

<section class="page-wrapper">
	
		<div class="pageWrapper">
			
				<div class="pagePost">
					<?php if ( have_posts() ) : ?>
						<?php while( have_posts() ) : the_post(); ?>
								<h1><?php the_title(); ?></h1>
								<div class="pagePostS"><?php the_content(); ?></div>
						<?php endwhile;?>
					<?php endif; ?>
				</div>
			</div>

						
</section>

<?php get_footer(); ?>

