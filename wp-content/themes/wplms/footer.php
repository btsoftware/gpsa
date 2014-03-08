<section class="stripe" style="padding-bottom: 0px ! important;">
        <div class="footer-contact">
	<div class="container">
	<div class="row">
	    <a class="buttoncontact" href="">Contact Us</a>	
	</div>
	</div>
    </div>


</section>
<footer>
    <div class="footertop">
    <div class="container">
        <div class="row">
            <div class="footerbottom">
		<div class="col-md-5">
                     <h2 id="footerlogo"><a><img src="<?php $logo=vibe_get_option('logo'); echo (isset($logo)?$logo:VIBE_URL.'/images/logo.png'); ?>"></a></h2>
                </div>
                <div class="col-md-7 sitemap">
                    <div class="col-md-2">
			<div class="footerwidget">
			    <h4 class="footertitle"><a href="about/">About</a></h4>
			    <div class="textwidget"></div>
		        </div>
		    </div>
		    <div class="col-md-2">
			<div class="footerwidget">
			    <h4 class="footertitle"><a>News and Events</a></h4>
			    <div class="textwidget"></div>
		        </div>
		    </div>
		    <div class="col-md-2">
			    <div class="footerwidget">
				<h4 class="footertitle"><a>Knowledge Repository</a></h4>
				<div class="textwidget">
				    <ul>
				    <li><a>Publications on Social Accountability</a></li>
				   </ul>
				</div>
		            </div>
		    </div>
		    <div class="col-md-2">
			<div class="footerwidget">
			    <h4 class="footertitle"><a>Learning Activities</a></h4>
				<div class="textwidget">
				    <ul>
				    <li><a>E-courses</a></li>
				    <li><a>Members directory</a></li>
				    </ul>
				</div>
		       </div>
		    </div>
		    <div class="col-md-2">
			<div class="footerwidget">
			    <h4 class="footertitle"><a>Networking</a></h4>
				<div class="textwidget">
				    <ul>
				    <li><a>Blog</a></li>
				    <li><a>Tell us about your story</a></li>
				    <li><a>Related Initiatives</a></li>
				    <li><a>Roster of Practitioners</a></li>
				    </ul>
				</div>
		       </div>
		    </div>
		    <div class="col-md-2">
			<div class="footerwidget">
			    <h4 class="footertitle"><a>Knowledge Exchange</a></h4>
				<div class="textwidget">
				    <ul>
				    <li><a>Thematic forums</a></li>
				    <li><a>Webinars</a></li>
				    </ul>
				</div>
		        </div>
		    </div>
		</div>
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
                      f t
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