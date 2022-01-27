
<!--======================================
    Footer Section
    ========================================-->
    <footer>
    	<div class="ft01"> <a href="https://innovatech.studio"><img src="<?php bloginfo('template_url');?>/images/White@1x.png" srcset="<?php bloginfo('template_url');?>/images/White@1x.png 1x, <?php bloginfo('template_url');?>/images/White.png 2x" alt="innovatec studio logo"></a>
    		<div class="ftSearch"></div>
    	</div><!-- End ft01 -->
    	<div class="ftLink">
    		<div class="ftLink01">
    			<h5>Explore</h5>
    			<?php wp_nav_menu( array('menu' => 'ftNavi' ) ); ?>
    		</div><!-- End ftLink01 -->
    		<div class="ftLink02">
    			<h5>Visit</h5>
    			<p>〒135-0052<br> 東京都江東区潮見2−8−10<br> 潮見SIFビル2F</p>
    		</div>
    		<div class="ftLink03">
    			<h5>Connect</h5>
    			<div> <a href="https://twitter.com/innovatech_stud"><img src="<?php bloginfo('template_url');?>/images/Icon/Twitter/White@1x.png" srcset="<?php bloginfo('template_url');?>/images/Icon/Twitter/White@1x.png 1x, <?php bloginfo('template_url');?>/images/Icon/Twitter/White.png 2x" alt="Twitter"></a>　　
    				<a href="https://www.facebook.com/innovatechstudio/"><img src="<?php bloginfo('template_url');?>/images/Icon/Facebbok/White@1x.png" srcset="<?php bloginfo('template_url');?>/images/Icon/Facebbok/White@1x.png 1x, <?php bloginfo('template_url');?>/images/Icon/Facebbok/White.png 2x" alt="facebook"></a>
    				<!--<img src="<?php bloginfo('template_url');?>/images/Icon/Instagram/White@1x.png" srcset="<?php bloginfo('template_url');?>/images/Icon/Instagram/White@1x.png 1x, images/Icon/Instagram/White.png 2x" alt="instagram">-->
    			</div>
    		</div><!-- End ftLink03 -->
    		<div class="ftLink04">
    			<h5>Join</h5>
    			<?php wp_nav_menu( array('menu' => 'joinNavi' ) ); ?>
    		</div><!-- End ftLink04 -->
    	</div>
    	<div class="copy">
    		Copyright © <?php echo date("Y"); ?> <a href="">Innovatech Studio</a>. All Rights Reserved.
    	</div>

    	<div class="chatbubble">
    		<div class="unexpanded">
    			<div class="title">Innovatech Support Chat</div>
    		</div>
    		<div class="expanded chat-window">
    			<div class="chats">
    				<div class="loader-wrapper">
    					<div class="loader">
    						<span>Loading</span>
    					</div>
    				</div>
    				<ul class="messages clearfix">
    				</ul>
    				<div class="input">
    					<form class="form-inline" id="messageSupport">
    						<div class="form-group">
    							<input type="text" autocomplete="off" class="form-control" id="newMessage" placeholder="Enter Message">
    						</div>
    						<button type="submit" class="btn btn-primary">Send</button>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div> 
    </footer>
    <div class="clearfix"></div>
<!--======================================
    Top Scroller
    ========================================-->
    <a href="#" class="top-scroll"><i class="fa fa-hand-o-up"></i></a> 
</div>
<?php wp_footer(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="<?php bloginfo('template_url');?>/js/chat-widget.js"></script>
</body>
</html>
