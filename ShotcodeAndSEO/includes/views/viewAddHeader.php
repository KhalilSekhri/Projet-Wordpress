<div class="wrap">
    <h2>Google Analytics</h2>


	
    <?php
    if ( isset( $this->message ) ) {
        ?>
        <div class="updated fade"><p><?php echo $this->message; ?></p></div>
        <?php
    }
    if ( isset( $this->errorMessage ) ) {
        ?>
        <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>
        <?php
    }
    ?>

    <div id="poststuff">
    	<div id="post-body" class="metabox-holder columns-2">
    		<!-- Content -->
    		<div id="post-body-content">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
	                <div class="postbox">

	                    <div class="inside">
		                    <form action="options-general.php?page=<?php echo $this->plugin->name; ?>" method="post">

                                <p>
		                    		<label for="ihaf_insert_header"><strong>Insert yout code -	Google Analytics </strong></label>
		                    		<textarea name="ihaf_insert_header" id="ihaf_insert_header" class="widefat" rows="8" style="font-family:Courier New;"><?php echo $this->settings['ihaf_insert_header']; ?></textarea>
		                    	</p>

                                <?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>

                                <p>
									<input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php esc_html_e( 'Save', 'insert-headers-and-footers' ); ?>" />
								</p>
						    </form>
	                    </div>
	                </div>
	                <!-- /postbox -->
				</div>
				<!-- /normal-sortables -->
    		</div>
    		<!-- /post-body-content -->
        </div>
	</div>
</div>