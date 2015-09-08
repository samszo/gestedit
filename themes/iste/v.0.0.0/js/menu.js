function padd_toggle(classname,value) {
	jQuery(classname).focus(function() {
		if (value == jQuery(classname).val()) {
			jQuery(this).val('');
		}
	});
	jQuery(classname).blur(function() {
		if ('' == jQuery(classname).val()) {
			jQuery(this).val(value);
		}
	});
}


jQuery(document).ready(function() {
	jQuery.noConflict();

	jQuery('.mainmenu > ul').superfish({
		autoArrows: false,
		hoverClass: 'hover',
		speed: 500,
		animation: { opacity: 'show' }
	});
});