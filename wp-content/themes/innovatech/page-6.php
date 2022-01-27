<?php get_header(); ?>

<section class="page-wrapper">	
	<div class="pageWrapper">
		<div class="people">
			<img class="pplPC" src="<?php bloginfo('template_url');?>/images/PagePeople.png" srcset="<?php bloginfo('template_url');?>/images/PagePeople.png 1x,<?php bloginfo('template_url');?>/images/PagePeople@2x.png 2x" alt="People">
			<img class="pplSP" src="<?php bloginfo('template_url');?>/images/ceo@1x.png" srcset="<?php bloginfo('template_url');?>/images/ceo@1x.png 1x,<?php bloginfo('template_url');?>/images/ceo.png 2x" alt="People">
			
			<div class="members">
				<h1>Some of our members</h1>
				<div class="memberS">
					<div class="memberD">
						<img src="<?php bloginfo('template_url');?>/images/Nghia.png" alt="Nghia/Engineer" srcset="<?php bloginfo('template_url');?>/images/Nghia@2x.png 2x">
						<div class="memberDS">
							<h4>ギア</h4>
							<h5>ベトナム出身</h5>
							<p>PHP/Javascriptによるバックエンド/<br>
								フロントエンドのシステム開発を担当。ファイナルファンタジーが大好きなので日本に来た。
							</p>
						</div>
					</div>
					<div class="memberD">
						<img src="<?php bloginfo('template_url');?>/images/Matt.png" alt="Matt/Engineer" srcset="<?php bloginfo('template_url');?>/images/Matt@2x.png 2x">
						<div class="memberDS">
							<h4>マット</h4>
							<h5>アメリカ出身</h5>
							<p>AIと統計を活用して、ロジスティクスとテクノロジーにおける最先端の課題を解決する。ランチタイムはジムで汗を流すスポーツ万能のコンピュータサイエンス博士。
							</p>
						</div>
					</div>
				</div>
				<div class="memberS">
					<div class="memberD">
						<img src="<?php bloginfo('template_url');?>/images/Andres.png" alt="Pascal/Engineer" srcset="<?php bloginfo('template_url');?>/images/Andres@2x.png 2x">
						<div class="memberDS">
							<h4>アンドレス</h4>
							<h5>スペイン出身</h5>
							<p>斬新なアイディアを、あっという間に具現化するアンドロイドアプリ職人。コーヒー牛乳ばっかり飲んでいる。
							</p>
						</div>
					</div>
					<div class="memberD">
						<img src="<?php bloginfo('template_url');?>/images/Meg.png" alt="Meg/Designer" srcset="<?php bloginfo('template_url');?>/images/Meg@2x.png 2x">
						<div class="memberDS">
							<h4>メグ</h4>
							<h5>日本出身</h5>
							<p>クライアントとエンドユーザー双方とのコミュニケーションを重視してプロジェクトを進める。カラオケでの高音域の歌唱には定評がある。
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="pagePost">
				<?php if ( have_posts() ) : ?>
				<?php while( have_posts() ) : the_post(); ?>
				<p><?php the_content(); ?></p>
				<?php endwhile;?>
				<?php endif; ?>
			</div>
		</div>	
	</div>
</section>

<?php get_footer(); ?>

