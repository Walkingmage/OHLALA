$(document).ready(function() {

	$(".booked_fm, .booked_em").popover({
		trigger: 'hover',
		placement: 'bottom',
		title: getDate,
		html: true,
		content: getBookedInfo
	});

	function getDate(){
		var thisDate = this.id;
		return thisDate;
	}

	function getBookedInfo() {
		var dates = $(this).children('span').attr('class');
		var startDate = dates.substr(0,10);
		var endDate = dates.substr(11,10);
		var userName = dates.substr(21);
		var contentText = "<p>Start: "+startDate+"</p>"+"<p>End: "+endDate+"</p>"+"<p>Booked by: "+userName+"</p>";
		return contentText;
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