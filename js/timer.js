function countingDown()
	{
		var currentDate = new Date();
		
		var hour = currentDate.getHours();
		if (hour<10) hour = "0"+hour;
		
		var minute = currentDate.getMinutes();
		if (minute<10) minute = "0"+minute;
		
		var second = currentDate.getSeconds();
		if (second<10) second = "0"+second;

		var year = currentDate.getFullYear();

		var month = currentDate.getMonth() + 1;
		if (month<10) month = "0"+month;

		var day = currentDate.getDay();
		if (day<10) day = "0"+day;

		document.getElementById("date").innerHTML = "Data:&emsp;&nbsp;" + day + "-" + month + "-" + year;
		document.getElementById("time").innerHTML = "Godzina:&emsp;" + hour + ":" + minute + ":" + second;
		 
		setTimeout("countingDown()",1000);
	}