$(document).ready(function(){
	$('.input-daterange').datepicker({
		format: "dd/mm/yyyy",
		todayHighlight: true
	});

	var slider = document.getElementById('price');
	var input0 = document.getElementById('price-from');
	var input1 = document.getElementById('price-to');
	var inputs = [input0, input1];

	noUiSlider.create(slider, {
		start: [0, 10000000],
		connect: true,
		range: {
			'min': 0,
			'max': 10000000
		},
		format: wNumb({
			decimals: 0,
			thousand: ',',
			suffix: ' đ',
		})
	});

	slider.noUiSlider.on('update', function(value, handle ){
		inputs[handle].value = value[handle];
	});

	slider.noUiSlider.on('update', function(){
		search();
	});

	function setSliderHandle(i, value) {
		var r = [null,null];
		r[i] = value;
		slider.noUiSlider.set(r);
	}

	inputs.forEach(function(input, handle) {
		input.addEventListener('change', function(){
			setSliderHandle(handle, this.value);
		});
		input.addEventListener('keydown', function( e ) {
			var values = slider.noUiSlider.get();
			var value = Number(value[handle]);
			var steps = slider.noUiSlider.steps();
			var step = steps[handle];
			var position;
			switch ( e.which ) {
				case 13:
				setSliderHandle(handle, this.value);
				break;
				case 38:
				position = step[1];
				if ( position === false ) {
					position = 1;
				}
				if ( position !== null ) {
					setSliderHandle(handle, value + position);
				}
				break;
				case 40:
				position = step[0];
				if ( position === false ) {
					position = 1;
				}
				if ( position !== null ) {
					setSliderHandle(handle, value - position);
				}
				break;
			}
		});
	});
});