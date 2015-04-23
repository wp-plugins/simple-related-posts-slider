<?php ?>

<h2 style="margin-bottom:40px;">Simple Related Posts Slider</h2>


<hr>
	 <?php
        // This prints out all hidden setting fields
        settings_fields( 'srps_option_group' );   
        do_settings_sections( 'simple-related-posts-slider' );
        submit_button(); 
    ?>



</form>
