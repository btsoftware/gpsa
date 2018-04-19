<?php


get_header();

global $post;
$flag=0;
$free=get_post_meta(get_the_ID(),'vibe_free',true);

if(vibe_validate($free)){
    $flag=1;
}else if((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && is_user_logged_in())){
    $flag=1;
}else if(current_user_can('edit_posts')){
    $flag=1;
    $instructor_privacy = vibe_get_option('instructor_content_privacy');
    $user_id=get_current_user_id();
    if(isset($instructor_privacy) && $instructor_privacy){
        if($user_id != $post->post_author)
          $flag=0;
    }
}

$flag = apply_filters('wplms_before_unit',$flag);

if($flag || current_user_can('manage_options')){

    if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<section id="title">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <div class="pagetitle">
                    <h1><?php the_title(); ?></h1>
                    <?php the_sub_title(); ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <?php
                if(isset($_GET['id']))
                  echo '<a href="'.get_permalink($_GET['id']).'?action=curriculum" class="course_button button full">'.__('Back to Course','vibe').'</a>';
                
                ?>
            </div>
        </div>
    </div>
</section>
<section id="content">
    <!--div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <div class="content">
                    <div class="single_unit_content">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="featured">
                        <?php the_post_thumbnail(get_the_ID(),'full'); ?>
                    </div>
                    <?php
                    }
                        the_content();
                    ?>
                    <?php wp_link_pages('before=<div class="unit-page-links page-links"><div class="page-link">&link_before=<span>&link_after=</span>&after=</div></div>'); 
                    do_action('wplms_after_every_unit',get_the_ID());
                    ?>
                    </div> 
                    <div class="tags">
                    <?php the_unit_tags('<ul><li>','</li><li>','</li></ul>'); ?>
                    </div>   
                    <?php
                      $attachments =& get_children( 'post_type=attachment&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent='.$id);
                      if($attachments && count($attachments)){
                        $att= '';

                        $count=0;
                      foreach( $attachments as $attachmentsID => $attachmentsPost ){
                      
                      $type=get_post_mime_type($attachmentsID);

                      if($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif'){
                          
                          if($type == 'application/zip')
                            $type='icon-compressed-zip-file';
                          else if($type == 'video/mpeg' || $type== 'video/mp4' || $type== 'video/quicktime')
                            $type='icon-movie-play-file-1';
                          else if($type == 'text/csv' || $type== 'text/plain' || $type== 'text/xml')
                            $type='icon-document-file-1';
                          else if($type == 'audio/mp3' || $type== 'audio/ogg' || $type== 'audio/wmv')
                            $type='icon-music-file-1';
                          else if($type == 'application/pdf')
                            $type='icon-text-document';
                          else
                            $type='icon-file';

                          $count++;

                          $att .='<li><i class="'.$type.'"></i>'.wp_get_attachment_link($attachmentsID).'</li>';
                        }
                      }
                        if($count){
                          echo '<div class="unitattachments"><h4>'.__('Attachments','vibe').'<span><i class="icon-download-3"></i>'.$count.'</span></h4><ul id="attachments">';
                          echo $att;
                         echo '</ul></div>';
                        }
                      }

                      $forum=get_post_meta($id,'vibe_forum',true);
                      if(isset($forum) && $forum){
                        echo '<div class="unitforum"><a href="'.get_permalink($forum).'">'.__('Have Questions ? Ask in the Unit Forums','vibe').'</a></div>';
                      }
                     ?>
                     
                 
                </div>
                <?php

                endwhile;
                endif;
                ?>
                <?php
                do_action('wplms_unit_end_front_end_controls');
                ?>
            </div>
            <div class="col-md-3 col-sm-4">
                <?php
                global $wp_query;
                if(isset($_GET['edit']) || isset($wp_query->query_vars['edit'])){
                    do_action('wplms_front_end_unit_controls');
                }else{
                    $sidebar = apply_filters('wplms_sidebar','coursesidebar',get_the_ID());
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($sidebar) ) {}
                }
                ?>
            </div>
        </div>
    </div-->
    <div class="container">
                	<h1><?php 
                    if(isset($course_id)){
                    	echo get_the_title($unit_id);
                    }else
                    	the_title();
                     ?></h1>
                    <?php
					if(isset($course_id)){
                    	the_sub_title($unit_id);
                    }else{
                    	the_sub_title();	
                    }	
                    ?>	
                </div>
                    <?php

                    if(isset($coursetaken) && $coursetaken && $unit_id !=''){
                    	if(isset($course_curriculum) && is_array($course_curriculum)){
							the_unit($unit_id);
                    	}else{
                    		echo '<h3>';
                    		_e('Course Curriculum Not Set.','vibe');
                    		echo '</h3>';
                    	}
                    }else{
                        the_content();
                    }
                    
                endwhile;
                endif;
                ?>
                <?php
                $units=array();
                if(isset($course_curriculum) && is_array($course_curriculum) && count($course_curriculum)){
                  foreach($course_curriculum as $key=>$curriculum){
                    if(is_numeric($curriculum)){
                        $units[]=$curriculum;
                    }
                  }
                }else{
                    echo '<div class="error"><p>'.__('Course Curriculum Not Set','vibe').'</p></div>';
                }   

                  if($unit_id ==''){
                    echo  '<div class="unit_prevnext"><div class="col-md-3"></div><div class="col-md-6">
                          '.((isset($done_flag) && $done_flag)?'': '<a href="#" data-unit="'.$units[0].'" class="unit unit_button">'.__('Start Course','vibe').'</a>').
                        '</div></div>';
                  }else{

                    $k = array_search($unit_id,$units);
                  
                  if(empty($k)) $k = 0;

            	  $next=$k+1;
                  $prev=$k-1;
                  $max=count($units)-1;

                  $done_flag=get_user_meta($user_id,$unit_id,true);
                  

                  echo  '<div class="unit_prevnext"><div class="col-md-3">';
                  if($prev >=0){
                    if(get_post_type($units[$prev]) == 'quiz'){
                            $quiz_status = get_post_meta($units[$prev],$user_id,true);
                            if(!empty($quiz_status))
                                echo '<a href="#" data-unit="'.$units[$prev].'" class="unit unit_button">'.__('Back to Quiz','vibe').'</a>';
                            else          
                                echo '<a href="'.get_permalink($units[$prev]).'" class=" unit_button">'.__('Back to Quiz','vibe').'</a>';
                        }else    
                            echo '<a href="#" id="prev_unit" data-unit="'.$units[$prev].'" class="unit unit_button">'.__('Previous Unit','vibe').'</a>';
                  }
                  echo '</div>';

                  echo  '<div class="col-md-6">';
                    if(!isset($done_flag) || !$done_flag){
                            if(get_post_type($units[($k)]) == 'quiz'){
                                $quiz_status = get_post_meta($units[($k)],$user_id,true);
                                if(!empty($quiz_status)){
                                    echo '<a href="'.bp_loggedin_user_domain().BP_COURSE_SLUG.'/'.BP_COURSE_RESULTS_SLUG.'/?action='.$units[($k)].'" class="quiz_results_popup">'.__('Check Results','vibe').'</a>';
                                }else{
                                    echo '<a href="'.get_permalink($units[($k)]).'" class=" unit_button">'.__('Start Quiz','vibe').'</a>';
                                }
                            }else{
                                echo '<a href="#" id="mark-complete" data-unit="'.$units[($k)].'" class="unit_button">'.__('Mark this Unit Complete','vibe').'</a>';
                            }
                    }else{
                        if(get_post_type($units[($k)]) == 'quiz'){
                            echo '<a href="'.bp_loggedin_user_domain().BP_COURSE_SLUG.'/'.BP_COURSE_RESULTS_SLUG.'/?action='.$units[($k)].'" class="quiz_results_popup">'.__('Check Results','vibe').'</a>';
                          }
                    }
                    echo '</div>';

                  echo  '<div class="col-md-3">';

                  $nextflag=1;
                  if($next <= $max){
                    $nextunit_access = vibe_get_option('nextunit_access');
                    if(isset($nextunit_access) && $nextunit_access){
                        for($i=0;$i<$next;$i++){
                            $status = get_post_meta($units[$i],$user_id,true);
                            if(!empty($status)){
                                $nextflag=0;
                                break;
                            }
                        }
                    }
                    if($nextflag){
                        if(get_post_type($units[$next]) == 'quiz'){
                            $quiz_status = get_post_meta($units[$next],$user_id,true);
                            if(!empty($quiz_status))
                                echo '<a href="#" data-unit="'.$units[$next].'" class="unit unit_button">'.__('Proceed to Quiz','vibe').'</a>';
                            else          
                                echo '<a href="'.get_permalink($units[$next]).'" class=" unit_button">'.__('Proceed to Quiz','vibe').'</a>';
                        }else{
                            if(get_post_type($units[$k]) == 'quiz'){ //Display Next unit link because current unit is a quiz on Page reload
                                echo '<a href="#" id="next_unit" data-unit="'.$units[$next].'" class="unit unit_button">'.__('Next Unit','vibe').'</a>';
                            }else{
                                echo '<a href="#" id="next_unit" data-unit="'.$units[$next].'" class="unit unit_button hide">'.__('Next Unit','vibe').'</a>';
                            }
                        } 
                    }
                  }
                  echo '</div></div>';

                } // End the Bug fix on course begining
	            ?>
                </div>
                <?php
                	wp_nonce_field('security','hash');
                	echo '<input type="hidden" id="course_id" name="course" value="'.$course_id.'" />';
                ?>
            </div>
            <div class="col-md-3">
            	<div class="course_time">
            		<?php
            			the_course_time("course_id=$course_id&user_id=$user_id");

            		?>
            	</div>
                <?php 

                do_action('wplms_course_start_after_time',$course_id,$unit_id);  

                echo the_course_timeline($course_id,$unit_id);

                do_action('wplms_course_start_after_timeline',$course_id,$unit_id);

            	if(isset($course_curriculum) && is_array($course_curriculum)){
            		?>
            	<div class="more_course">
            		<a href="<?php echo get_permalink($course_id); ?>" class="unit_button full button"><?php _e('BACK TO COURSE','vibe'); ?></a>
            		<form action="<?php echo get_permalink($course_id); ?>" method="post">
            		<?php
            		$finishbit=get_post_meta($course_id,$user_id,true);
            		if(isset($finishbit) && $finishbit!=''){
            			if($finishbit>0 && $finishbit < 3){
                            echo '<input type="submit" name="review_course" class="review_course unit_button full button" value="'. __('REVIEW COURSE ','vibe').'" />';
            			    echo '<input type="submit" name="submit_course" class="review_course unit_button full button" value="'. __('FINISH COURSE ','vibe').'" />';
            			}
            		}
            		?>	
            		<?php wp_nonce_field($course_id,'review'); ?>
            		</form>
            	</div>
            	<?php
            		}
            	?>
            </div>
        </div>
    </div>
</section>
</div>

<?php
}else{
?>
<section id="title">
    <div class="container">
        <?php echo apply_filters('wplms_direct_access_not_allowed',__('<h1>.Direct Access to Units is not allowed</h1>','vibe')); ?>
        <?php
        do_action('wplms_direct_access_not_allowed');
        ?>
    </div>
</section>
<?php
}
get_footer();
?>
