$(document).ready(function() {

	var addedUsers = [],
			newIndex = 0;

	//Initiate list.js Lists
	var attendantList = new List('attendant-list', {
		valueNames: ['name', 'userType', 'grade-value','schoolProgram'],
		plugins: [ ListFuzzySearch() ]
	});

	var addAttendantList = new List('add-attendants-list', {
		valueNames: ['name', 'userType', 'schoolProgram'],
		page: 20,
		plugins: [ ListPagination({}), ListFuzzySearch() ]
	});

	//Wrapper for list.js filter function
	function filterAddAttendantList() {
		var accessSelectorValue = $('.accessSelector').val();
		var programSelectorValue = $('.programSelector').val();
		addAttendantList.filter(function(item){
			if ( (programSelectorValue === "Alla..." || programSelectorValue === item.values().schoolProgram) && (accessSelectorValue === "Alla..." || accessSelectorValue === item.values().userType ) ) {
				return true;
			} else {
				return false;
			}
		});
	}

	//Saves selected user info to object
	function addOrRemoveSelectedUser() {
		//get userid from checkbox
		var userId = this.id;
		userId = userId.slice( (userId.indexOf('[')+1) , userId.indexOf(']') );
		var $this = $(this);
		if (this.checked) { //add user object to array
			//get the rest of the user info
			var userFullName = $this.parent('td').next('.name').html(),
					userTypeName = $this.parent('td').nextAll('.userType').html(),
					programName = $this.parent('td').nextAll('.schoolProgram').html(),
					newUser = {};
			newUser.userId = userId;
			newUser.userName = userFullName;
			newUser.userTypeName = userTypeName;
			newUser.programName = programName;
			//add to global object
			addedUsers.push(newUser);
		} else { //remove user object from array
			addedUsers.forEach(function (elem, index) {
				if (elem.userId === userId ) {
					addedUsers.splice(index, 1);
				}
			});
		}
	}

	//initiate modal
	$('#addAttendantsModal').modal({
  	show: false,
  	backdrop: 'static'
	});

	//Bind controls

	//Bind checkbox click through list.js iteration.
	var listArray = addAttendantList.items;
	for (var i = 0; i < listArray.length; i++) {
		var trElement = listArray[i].elm;
		var checkbox = trElement.querySelector('input[type="checkbox"]');
		checkbox.addEventListener('click', addOrRemoveSelectedUser, true);
	}

	//mark grade as 'edited'
	$('.grade-select').on('change', function() {
		$(this).prev().attr('value', 'edit');
	});

	//show modal
	$('#add-attendant').on('click', function() {
		//show modal
		$('#addAttendantsModal').modal('show');
		//load php, callback = show modal with php return data.
	});

	//delete selected attendants
	$('#delete-attendant').on('click', function() {
		var idStr = "";
		$(".attendant-table input[type='checkbox']:checked").each(function() {
			//console.log($(this).attr('id'));
			idStr = $(this).attr('id'); 
			if ( idStr.indexOf('new') > 0 ) {
				//delete from list
				$(this).parents('tr').remove();
			} else {
				//extract id, mark input id value with 'delete', move to hidden table
				idStr = idStr.substr((idStr.indexOf("_")+1));
				$('input[name=attendantId_'+idStr+']').attr('value', 'delete');
				$(this).parents('tr').detach().appendTo('.removed-attendants');
			}
		});
		attendantList.update(); //update list.js list
	});

	//modal: add attendants
	$('#modal-add-attendants-btn').on('click', function() {
		var $tbody = $('.attendant-table tbody'),
				listedUsers = [];
		//make array of listed userIds
		$(".attendant-table input[name^='userId_']").each(function() {
			 listedUsers.push( $(this).attr('value') );
		});
		//Append user to list if not in listedUsers array
		addedUsers.forEach(function (elem) {
			if (listedUsers.indexOf(elem.userId) < 0) {
				var htmlStr = '<tr> \
	                <td class="attendant-checkbox"> \
	                  <input type="hidden" name="attendantId_new_'+newIndex+'" value="new" /> \
	                  <input type="hidden" name="attendantInfo_new_'+newIndex+'" value="'+elem.userId+'" /> \
	                  <input type="checkbox" name="attendantCheckbox_new_'+newIndex+'" id="attendantCheckbox_new_'+newIndex+'" class="rowSelectedCheckbox attendantCheckbox"> \
	                </td> \
	                <td class=""><input type="hidden" name="userId_'+elem.userId+'" value="'+elem.userId+'">'+elem.userName+'</td> \
	                <td class="userType hide-mobile">'+elem.userTypeName+'</td> \
	                <td class="grade hide-mobile"> \
	                  <input type="hidden" name="gradeStatus_new_'+newIndex+'" value="" class="grade-status"/> \
	                  <select name="grade_new_'+newIndex+'" class="form-control grade-select">';
						if (elem.userTypeName === 'Elev') {
							htmlStr += '<option class="grade-value" selected="selected" value="0">Inget</option> \
											<option value="IG">IG</option> \
	                    <option value="G">G</option> \
	                    <option value="VG">VG</option>';
	          } else {
	          	htmlStr += '<option class="grade-value" selected="selected" value="0">Inget</option>';
	          }
						htmlStr += '</select> \
	                </td> \
	                <td class="schoolProgram hide-mobile">'+elem.programName+'</td> \
	              </tr>';
				$tbody.append(htmlStr);
				newIndex++;
			}
		});
		attendantList.update(); //update list.js list
		$('#addAttendantsModal').modal('hide');
		//deselect modal checkboxes and empyt user array
		$('#add-attendants-list .rowSelectedCheckbox').prop("checked", false);
		addedUsers = [];
	});

	//modal: cancel and close buttons
	$('#modal-cancel-btn').on('click', function() {
		$('#add-attendants-list .rowSelectedCheckbox').prop("checked", false);
		addedUsers = [];
		$('#addAttendantsModal').modal('hide');
	});
	$('#modal-exit-btn').on('click', function() {
		$('#add-attendants-list .rowSelectedCheckbox').prop("checked", false);
		addedUsers = [];
		$('#addAttendantsModal').modal('hide');
	});

	//Bind filter function to selectors
	$('.filterSelector').on('change', function(){
		filterAddAttendantList();
	});

	//filter list on page load
	filterAddAttendantList();
	//sortAttendantList();

});