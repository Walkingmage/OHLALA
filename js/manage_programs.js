$(document).ready(function() {

	//Initiate list.js List
	var programList = new List('test-list', {
		valueNames: ['schoolProgram']
	});

	//Saves checkbox id to hidden input field
	function setOrUnsetSelectedPrograms() {
		var programId = this.id;
		programId = programId.slice( (programId.indexOf('[')+1) , programId.indexOf(']') );
		var programIdStr = ' '+programId+',';
		var setIds = $("#archiveForm input[name='selectedPrograms']").val();
		if (setIds.indexOf(programIdStr) < 0 ) {
			setIds += programIdStr;
			$("#archiveForm input[name='selectedPrograms']").val(setIds);
		} else {
			setIds = setIds.replace(programIdStr, '');
			$("#archiveForm input[name='selectedPrograms']").val(setIds);
		}
	}

	//initiate modal
	$('#addProgramModal').modal({
		show: false,
		backdrop: 'static'
	});

	//Bind controls

	//add program
	$('#add-program').on('click', function() {
		$('#addProgramModal .modal-title').html("Lägg till program");
		$('#addProgramModal #modal-add-program-btn').html("Lägg till");
		$('#addProgramModal input[name="operationType"]').val('add');
		$('#addProgramModal input[name="programName"]').val('');
		$('#addProgramModal').modal('show');
	});

	//change program name
	$('.programNameLink').on('click', function(event) {
		event.preventDefault();
		$('#addProgramModal .modal-title').html("Ändra programnamn");
		$('#addProgramModal #modal-add-program-btn').html("Ändra");
		$('#addProgramModal input[name="operationType"]').val('edit');
		$('#addProgramModal input[name="programName"]').val($(this).html());
		$('#addProgramModal input[name="programId"]').val($(this).attr('id'));		
		$('#addProgramModal').modal('show');
	});

	//Bind checkbox click through list.js iteration.
	var listArray = programList.items;
	for (var i = 0; i < listArray.length; i++) {
		var trElement = listArray[i].elm;
		var checkbox = trElement.querySelector('input[type="checkbox"]');
		checkbox.addEventListener('click', setOrUnsetSelectedPrograms, true);
	}

	//Bind archive button to form around table
	$( "#archiveButton" ).click(function( event ) {
    $( "#archiveForm" ).submit();
	});

});