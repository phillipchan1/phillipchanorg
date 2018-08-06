<form action="<?php echo home_url( '/' ); ?>" class="search-form clearfix">
	<fieldset>
		
		<input type="submit" value="Go" class="submit" />
		<input type="text" class="search-form-input text" name="s" onfocus="if (this.value == '<?php _e('Search','okay'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search','okay'); ?>';}" value="<?php _e('Search','okay'); ?>"/>
	</fieldset>
</form>
