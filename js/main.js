function countingDown()
	{
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

		let day = currentDate.getDay();
		if (day<10) day = "0"+day;

		document.getElementById("date").innerHTML = "Data:&emsp;&nbsp;" + day + "-" + month + "-" + year;
		document.getElementById("time").innerHTML = "Godzina:&emsp;" + hour + ":" + minute + ":" + second;
		 
		setTimeout("countingDown()",1000);
	}

