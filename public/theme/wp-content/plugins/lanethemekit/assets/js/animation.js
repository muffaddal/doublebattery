!function($) {
	var $input_animation = $('#lane_wowanimation');
	var $input_effect = $('#lane_effect');
	var $input_duration = $('#lane_duration');
	var $input_delay = $('#lane_delay');

	if($input_animation.length>0){
		//set Event
		$('#lane_effect,#lane_duration,#lane_delay').change(function(event) {
			$input_animation.val($input_effect.val()+'|'+$input_duration.val()+'|'+$input_delay.val());
		}).keyup(function(event) {
			$input_animation.val($input_effect.val()+'|'+$input_duration.val()+'|'+$input_delay.val());
		});;

		// Set Value Default
		var $value = $input_animation.val().split('|');
		$input_effect.val($value[0]);
		$input_duration.val($value[1]);
		$input_delay.val($value[2]);
	}
}(window.jQuery);
