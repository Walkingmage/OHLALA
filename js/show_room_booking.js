$(document).ready(function() {

	$(".empty").popover({
		trigger: 'hover',
		placement: 'bottom',
		title: getDate,
		content: getBookedInfo
	});

	function getDate(){
		var thisDate = this.id;
		return thisDate;
	}

	function getBookedInfo() {
		return "Hej!";
	}

//	$(".empty").hover( handlerIn, handlerOut );
//
//	function showBooking() {
//		this.popover('toggle');
//	}
//
//	function hideBooking() {
//		this.popover('toggle');
//	}

});