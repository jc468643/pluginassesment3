<?php
/**
*Plugin Name:comment-add
*Description:This is the begining
version: 1.0
Author :shebin
**/

/* for add info using shortcode */
function comment_add()
    
{
    $content = "we would like to get Feedback from you !";
    $content .="<div> We all need people who will give us feedback. That’s how we improve.</div>";
    $content .="<p>Please provide your information in the form below</p>";
    /* for returning information instead of printing,this will display whereever the shortcode */
    return $content; 
}
/*hook and function name  */
add_shortcode('example','comment_add');



/*for left hand menu oprtion */
function ideapro_admin_menu_option()
{
    add_menu_page('Header & Footer Scripts','Site Scripts','manage_options','ideapro-admin-menu','ideapro_scripts_page','',200);
}

add_action('admin_menu','ideapro_admin_menu_option');
  

function ideapro_scripts_page()
{
    if (array_key_exists('submit_scripts_update',$_POST))
    {
        
        update_option('ideapro_header_scripts',$_POST['header_scripts']);
        update_option('ideapro_footer_scripts',$_POST['footer_script']);
        ?>

<div id="setting-error-settings_updated" class="updated_settings-error notice is-dismissible"><strong>Settings have been saved</strong></div>

    <?php
        
    }
    
    
    $header_scripts = get_option('ideapro_header_scripts',none);
    $footer_scripts = get_option('ideapro_footer_scripts',none);
    ?>
    <div class="wrap">
        <h2>Update scripts on the header and footer</h2>
        <form method="post" action="">
        <label for ="header_scripts">Header Scripts</label>
        <textarea name="header_scripts" class="large-text"><?php print $header_scripts; ?></textarea>
        <label for ="footer_scripts">Footer Scripts </label>
        <textarea name="footer_script" class="large-text"><?php print $footer_scripts; ?></textarea>
        
        <input type="submit" name="submit_scripts_update" class="button" "button-primary" value="UPDATE SCRIPTS">
        </form>
    </div>
<?php
    
}

function ideapro_display_header_scripts()
{
$header_scripts = get_option('ideapro_header_scripts',none);
    print $header_scripts;

}
add_action('wp_head','ideapro_display_header_scripts');

function ideapro_display_footer_scripts()
{
  $footer_scripts = get_option('ideapro_footer_scripts',none); 
    print $footer_scripts;
}
add_action('wp_footer','ideapro_display_footer_scripts');





/* part 3 form */

function ideapro_form ()
{
    /*content variable */
    $content ='';
    $content .= '<form method="post" action="http://localhost/mySite/thank-you/">';
    
    
    $content .= '<input type="text" name="full_name" placeholder="Your Full name" />';  
    $content .= '<br />';
    
    $content .= '<input type="text" name="email_address" placeholder="Email Address" />';  
    $content .= '<br />'; 
    
    $content .= '<input type="text" name="phone_number" placeholder="Phone Number" />';  
    $content .= '<br />';
    
    
    $content .= '<textarea name="comments" placeholder="give us your comments"></textarea>';  
    $content .= '<br />';
    
    
    $content .='<input type="submit" name="ideapro_submit_form" value="SUBMIT YOUR INFORMATION" />';
    
    
    $content .= '</form>';
    
    
    return $content; 
    
}
/* for the form display */
add_shortcode('ideaproform_contact_form','ideapro_form');



/* for returning the mail not just in a line,ie line by line  standared text email to html text*/
function set_html_content_type()
{
    return 'text/html';
    
}

/* for capturing the form data,run everytime */
function ideapro_form_capture()
{
    global $post;
    global $wpdb;
    /*  if arraykey exist in the post*/
   if (array_key_exists('ideapro_submit_form',$_POST)) 
   {
        $to ="shebin.shaji@my.jcu.edu.au";
        $subject = "Idea Pro Examble Site Form Submission";
        $body = '';
    /* capturing each fields */
        $body .= 'Name:'.$_POST ['full_name'].'<br />';
        $body .= 'Email:' .$_POST ['email_address']. ' <br />';
        $body .= 'phone:' .$_POST ['phone_number']. ' <br />';
        $body .='comments:' .$_POST ['comments']. ' <br />';
        $comment = 'comments:' .$_POST ['comments']. ' <br />';
       
       add_filter('wp_mail_content_type','set_html_content_type');
            
       /* just taking comment feom form if we want we can take  body also.*/
        wp_mail($to,$subject,$comment);
       /* removing filter,back to normal content */
       remove_filter('wp_mail_content_type','set_html_content_type');
       
       
    
    
    
}
add_action('wp_head','ideapro_form_capture');


?>