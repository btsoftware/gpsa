<div id="<?php echo $this->add_id(array('awsm-team',$id));?>" class="awsm-grid-wrapper">
	<?php if ($team->have_posts()): ?>
		<div class="gridder awsm-grid <?php echo $this->item_style($options);?>">
			<?php 
			while ($team->have_posts()): $team->the_post();
    		$teamdata = $this->get_options('awsm_team_member', $team->post->ID);
    		?>
				<div id="<?php echo $this->add_id(array('awsm-member',$id,$team->post->ID));?>" class="awsm-grid-list awsm-grid-card" data-griddercontent="#awsm-grid-content-<?php echo $team->post->ID; ?>">
                    <a href="#">
                        <figure>
                            <!-- <span class="awsm-grid-holder"> -->
                                <img src="<?php echo $this->team_thumbnail($team->post->ID);?>" alt="<?php the_title();?>">
                                <figcaption>
                                    <div class="awsm-personal-info">
                                        <?php $this->checkprint('<span>%s</span>', $teamdata['awsm-team-designation']);?>
                                        <h3><?php the_title(); ?></h3>
                                    </div>
                                    <!-- .awsm-personal-info -->
                                </figcaption>
                            <!-- </span> -->
                            <!-- .awsm-grid-holder -->
                        </figure>
                    </a>
                </div>
			<?php endwhile; wp_reset_postdata();?>
		</div><!-- .grid -->
		<div class="awsm-grid-expander style-1">
			<?php 
			while ($team->have_posts()): $team->the_post();
			$teamdata = $this->get_options('awsm_team_member', $team->post->ID);
			?>
			<div id="<?php echo $this->add_id(array('awsm-member-info',$id,$team->post->ID));?>"  class="awsm-grid-expander <?php echo $options['preset']; ?>">
				<div class="awsm-detailed-info" id="awsm-grid-content-<?php echo $team->post->ID; ?>">
				    <div class="awsm-details">
				        <div class="awsm-personal-details">
				            <div class="awsm-content-scrollbar">
				                <?php 
				                $this->checkprint('<span>%s</span>', $teamdata['awsm-team-designation']);
				                the_title( '<h2>', '</h2>'); 
				                the_content();
				                ?>
				            </div>
				            <!-- .awsm-content-scrollbar -->
				        </div>
				        <!-- .awsm-personal-details -->
				    </div>
				    <!-- .awsm-details -->
				    <div class="awsm-personal-contact-info">
				       <?php
				       include( $this->settings['plugin_path'].'templates/partials/contact.php' );
				       include( $this->settings['plugin_path'].'templates/partials/social.php' );
				       ?>
				    </div>
				    <!-- .awsm-personal-contact-info -->
				</div>
			</div>
			<?php endwhile; wp_reset_postdata();?>
		</div>
	<?php endif;?>	
</div>