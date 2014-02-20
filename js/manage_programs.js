$(document).ready(function() {

	//initiate modal
	$('#addProgramModal').modal({
		show: false,
		backdrop: 'static'
	});

	//Bind controls

	//show modal
	$('#add-program').on('click', function() {
		$('#addProgramModal').modal('show');
	});

});