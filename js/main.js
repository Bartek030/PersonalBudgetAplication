function setTime() {
	let currentDate = new Date();
	
	let hour = currentDate.getHours();
	if (hour<10) hour = "0"+hour;
	
	let minute = currentDate.getMinutes();
	if (minute<10) minute = "0"+minute;
	
	let second = currentDate.getSeconds();
	if (second<10) second = "0"+second;

	let year = currentDate.getFullYear();

	let month = currentDate.getMonth() + 1;
	if (month<10) month = "0"+month;

	let day = currentDate.getDate();
	if (day<10) day = "0"+day;

	$('#date').html(day + "-" + month + "-" + year);
	$('#time').html(hour + ":" + minute + ":" + second);
	$('#operationDate').val(year + '-' + month + '-' + day);
		
	setTimeout("setTime()",1000);
}
