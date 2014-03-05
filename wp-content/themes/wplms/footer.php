<footer>
    <div class="footer-contact">
	<div class="container">
	<div class="row">
	<?php 
		    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('topfootersidebar') ) : ?>
	<?php endif; ?>
	</div>
	</div>
    </div>

    <div class="footertop">
    <div class="container">
        <div class="row">
            <div class="footerbottom">
		            <div class="col-md-5">
                <h2 id="footerlogo"><a><img src="<?php $logo=vibe_get_option('logo'); echo (isset($logo)?$logo:VIBE_URL.'/images/logo.png'); ?>"></a></h2>
                
            </div>
                <?php 
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('bottomfootersidebar') ) : ?>
                <?php endif; ?>
            </div>
        </div>
    </div> 
    <div id="scrolltop">
        <a><i class="icon-arrow-1-up"></i><span><?php _e('top','vibe'); ?></span></a>
    </div>
</footer>
<div id="footerbottom">
    <div class="container">
        <div class="row">
            <div class="col-md-4">              
                <?php $copyright=vibe_get_option('copyright'); echo (isset($copyright)?$copyright:'&copy; 2013, All rights reserved.'); ?>
            </div>
            <div class="col-md-8">
                <div id="footermenu">

                </div>    
            </div>
        </div>
    </div>
</div>
</div><!-- END PUSHER -->
</div><!-- END MAIN -->
	<!-- SCRIPTS -->
<?php
wp_footer();
?>    
<?php
echo vibe_get_option('google_analytics');
?>
</body>
</html>