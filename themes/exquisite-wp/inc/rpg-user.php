<?php 

/*
    filters get_avatar()
    replaces built-in wordpress avatar with user-uploaded avatar (if it exists)
    
    @see inc/rpg-metaboxes.php

*/
function rpg_get_avatar($avatar, $id_or_email, $size, $default, $alt) {

    if ( !is_numeric($size) )
        $size = '96';


    $email = '';
    if ( is_numeric($id_or_email) ) {
        $id = (int) $id_or_email;
        $user = get_userdata($id);
        if ( $user ) {
            $email = $user->user_email;
            
            $user_photo = get_user_meta($id , '_ibm_contributor_image', true);
            if ($user_photo) {
                // we had a custom photo. make it look like an avatar
                $avatar = "<img alt='' src='$user_photo' class='avatar avatar-$size photo' height='$size' width='$size' />";
                
                return $avatar;
            }
            
        }
        

    } else {
        error_log("warn: get_avatar called with non-numeric ID not supported.");
    }
    
    return $avatar;
    
}

add_filter( 'get_avatar', 'rpg_get_avatar', 10, 5 ); 

?>