                   <div class="ibm-columns">
                    <div class="ibm-col-4-1">
                        <?php $prev_post = get_previous_post(); ?>
                        <?php if ($prev_post): ?>
                            <?php $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));?>
                            <p><a href="<?php echo get_permalink($prev_post->ID); ?>" class="ibm-previous-link ibm-inlinelink"><?php $my_theme = wp_get_theme(); _e('Previous Post', $my_theme->get( 'Name' )); ?></a></p>
                            <h6 class="nav-title"><a href="<?php echo get_permalink($prev_post->ID); ?>"><?php echo $prev_title;?></a></h6>
                        <?php endif; ?>
                    </div>

                    <div class="ibm-col-4-1 ibm-right ibm-fright">
                        <?php $next_post = get_next_post(); ?>
                        <?php if ($next_post): ?>
                            <?php $next_title = strip_tags(str_replace('"', '', $next_post->post_title));?>
                            <p><a href="<?php echo get_permalink($next_post->ID); ?>" class="ibm-next-link ibm-inlinelink ibm-icon-after"><?php $my_theme = wp_get_theme(); _e('Next Post', $my_theme->get( 'Name' )); ?></a></p>
                            <h6 class="nav-title"><a href="<?php echo get_permalink($next_post->ID); ?>"><?php echo $next_title;?></a></h6>
                        <?php endif; ?>
                    </div>
                    </div>
