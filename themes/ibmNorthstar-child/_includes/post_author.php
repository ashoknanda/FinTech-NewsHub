<div class="ibm-blog__post-author ibm-center">

    <div class="first">

            <div class="ibm-blog__post-author-thumb ibm-blog__contributor-thumb">
               <div><?php userphoto_the_author_photo(get_the_author_meta('ID')); ?></div>
            </div>

        <div class="">
           <h4 class="ibm-h4 ibm-bold ibm-padding-bottom-0"><?php echo get_the_author(); ?></h4>

           <p class="ibm-textcolor-gray-40"><?php the_field('job_title', 'user_' . get_the_author_meta('ID')); ?></p>

        </div>

    </div>

</div>