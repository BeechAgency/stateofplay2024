<?php 

function get_acf_image($field, $size = 'full', $type = 'sub', $postId = null, $classes = null) {
    if($type === 'sub') {
	    return get_sub_field($field, $postId) ? wp_get_attachment_image(get_sub_field($field, $postId), $size, 0, array('title'=> '')) : ''; 
    } else {
	    return get_field($field, $postId) ? wp_get_attachment_image(get_field($field, $postId), $size, 0, array('title'=> '', 'class'=> $classes)) : ''; 
    }
}

function the_image($imageId, $args = null) {

    $size = !empty($args['size']) ? $args['size'] : 'full';
    $alt = !empty($args['alt']) ? $args['alt'] : get_post_meta($imageId, '_wp_attachment_image_alt', true);
    $classes = !empty($args['classes']) ? $args['classes'] : '';
    $onClick = !empty($args['onClick']) ? $args['onClick'] : '';
    $attrs = !empty($args['attrs']) ?  $args['attrs'] : '';

    $img_src = wp_get_attachment_image_url( $imageId, $size );
    $img_srcset = wp_get_attachment_image_srcset( $imageId, $size );


    $img = "<img src='".esc_url( $img_src )."' srcset='".esc_attr( $img_srcset )."' sizes='(max-width: 50em) 87vw, 680px' alt='".esc_attr( $alt )."' class='".esc_attr( $classes )."' $attrs";
    $img = $onClick !== '' ? $img .= 'onClick="'.esc_attr($onClick).'" />' : $img.'/>';

    return $img;
}

function the_acf_content($data) {
    if(empty($data)) return '';
    return '<div class="wysiwyg">'.apply_filters('the_content', $data ).'</div>';
}

/* Youtube ID */
function get_youtube_id($url) {

    $parsedUrl = parse_url($url);
    
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $query);
        if (isset($query['v'])) {
            return $query['v'];
        }
    }
    
    $path = ltrim($parsedUrl['path'], '/');

    if (strpos($parsedUrl['host'], 'youtu.be') !== false) {
        return $path;
    }
    
    return null;
}

function get_vimeo_id($url) {
    $exploded = explode('?', $url);
    $exploded = explode('/', $exploded[0]);

    $length = count($exploded);

    if($length !== 4) return '';

    return $exploded[$length - 1];
}

/* Handle video URL */
function do_video_field($url, $type, $poster = '') {
    if(empty($url)) return;

    if($type === 'url' || $type === 'direct') {
        return "<video class='lozad sick-video video' autoplay muted loop playsinline poster='$poster'><source src='$url' type='video/mp4'></video>";
    }
    elseif($type === 'youtube') {
        $id = get_youtube_id($url);
        return "<iframe class='lozad sick-video video youtube' id='video' width='100%' height='600' src='https://www.youtube.com/embed/$id?rel=0&modestbranding=1&controls=0&color=009999' title='YouTube video player' frameborder='0' allow='autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";

    } elseif($type === 'vimeo') { //347119375 // 107178137

        $id = get_vimeo_id($url);

        return "<iframe class='lozad sick-video video vimeo' id='video' width='100%' height='600' src='https://player.vimeo.com/video/$id?title=0&portrait=0&byline=0&color=009999&background=1' title='Vimeo video player' frameborder='0' allow='autoplay; clipboard-write; encrypted-media; picture-in-picture' allowfullscreen></iframe>";

    } elseif($type === 'dropbox') {
        //https://dl.dropboxusercontent.com/scl/fi/ms2b9i1v1jnthxertnwp2/2_GFFA_Animation_NewLogoLockup.mp4?rlkey=xx28lvott2n7xfv5hpcci1lt2&dl=0
        //https://dl.dropboxusercontent.com/scl/fi/ms2b9i1v1jnthxertnwp2/2_GFFA_Animation_NewLogoLockup.mp4?raw=1


        //https://dl.dropboxusercontent.com/scl/fi/ms2b9i1v1jnthxertnwp2/2_GFFA_Animation_NewLogoLockup.mp4?rlkey=xx28lvott2n7xfv5hpcci1lt2&dl=0
        //https://dl.dropboxusercontent.com/scl/fi/ms2b9i1v1jnthxertnwp2/2_GFFA_Animation_NewLogoLockup.mp4?dl=0

        $rep = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $url);
        //$repParts = explode("?", $rep);
        $rep = $rep . '&dl=0';

        return "<video class='lozad sick-video video' autoplay muted loop playsinline><source src='$rep' type='video/mp4'></video>";

    } else {
        return $url;
    }
}

/* Helper for wrapping stuff */
function conditionally_output_field($value, $openTag, $closeTag) {
    if(empty($value)) return;
    if($value === false) return;

    return $openTag.$value.$closeTag;
}

/* Helpder for dealing with a link CTA */
function do_a_cta($args) {
    if(empty($args['url']) || empty($args['title'])) return false;
    if(empty($args['classes'])) $args['classes'] = 'btn-primary';

    $url = $args['url'];
    $title = $args['title'];
    $classes = $args['classes'];

    $alignment = !empty($args['align']) ? ' align-'.$args['align'] : '';

    $classes .= $alignment;

    if(empty($url) || empty($title)) return false;

    //$arrow = '<svg xmlns="http://www.w3.org/2000/svg" width="36.761" height="20.825" viewBox="0 0 36.761 20.825"><g id="Group_19" data-name="Group 19" transform="translate(0 0.659)"><line id="Line_2" data-name="Line 2" x2="35.166" transform="translate(0 9.754)" fill="none" stroke="currentColor" stroke-width="2"/><path id="Path_1" data-name="Path 1" d="M1456.628,1887.49l8.548,9.753-8.548,9.754" transform="translate(-1429.745 -1887.49)" fill="none" stroke="currentColor" stroke-width="2"/></g></svg>';

    return '<a href="'.$url.'" class="bb-btn '.$classes.'" target="'.$args['target'].'" >'.$title.'</a>';
}

