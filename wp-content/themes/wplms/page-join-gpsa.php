<?php
get_header();
?>
<section id="title">
	<div class="container">
		<div class="row">
            <div class="col-md-12">
                <div class="pagetitle">
                    <h1>Networking</h1>
                    <h5><?php  echo get_bloginfo('description'); ?></h5>
                </div>
            </div>
        </div>
	</div>
</section>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="no content">
					<?php getMap();?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dialog! -->
<div id="dialog-call-to-action" title="Sign up!"><p>The GPSA Knowledge Platform offers a great diversity of learning, sharing and networking activities.<br/>All these activities are free of charge and open to everyone.<br/>However, to participate you need be registered. <a href="http://gpsaknowledge.org/register/" title="Create an account"><strong>Click here to create your own account</strong></a></p></div><link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"><script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>jQuery(function() {jQuery( "#dialog-call-to-action" ).dialog({autoOpen: false,show: {effect: "blind",duration: 1000},hide: {effect: "explode",duration: 1000}}); jQuery("#dialog-call-to-action").dialog("open");});</script>
<!-- Dialog! -->

<?php
get_footer();
?>
