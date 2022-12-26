
jQuery(document).ready( function () {
	
	
    jQuery('.iframe-btn').fancybox({
        'width': 880,
        'height': 570,
        'type': 'iframe',
        'autoScale': false,
    });
    
    // Executes a callback detecting changes with a frequency of 1 second
    jQuery(".image_path").observe_field(1, function( ) {
        // alert('Change observed! new value: ' + this.value );
        jQuery('#image_preview').attr('src',base_url+'media/source/'+this.value).show();
    });
    
    jQuery('[data-toggle="popover"]').popover();
    jQuery('[data-toggle="tooltip"]').tooltip();
        
	function responsive_filemanager_callback(field_id){
		console.log(field_id);
		var url=jQuery('#'+field_id).val();
		 /* ADD PANCHSOFT  [START] */
	    if(url=='') {
	 		jQuery('.'+field_id).hide();
		} else {
	 		jQuery('.'+field_id).show();
		}
	    jQuery('.'+field_id).attr('src',base_url+'source/'+url);
	    /* ADD PANCHSOFT  [END] */
	}
    
	
	
});
