function get_checked_value(checkboxes) {
   var vals = Array.from(checkboxes)
      .filter(checkbox => checkbox.checked)
      .map(checkbox => checkbox.value)
      .join(",");
}

function grid_continuous_costing_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
 	try{
   		// Opera 8.0+, Firefox, Safari
   		ajaxRequest = new XMLHttpRequest();
 	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
		}
 	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit.");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&unit_id="+unit_id+"&spl="+sql;
   	url =  hostname+"grid_con/grid_continuous_costing_report/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			continuous_costing_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_costing_report.document.write(resp);
		}
	}
}
function daily_report(s) {
	// alert(s);
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id ==''){
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';

	var queryString="firstdate="+firstdate+"&emp_id="+sql+"&unit_id="+unit_id+"&report_type="+s;
	url = hostname + "grid_con/daily_report/";


	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function () {
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
		}
	}
}
// compliance
function salary_sheet_com(){
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/salary_sheet_com/";
	document.getElementById('loaader').style.display = 'flex';
   //
	ajaxRequest = new XMLHttpRequest();
   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

   	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function pay_slip_com()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month year");
		return false;
	}

	var year_month = report_month_sal+"-"+"01";
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var queryString="salary_month="+year_month+"&sql="+sql+"&unit_id="+unit_id;
   	url =  hostname+"salary_report_con/pay_slip_com/";
	document.getElementById('loaader').style.display = 'flex';

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);
   	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			pay_slip = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			pay_slip.document.write(resp);
			//pay_slip.stop();
		}
	}
}
function salary_summary_com()
{
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/salary_summary_com/";

	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);

    ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function sec_sal_summary_com(){

	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = 1;

	var sal_year_month = report_month_sal+"-"+"01";
	document.getElementById('loaader').style.display = 'flex';

	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&stop_salary="+stop_salary;
   	url =  hostname+"salary_report_con/sec_sal_summary_com/";

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			summary_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			summary_report.document.write(resp);
			//summary_report.stop();
		}
	}
}
function eot_sheet_com_9()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month year");
		return false;
	}

	var year_month = report_month_sal+"-"+"01";
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = document.getElementById('status').value;

	var queryString="salary_month="+year_month+"&sql="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"salary_report_con/eot_sheet_com_9/";
	document.getElementById('loaader').style.display = 'flex';

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);
   	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			pay_slip = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			pay_slip.document.write(resp);
			//pay_slip.stop();
		}
	}
}
function eot_sheet_com_12()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month year");
		return false;
	}

	var year_month = report_month_sal+"-"+"01";
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = document.getElementById('status').value;

	var queryString="salary_month="+year_month+"&sql="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"salary_report_con/eot_sheet_com_12/";
	document.getElementById('loaader').style.display = 'flex';

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);
   	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			pay_slip = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			pay_slip.document.write(resp);
			//pay_slip.stop();
		}
	}
}
function eot_sheet_com_all()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month year");
		return false;
	}

	var year_month = report_month_sal+"-"+"01";
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = document.getElementById('status').value;

	var queryString="salary_month="+year_month+"&sql="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"salary_report_con/eot_sheet_com_all/";
	document.getElementById('loaader').style.display = 'flex';

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);
   	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			pay_slip = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			pay_slip.document.write(resp);
			//pay_slip.stop();
		}
	}
}
// end compliance

// actual monthly salary
function actual_salary_sheet()
{
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/actual_salary_sheet/";

	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

    ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}

function actual_pay_slip(){
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/actual_pay_slip/";
	document.getElementById('loaader').style.display = 'flex';


	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

    ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function actual_salary_summary()
{
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/actual_salary_summary/";
	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);

    ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function actual_sec_sal_summary(){

	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = 1;

	var sal_year_month = report_month_sal+"-"+"01";

	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&stop_salary="+stop_salary;
   	url =  hostname+"salary_report_con/actual_sec_sal_summary/";
	document.getElementById('loaader').style.display = 'flex';

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			summary_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			summary_report.document.write(resp);
			//summary_report.stop();
		}
	}
}
function actual_eot_sheet(){
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/actual_eot_sheet/";
	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);

    ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function actual_eot_summary(){
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
   	url =  hostname+"salary_report_con/actual_eot_summary/";

	ajaxRequest = new XMLHttpRequest();
   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

   	ajaxRequest.onreadystatechange = function(){
	document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function actual_salary_sheet_bank()
{
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/actual_salary_sheet_bank/";


	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

    ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function actual_eot_sheet_bank()
{
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month ");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var stop_salary = document.getElementById('stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var queryString="salary_month="+salary_month+"&unit_id="+unit_id+"&sql="+sql+"&stop_salary="+stop_salary+"&status="+status;
    url =  hostname+"salary_report_con/actual_eot_sheet_bank/";


	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

    ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
// end actual monthly salary


function daily_costing_summary()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	var status = document.getElementById('status').value;
	var queryString="firstdate="+firstdate+"&unit_id="+unit_id+"&status="+status;
    url =  hostname+"grid_con/daily_costing_summary/";
	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest = new XMLHttpRequest();
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

   ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function daily_attendance_summary()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}
	document.getElementById('loaader').style.display = 'flex';
	var status = document.getElementById('status').value;
	var queryString="firstdate="+firstdate+"&unit_id="+unit_id+"&status="+status;
    url =  hostname+"grid_con/daily_attendance_summary/";


	ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function () {
	   document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}
function daily_logout_report()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit options");
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var status = document.getElementById('status').value;
	var queryString="firstdate="+firstdate+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/daily_logout_report/";


	ajaxRequest = new XMLHttpRequest();
   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

   	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
		}
	}
}

// attendance Report actual
function grid_continuous_present_report()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var status = "P";
	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_continuous_report/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
function grid_continuous_absent_report()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var status = "A";
	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_continuous_report/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
function grid_continuous_late_report()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var status = "LA";
	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_continuous_report/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}

function continuous_leave_report()
{
	var ajaxRequest = new XMLHttpRequest();
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var status = "L";

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql;
    url =  hostname+"grid_con/continuous_leave_report/";

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			_leave_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			_leave_report.document.write(resp);
			//continuous_leave_report.stop();
		}
	}
}

function grid_actual_present_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
   if (sql =='') {
		alert('Please select employee Id');
      return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var status = "P";
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_actual_present_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			//daily_present_report.stop();
		}
	}
}
function holiday_weekend_attn_report(status)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//

	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/holiday_weekend_attn_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_holiday_weekend_absent_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_holiday_weekend_absent_report.document.write(resp);
			//daily_holiday_weekend_absent_report.stop();
		}
	}
}
// end attendance Report actual

// Increment report and promotion report start
function last_increment_promotion(status)
{
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="status="+status+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/last_increment_promotion/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
function ot_acknowledgement_sheet(status)
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/ot_acknowledgement_sheet/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
function increment_able_employee()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/increment_able_employee/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
function unit_transferred_list(type)
{
	var firstdate = document.getElementById('firstdate').value;
	var seconddate = document.getElementById('seconddate').value;

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&type="+type+"&seconddate="+seconddate;
	url =  hostname+"grid_con/unit_transferred_list/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
function iftar_bill_list()
{
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	// if(seconddate =='')
	// {
	// 	alert("Please select Second date");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&seconddate="+seconddate;
	url =  hostname+"grid_con/iftar_bill_list/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
function emp_conformation_list(status)
{
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;

	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest = new XMLHttpRequest();

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
    url =  hostname+"grid_con/emp_conformation_list/";
	//
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_present_report.document.write(resp);
			//continuous_present_report.stop();
		}
	}
}
// Increment report and promotion report end

// left letter start
function grid_letter_report(status)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return false;
	}
	document.getElementById('loaader').style.display = 'flex';
	var queryString="unit_id="+unit_id+"&firstdate="+firstdate+"&status="+status;
	url =  hostname+"grid_con/grid_letter_report/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			letter_1 = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			letter_1.document.write(resp);
		}
	}
}
// left letter end
function grid_incre_prom_report(type){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	var seconddate = document.getElementById('seconddate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}
	if(seconddate ==''){
		alert("Please select Second date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select Unit");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	document.getElementById('loaader').style.display = 'flex';
	var queryString="first_date="+firstdate+"&second_date="+seconddate+"&spl="+sql+"&type="+type;
	url =  hostname+"grid_con/incre_prom_report/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function () {
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			continuous_increment_promotion = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_increment_promotion.document.write(resp);
		}
	}
}
function join_letter(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';

	var queryString="spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_join_letter/";
	//
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//
			grid_join_letter = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			grid_join_letter.document.write(resp);
			//grid_join_letter.stop();
		}
	}
}
function id_card(status){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
    var sql = get_checked_value(checkboxes);
    if (sql =='') {
	alert('Please select employee Id');
      return false;
    }

	document.getElementById('loaader').style.display = 'flex';

	var queryString="emp_id="+sql+"&unit_id="+unit_id+"&status="+status;
	url =  hostname + "grid_con/id_card/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
			daily_present_report.document.write(resp);
		}
	}
}
function grid_job_card()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&unit_id="+unit_id+"&spl="+sql;
   	url =  hostname+"grid_con/grid_job_card/";

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function () {
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			job_card = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			job_card.document.write(resp);
			job_card.stop();
		}
	}
}
function grid_new_join_report(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		 //Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate ==''){
		alert("Please select Second date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select Category options");
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_new_join_report/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			new_join_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			new_join_report.document.write(resp);
		}
	}
}
function grid_resign_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var status = document.getElementById('status').value;
	if(status != 3)
	{
		alert("Please select category status to Resign");
		return false;
	}

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&unit_id="+unit_id;
    url =  hostname+"grid_con/grid_resign_report/";

	document.getElementById('loaader').style.display = 'flex';

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			resign_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			resign_report.document.write(resp);
			//resign_report.stop();
		}
	}
}
function grid_left_report(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id == 'Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;
	if(status != 2)
	{
		alert("Please select category status to Left");
		return false;
	}

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/grid_left_report/";

	document.getElementById('loaader').style.display = 'flex';

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			left_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			left_report.document.write(resp);
			// left_report.stop();
		}
	}
}
function grid_general_info()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	var queryString="spl="+sql+"&unit_id="+unit_id;

	url =  hostname+"grid_con/grid_general_info/";

	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			general_info = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			general_info.document.write(resp);
			//general_info.stop();
		}
	}
}
function grid_earn_leave(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	//alert('hello');
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	// hostname = window. location.href;


	var queryString="spl="+sql+"&unit_id="+unit_id;
   	url =  hostname+"grid_con/grid_earn_leave_report/";

	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			extra_ot = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			extra_ot.document.write(resp);
		}
	}
}
function grid_yearly_leave_register(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	var seconddate = document.getElementById('seconddate').value;

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_yearly_leave_register/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			yearly_leave_reister = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			yearly_leave_reister.document.write(resp);
			//yearly_leave_reister.stop();
		}
	}
}
function worker_register(){
	var ajaxRequest;
	try{
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var queryString="spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/worker_register/";
	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			general_info = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			general_info.document.write(resp);
		}
	}
}
function grid_emp_job_application(){
	//alert();
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var queryString="spl="+sql+"&unit_id="+unit_id;
    url =  hostname+"grid_con/grid_emp_job_application/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			job_letter = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			job_letter.document.write(resp);
			//job_letter.stop();
		}
	}
}
function grid_employee_information()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var queryString="spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_employee_information/";
	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			employee_information = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			employee_information.document.write(resp);
			//employee_information.stop();
		}
	}
}
function grid_final_satalment(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return false;
	}
	var status = document.getElementById('status').value;
	if(status !=4){
		alert("Please select resign status !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == ''){
		alert('Please select employee Id');
		return false;
	}
	var queryString="spl="+sql+"&unit_id="+unit_id+'&status'+status;
	url =  hostname+"grid_con/grid_final_satalment/";
	document.getElementById('loaader').style.display = 'flex';
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			service_book = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			service_book.document.write(resp);
			//service_book.stop();
		}
	}
}
function grid_eot_actual() {
	var ajaxRequest; // The variable that makes Ajax possible!
	try {
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer Browsers
		try {
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
		try {
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
		}
	}

	var firstdate = document.getElementById("firstdate").value;
	if (firstdate == "") {
	alert("Please select First date");
	return false;
	}
	var seconddate = document.getElementById("seconddate").value;
	if (seconddate == "") {
	alert("Please select Second date");
	return false;
	}

	var unit_id = document.getElementById("unit_id").value;
	if (unit_id == "Select") {
	alert("Please select unit !");
	return false;
	}

	var checkboxes = document.getElementsByName("emp_id[]");
	var sql = get_checked_value(checkboxes);

	if (sql == "") {
	alert("Please select employee Id");
	return false;
	}

	document.getElementById("loaader").style.display = "flex";

	var queryString = "firstdate=" + firstdate + "&seconddate=" + seconddate + "&spl=" + sql + "&unit_id=" + unit_id;
	url = hostname + "grid_con/grid_eot_actual/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function () {
		document.getElementById("loaader").style.display = "none";
		if (ajaxRequest.readyState == 4) {
			var resp = ajaxRequest.responseText;
			extra_ot = window.open("","_blank","menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
			extra_ot.document.write(resp);
			extra_ot.stop();
		}
	};
}
function grid_extra_ot_9pm(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	    // Internet Explorer Browsers
	    try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	    }catch (e) {
	        try{
	           ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	        }catch (e){
	           // Something went wrong
	           alert("Your browser broke!");
	           return false;
	        }
	    }
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate ==''){
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql;
    url =  hostname+"grid_con/grid_extra_ot_9pm/";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function () {
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			daily_present_report.stop();
		}
	}
}
function grid_extra_ot_12am(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	    // Internet Explorer Browsers
	    try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	    }catch (e) {
	        try{
	           ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	        }catch (e){
	           // Something went wrong
	           alert("Your browser broke!");
	           return false;
	        }
	    }
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate ==''){
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql;
    url =  hostname+"grid_con/grid_extra_ot_12am/";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function () {
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			daily_present_report.stop();
		}
	}
}
function grid_extra_ot_all() {
	var ajaxRequest; // The variable that makes Ajax possible!
	try {
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer Browsers
		try {
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
		try {
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
		}
	}

	var firstdate = document.getElementById("firstdate").value;
	if (firstdate == "") {
	alert("Please select First date");
	return false;
	}
	var seconddate = document.getElementById("seconddate").value;
	if (seconddate == "") {
	alert("Please select Second date");
	return false;
	}

	var unit_id = document.getElementById("unit_id").value;
	if (unit_id == "Select") {
	alert("Please select Category options");
	return false;
	}
	var checkboxes = document.getElementsByName("emp_id[]");
	var sql = get_checked_value(checkboxes);
	if (sql == "") {
	alert("Please select employee Id");
	return false;
	}

	document.getElementById("loaader").style.display = "flex";
	var queryString = "firstdate=" + firstdate + "&seconddate=" + seconddate + "&spl=" + sql;
	var url = hostname + "grid_con/grid_extra_ot_all/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function () {
		document.getElementById("loaader").style.display = "none";
		if (ajaxRequest.readyState == 4) {
			var resp = ajaxRequest.responseText;
			daily_present_report = window.open("", "_blank", "menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
			daily_present_report.document.write(resp);
			daily_present_report.stop();
		}
	};
}
function grid_continuous_incre_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;


    url =  hostname+"grid_con/continuous_incre_report/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function () {
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_incre_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_incre_report.document.write(resp);
			//continuous_incre_report.stop();
		}
	}
}
function grid_continuous_prom_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;

	document.getElementById('loaader').style.display = 'flex';
    url =  hostname+"grid_con/continuous_prom_report/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_prom_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_prom_report.document.write(resp);
			//continuous_prom_report.stop();
		}
	}
}
function grid_continuous_ot_eot_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var status = "P";
	document.getElementById('loaader').style.display = 'flex';

	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_continuous_ot_eot_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_ot_eot_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_ot_eot_report.document.write(resp);
			//continuous_ot_eot_report.stop();
		}
	}
}
function grid_continuous_max_ot_day()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var max = document.getElementById('max_ot').value;
	if(max =='')
	{
		alert("Please select max OT !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';

	var query="firstdate="+firstdate+"&seconddate="+seconddate+"&max_ot="+max+"&spl="+sql+"&unit_id="+unit_id;
   	url = hostname + "grid_con/grid_continuous_max_ot_day";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(query);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			continuous_ot_eot_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_ot_eot_report.document.write(resp);
		}
	}
}

function grid_maternity_benefit(type){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var status = "P";
	document.getElementById('loaader').style.display = 'flex';

	var queryString="type="+type+"&unit_id="+unit_id+"&spl="+sql;
   	url =  hostname+"grid_con/grid_maternity_benefit/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			maternity_benefit = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			maternity_benefit.document.write(resp);
			//continuous_ot_eot_report.stop();
		}
	}
}
function grid_monthly_att_register(i = null)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month and year selection");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = i;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/grid_monthly_att_register/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			monthly_att_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_att_register.document.write(resp);
			//monthly_att_register.stop();
		}
	}
}
function grid_monthly_night_register(i=null)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month and year selection");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = i;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/grid_monthly_night_register/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			monthly_att_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_att_register.document.write(resp);
			//monthly_att_register.stop();
		}
	}
}
function grid_monthly_att_register_ot(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date for month and year selection");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select Category options");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	document.getElementById('loaader').style.display = 'flex';
   var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_monthly_att_register_ot/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			continuous_costing_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_costing_report.document.write(resp);
		}
	}

}
function grid_monthly_ot_register()
{

	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month selection");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	// hostname = window.location.hre f ;
	//
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
   	url =  hostname+"grid_con/grid_monthly_ot_register/";
	document.getElementById('loaader').style.display = 'flex';

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			monthly_ot_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_ot_register.document.write(resp);
			//monthly_ot_register.stop();
		}
	}
}
function grid_monthly_eot_register()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month selection");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
    url =  hostname+"grid_con/grid_monthly_eot_register/";
	document.getElementById('loaader').style.display = 'flex';

    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			monthly_eot_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_eot_register.document.write(resp);
			//monthly_eot_register.stop();
		}
	}
}
function grid_comprative_salary_statement()
{

	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select month");
		return false;
	}

	var second_month = document.getElementById('secondary_month').value;
	if(second_month =='')
	{
		alert("Please select second month");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var status = document.getElementById('status').value;

	var queryString="salary_month="+salary_month+"&second_month="+second_month+"&status="+status+"&unit_id="+unit_id;
	url =  hostname+"salary_report_con/grid_comprative_salary_statement/";
	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			festival_bonus_summary = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			festival_bonus_summary.document.write(resp);
		}
	}
}
function grid_salary_sheet_with_eot_bank()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}

	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select year and month");
		return;
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var queryString="salary_month="+salary_month+"&status="+status+"&sql="+sql+"&unit_id="+unit_id;
	url =  hostname+"salary_report_con/grid_salary_sheet_with_eot_bank/";
	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			festival_bonus_summary = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			festival_bonus_summary.document.write(resp);
		}
	}
}
function grid_monthly_allowance_sheet()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var salary_month = document.getElementById('salary_month').value;
	if(salary_month =='')
	{
		alert("Please select year and month");
		return;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var status = document.getElementById('status').value;

	var queryString="salary_month="+salary_month+"&status="+status+"&unit_id="+unit_id+"&sql="+sql;
   	url = hostname+"salary_report_con/grid_monthly_allowance_sheet/";
	document.getElementById('loaader').style.display = 'flex';

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			monthly_allowance_sheet = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_allowance_sheet.document.write(resp);
			//monthly_allowance_sheet.stop();
		}
	}
}




















// =======================================================
	// old code
// =======================================================

function grid_get_all_data_for_salary() {
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
	ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
	try{
	 ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}catch (e){
	 // Something went wrong
	 alert("Your browser broke!");
	 return false;
	}
	}
	}
	var start = document.getElementById('unit_id').value;
	if(start == "Select" || start == ''){
		alert("Please select ALL");
		return false;
	}
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal ==''){
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal ==''){
	// 	alert("Please select year");
	// 	return false;
	// }

	var year_month = report_year_sal+"-"+report_month_sal;
	//alert(year_month);
 	//var queryString="year_month="+year_month;
	 var queryString="start="+start;


	url =  hostname + "payroll_con/manual_atten_co/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString);


	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//alert(resp);
			alldata = resp.split("$$$");

			dept_idname = alldata[0].split("===");
			var dept_id = dept_idname[0].split("***");
			var dept_name = dept_idname[1].split("***");

			document.grid.grid_dept.options.length=0;
			document.grid.grid_dept.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<dept_id.length; i++){
				document.grid.grid_dept.options[i+1]=new Option(dept_name[i],dept_id[i], false, false);
			}

			sec_idname = alldata[1].split("===");
			sec_id = sec_idname[0].split("***");
			sec_name = sec_idname[1].split("***");

			document.grid.grid_section.options.length=0;
			document.grid.grid_section.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<sec_id.length; i++){
				//alert(sec_name[i]);
				document.grid.grid_section.options[i+1]=new Option(sec_name[i],sec_id[i], false, false);
			}


			line_idname = alldata[2].split("===");
			line_id = line_idname[0].split("***");
			line_name = line_idname[1].split("***");

			document.grid.grid_line.options.length=0;
			document.grid.grid_line.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<line_id.length; i++){
				document.grid.grid_line.options[i+1]=new Option(line_name[i],line_id[i], false, false);
			}


			desig_idname = alldata[3].split("===");
			desig_id = desig_idname[0].split("***");
			desig_name = desig_idname[1].split("***");

			document.grid.grid_desig.options.length=0;
			document.grid.grid_desig.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<desig_id.length; i++){
				document.grid.grid_desig.options[i+1]=new Option(desig_name[i],desig_id[i], false, false);
			}

			var sex_id = ["1","2"];
			var sex_name = ["Male","Female"];

			document.grid.grid_sex.options.length=0;
			document.grid.grid_sex.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<sex_id.length; i++){
				document.grid.grid_sex.options[i+1]=new Option(sex_name[i],sex_id[i], false, false);
			}

			status_idname = alldata[4].split("===");
			status_id = status_idname[0].split("***");
			status_name = status_idname[1].split("***");

			document.grid.status.options.length=0;
			//document.grid.status.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<status_id.length; i++){
				document.grid.status.options[i]=new Option(status_name[i],status_id[i], false, false);
			}
			document.grid.status.options[i]=new Option("ALL","ALL", true, true);


			var w_type_id = ["1","2"];
			var w_type_name = ["Cash","Bank"];

			document.grid.grid_w_type.options.length=0;
			document.grid.grid_w_type.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<w_type_id.length; i++){
				document.grid.grid_w_type.options[i+1]=new Option(w_type_name[i],w_type_id[i], false, false);
			}

			var position_id = ["1","2"];
			var position_name = ["Stuff","Worker"];

			document.grid.grid_position.options.length=0;
			document.grid.grid_position.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<position_id.length; i++){
				document.grid.grid_position.options[i+1]=new Option(position_name[i],position_id[i], false, false);
			}



		$('#list1').jqGrid('GridUnload');



		url =  hostname + "grid_con/grid_get_all_data_for_salary/"+year_month+"/"+start;
		//var url = "http://localhost/payroll/grid_con/grid_get_all_data";
		main_grid(url)


		}
	}
}

function grid_get_all_data(){
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}
		var start = document.getElementById('unit_id').value;
		if (start == "Select" || start == ''){
			alert("Please select ALL");
			return false;
		}
	//alert(start);

	var queryString="start="+start;


	url =  hostname + "payroll_con/manual_atten_co/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString);


	ajaxRequest.onreadystatechange = function(){
	var resp = ajaxRequest.responseText;
	if(ajaxRequest.readyState == 4){
		var resp = ajaxRequest.responseText;
		//alert(resp);
		alldata = resp.split("$$$");

		dept_idname = alldata[0].split("===");
		var dept_id = dept_idname[0].split("***");
	    var dept_name = dept_idname[1].split("***");

		document.grid.grid_dept.options.length=0;
		document.grid.grid_dept.options[0]=new Option("Select","Select", true, false);
		for (i=0; i<dept_id.length; i++){
			document.grid.grid_dept.options[i+1]=new Option(dept_name[i],dept_id[i], false, false);
		}

		sec_idname = alldata[1].split("===");
		sec_id = sec_idname[0].split("***");
		sec_name = sec_idname[1].split("***");
		//alert(sec_idname);
		document.grid.grid_section.options.length=0;
		document.grid.grid_section.options[0]=new Option("Select","Select", true, false);
		for (i=0; i<sec_id.length; i++){
			//alert(sec_name[i]);
			document.grid.grid_section.options[i+1]=new Option(sec_name[i],sec_id[i], false, false);
		}


		line_idname = alldata[2].split("===");
		line_id = line_idname[0].split("***");
		line_name = line_idname[1].split("***");

		document.grid.grid_line.options.length=0;
		document.grid.grid_line.options[0]=new Option("Select","Select", true, false);
		for (i=0; i<line_id.length; i++){
			document.grid.grid_line.options[i+1]=new Option(line_name[i],line_id[i], false, false);
		}


		desig_idname = alldata[3].split("===");
		desig_id = desig_idname[0].split("***");
		desig_name = desig_idname[1].split("***");

		document.grid.grid_desig.options.length=0;
		document.grid.grid_desig.options[0]=new Option("Select","Select", true, false);
		for (i=0; i<desig_id.length; i++){
			document.grid.grid_desig.options[i+1]=new Option(desig_name[i],desig_id[i], false, false);
		}

		var sex_id = ["1","2"];
		var sex_name = ["Male","Female"];

		document.grid.grid_sex.options.length=0;
		document.grid.grid_sex.options[0]=new Option("Select","Select", true, false);
		for (i=0; i<sex_id.length; i++){
			document.grid.grid_sex.options[i+1]=new Option(sex_name[i],sex_id[i], false, false);
		}
		var position_id = ["1","2"];
		var position_name = ["Stuff","Worker"];

		document.grid.grid_position.options.length=0;
		document.grid.grid_position.options[0]=new Option("Select","Select", true, false);
		for (i=0; i<sex_id.length; i++){
			document.grid.grid_position.options[i+1]=new Option(position_name[i],position_id[i], false, false);
		}

		status_idname = alldata[4].split("===");
		status_id = status_idname[0].split("***");
		status_name = status_idname[1].split("***");

		document.grid.status.options.length=0;
		//document.grid.status.options[0]=new Option("Select","Select", true, false);
		for (i=0; i<status_id.length; i++){
			document.grid.status.options[i]=new Option(status_name[i],status_id[i], false, false);
		}
		document.grid.status.options[i]=new Option("ALL","ALL", true, true);

		$('#list1').jqGrid('GridUnload');



		url =  hostname + "grid_con/grid_get_all_data/"+start;
		//var url = "http://localhost/payroll/grid_con/grid_get_all_data";
		main_grid(url)
	}
	}
}
function grid_get_all_data_for_entry(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}
	 var start = document.getElementById('unit_id').value;
	 if(start == "Select" || start == '')
	 {
		 alert("Please select ALL");
		 return false;
	 }
	 //alert(start);

	 var queryString="start="+start;


	 url =  hostname + "payroll_con/manual_atten_co/";
	 ajaxRequest.open("POST", url, true);
	 ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 ajaxRequest.send(queryString);


	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			// alert(resp);
			alldata = resp.split("$$$");
			// alert(alldata);

			dept_idname = alldata[0].split("===");
			var dept_id = dept_idname[0].split("***");
		    var dept_name = dept_idname[1].split("***");

			document.grid.grid_dept.options.length=0;
			document.grid.grid_dept.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<dept_id.length; i++){
				document.grid.grid_dept.options[i+1]=new Option(dept_name[i],dept_id[i], false, false);
			}

			sec_idname = alldata[1].split("===");
			sec_id = sec_idname[0].split("***");
			sec_name = sec_idname[1].split("***");
			//alert(sec_idname);
			document.grid.grid_section.options.length=0;
			document.grid.grid_section.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<sec_id.length; i++){
				//alert(sec_name[i]);
				document.grid.grid_section.options[i+1]=new Option(sec_name[i],sec_id[i], false, false);
			}


			line_idname = alldata[2].split("===");
			line_id = line_idname[0].split("***");
			line_name = line_idname[1].split("***");

			document.grid.grid_line.options.length=0;
			document.grid.grid_line.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<line_id.length; i++){
				document.grid.grid_line.options[i+1]=new Option(line_name[i],line_id[i], false, false);
			}


			desig_idname = alldata[3].split("===");
			desig_id = desig_idname[0].split("***");
			desig_name = desig_idname[1].split("***");

			document.grid.grid_desig.options.length=0;
			document.grid.grid_desig.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<desig_id.length; i++){
				document.grid.grid_desig.options[i+1]=new Option(desig_name[i],desig_id[i], false, false);
			}

			var sex_id = ["1","2"];
			var sex_name = ["Male","Female"];

			document.grid.grid_sex.options.length=0;
			document.grid.grid_sex.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<sex_id.length; i++){
				document.grid.grid_sex.options[i+1]=new Option(sex_name[i],sex_id[i], false, false);
			}

			var position_id = ["1","2"];
			var position_name = ["Stuff","Worker"];

			document.grid.grid_position.options.length=0;
			document.grid.grid_position.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<sex_id.length; i++){
				document.grid.grid_position.options[i+1]=new Option(position_name[i],position_id[i], false, false);
			}

			var miss_id = ["1","2"];
			var miss_name = ["In Miss","Out Miss"];
			document.grid.grid_out_miss.options.length=0;
			document.grid.grid_out_miss.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<sex_id.length; i++){
				document.grid.grid_out_miss.options[i+1]=new Option(miss_name[i],miss_id[i], false, false);
			}

			status_idname = alldata[4].split("===");
			status_id = status_idname[0].split("***");
			status_name = status_idname[1].split("***");

			document.grid.status.options.length=0;
			//document.grid.status.options[0]=new Option("Select","Select", true, false);
			for (i=0; i<status_id.length; i++){
				document.grid.status.options[i]=new Option(status_name[i],status_id[i], false, false);
			}
			document.grid.status.options[i]=new Option("ALL","ALL", true, true);

		$('#list1').jqGrid('GridUnload');



		url =  hostname + "grid_con/grid_get_all_data/"+start;
		//var url = "http://localhost/payroll/grid_con/grid_get_all_data";
		main_grid(url)


		}
	}

}


function act_advance_salary_sheet(){
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return;
	// }

	var grid_start = document.getElementById('unit_id').value;
	if(grid_start =='Select'){
		alert("Please select Category options");
		return;
	}

	var grid_status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var sal_year_month =report_month_sal+"-"+"01";




	url =  hostname+"salary_report_con/act_advance_salary_sheet/";
	var queryString="sal_year_month="+sal_year_month+"&grid_status="+grid_status+"&sql="+sql+"&unit_id="+grid_start;

	//    $(".clearfix").dialog("open");
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			// $(".clearfix").dialog("close");
			sal_sheet_actual_with_eot = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual_with_eot.document.write(resp);
			sal_sheet_actual_with_eot.stop();
		}
	}

}


function grid_per_file(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){ alert("Please select Category options"); return false; }

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	//
	//
	url =  hostname + "grid_con/grid_per_file/"+sql;

	per_file = window.open(url,'per_file',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	per_file.moveTo(0,0);
}

function grid_all_search_for_salary(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
	  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
	  try{
	     ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	  }catch (e){
	     // Something went wrong
	     alert("Your browser broke!");
	     return false;
	  }
	}
	}
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal ==''){
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal ==''){
	// 	alert("Please select year");
	// 	return false;
	// }

	var year_month = report_year_sal+"-"+report_month_sal;
	//alert(year_month);
	var start 		= document.getElementById('unit_id').value;
	var dept 		= document.getElementById('grid_dept').value;
	var section 	= document.getElementById('grid_section').value;
	var line 		= document.getElementById('grid_line').value;
	var designation = document.getElementById('grid_desig').value;
	var sex 		= document.getElementById('grid_sex').value;
	var status 		= document.getElementById('status').value;
	var w_type 		= document.getElementById('grid_w_type').value;
	var position 	= document.getElementById('grid_position').value;
	// alert(start+','+dept+','+section+','+line+','+designation+','+sex+','+status+','+w_type+','+position);
	$('#list1').jqGrid('GridUnload');
	// alert(sex);return false;


	url =  hostname + "grid_con/grid_all_search_for_salary/"+dept+"/"+section+"/"+line+"/"+designation+"/"+sex+"/"+status+"/"+year_month+"/"+start+"/"+w_type+"/"+position;
	//var url = "http://localhost/payroll/grid_con/grid_all_search/"+dept+"/"+section+"/"+line+"/"+designation;
	main_grid(url)
}

function grid_all_search(){
	var dept 		= document.getElementById('grid_dept').value;
	var section 	= document.getElementById('grid_section').value;
	var line 		= document.getElementById('grid_line').value;
	var designation = document.getElementById('grid_desig').value;
	var sex 		= document.getElementById('grid_sex').value;
	var status 		= document.getElementById('status').value;
	var start 		= document.getElementById('unit_id').value;
	var position 	= document.getElementById('grid_position').value;

	$('#list1').jqGrid('GridUnload');



	url =  hostname + "grid_con/grid_all_search/"+dept+"/"+section+"/"+line+"/"+designation+"/"+sex+"/"+status+"/"+start+"/"+position;
	main_grid(url)
}

function grid_all_search_out_miss(){
	var f_date 		= document.getElementById('firstdate').value;
	var dept 		= document.getElementById('grid_dept').value;
	var section 	= document.getElementById('grid_section').value;
	var line 		= document.getElementById('grid_line').value;
	var designation = document.getElementById('grid_desig').value;
	var sex 		= document.getElementById('grid_sex').value;
	var status 		= document.getElementById('status').value;
	var start 		= document.getElementById('unit_id').value;
	var position 	= document.getElementById('grid_position').value;
	var out_miss 	= document.getElementById('grid_out_miss').value;
	if(f_date ==''){
		alert("Please select First Date...");
		return false;
	}
	// alert(f_date);
	$('#list1').jqGrid('GridUnload');


	url =  hostname + "grid_con/grid_all_search_out_miss/"+dept+"/"+section+"/"+line+"/"+designation+"/"+sex+"/"+status+"/"+start+"/"+position+"/"+out_miss+"/"+f_date;
	main_grid(url)
}

function daily_costing_report(){
var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit.");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	// return;
   if (sql =='') {
		alert('Please select employee Id');
      return false;
	}
		//

		document.getElementById('loaader').style.display = 'flex';
	//url =  hostname+"grid_con/grid_daily_costing_report/"+firstdate+"/"+unit_id;

	//daily_costing_rpt = window.open(url,'daily_costing_rpt',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	//daily_costing_rpt.moveTo(0,0);
	var queryString="firstdate="+firstdate+"&unit_id="+unit_id+"&spl="+sql;
   url =  hostname+"grid_con/grid_daily_costing_report/";
   //
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//
			daily_costing_rpt = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_costing_rpt.document.write(resp);
			//daily_costing_rpt.stop();
		}
	}
}

function grid_leave_application_form()
{
	var ajaxRequest = new XMLHttpRequest();
	var firstdate = document.getElementById('start_leave_date').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('end_leave_date').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}
	// var leave_type = document.getElementById('leave_type').value;
	var leave_type = document.getElementById('leave_type').value;
	if(leave_type =='Select')
	{
		alert("Please select Leave Type.");
		return false;
	}

	var emp_id = document.getElementById('empid_leave').value;
	if(emp_id =='')
	{
		alert("Please Enter Empid.");
		return false;
	}




   var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&emp_id="+emp_id;
   url =  hostname+"grid_con/grid_leave_application_form/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			leave_application_form = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			leave_application_form.document.write(resp);
		}
	}
}

///////////////////////////////////////////////////////////
function grid_daily_absent_report()
{
var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_absent_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_absent_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_absent_report.document.write(resp);
			//daily_absent_report.stop();
		}
	}
}
function grid_daily_leave_report()
{
var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	// hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length :   hostname.indexOf("index.php"));
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			//daily_present_report.stop();
		}
	}
}
function grid_daily_late_report()
{
var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	//
	//
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_late_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			//daily_present_report.stop();
		}
	}
}
function grid_daily_out_punch_miss_report()
{
var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_out_punch_miss_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			//daily_present_report.stop();
		}
	}
}
function grid_daily_out_in_report()
{
var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql;
   url =  hostname+"grid_con/grid_daily_out_in_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			//daily_present_report.stop();
		}
	}
}
function grid_daily_actual_out_in_report()
{
var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit!");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	document.getElementById('loaader').style.display = 'flex';
// hostname = window .lo cat ion .h re f;
	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_actual_out_in_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			actual_out_in_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			actual_out_in_report.document.write(resp);
			//actual_out_in_report.stop();
		}
	}
}
function grid_daily_holiday_weekend_present_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
 var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//

	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_holiday_weekend_present_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_holiday_weekend_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_holiday_weekend_present_report.document.write(resp);
			//daily_holiday_weekend_present_report.stop();
		}
	}
}

function grid_daily_move_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
		}catch (e){
		   // Internet Explorer Browsers
		   try{
		      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		   } catch (e) {
		      try{
		         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		      }catch (e){
		         // Something went wrong
		        alert("Your browser broke!");
		        return false;
		     }
		}
	}
		var firstdate = document.getElementById('firstdate').value;
		if(firstdate =='')
		{
			alert("Please select First date");
			return false;
		}

		var unit_id = document.getElementById('unit_id').value;
		if(unit_id =='Select')
		{
			alert("Please select Unit!");
			return false;
		}

		var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

		//

		var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
	   url =  hostname+"grid_con/grid_daily_move_report/";

	   ajaxRequest.open("POST", url, true);
	   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	    ajaxRequest.send(queryString);
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				var resp = ajaxRequest.responseText;

				daily_move_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
				daily_move_report.document.write(resp);
				//daily_move_report.stop();
			}
		}
}

function grid_daily_punch_report()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var f_time = document.getElementById('f_time').value;
	if(f_time =='')
	{
		alert("Please select First time");
		return false;
	}

	var s_time = document.getElementById('s_time').value;
	if(s_time =='')
	{
		alert("Please select Second time");
		return false;
	}

	var grid_unit = document.getElementById('unit_id').value;
	if(grid_unit =='Select')
	{
		alert("Please select Unit!");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

//

	var queryString="firstdate="+firstdate+"&f_time="+f_time+"&s_time="+s_time+"&spl="+sql+"&grid_unit="+grid_unit;
   url =  hostname+"grid_con/grid_daily_punch_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_out_punch = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_out_punch.document.write(resp);
			//daily_out_punch.stop();
		}
	}
}



function grid_continuous_report_limit(limit)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}


		var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var status = "A";
	var limit = limit;

	document.getElementById('loaader').style.display = 'flex';

	//
	//
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id+"&limit="+limit;
    url =  hostname+"grid_con/grid_continuous_report_limit/";

    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_absent_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_absent_report.document.write(resp);
			//continuous_absent_report.stop();
		}
	}
}

function grid_continuous_leave_report_old()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var status = "L";

	//
	//
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_continuous_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_leave_report_old = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_leave_report_old.document.write(resp);
			//continuous_leave_report_old.stop();
		}
	}

}

function grid_continuous_line_report(type)
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
		document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id+"&type="+type;


    url =  hostname+"grid_con/continuous_line_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function () {
			document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_incre_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_incre_report.document.write(resp);
			//continuous_incre_report.stop();
		}
	}

}

function grid_continuous_increment_promotion_proposal()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
    try{
    // Opera 8.0+, Firefox, Safari
    ajaxRequest = new XMLHttpRequest();
 	}catch (e){
    // Internet Explorer Browsers
    try{
    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
    }catch (e) {
    try{
    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }catch (e){
    // Something went wrong
    alert("Your browser broke!");
    return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;


    url =  hostname+"grid_con/continuous_increment_promotion_proposal/";

   	ajaxRequest.open("POST", url, true);
   	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			continuous_increment_promotion_proposal = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			continuous_increment_promotion_proposal.document.write(resp);
			//continuous_increment_promotion_proposal.stop();
		}
	}
}
function grid_app_letter(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
		}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
    var sql = get_checked_value(checkboxes);
    // if (sql =='') {
	// alert('Please select employee Id');
    //   return false;
    // }
	//
	//
	var queryString="emp_ids="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_app_letter/";
	//
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				var resp = ajaxRequest.responseText;
				//
				app_letter = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
				app_letter.document.write(resp);
				//app_letter.stop();
			}
	}

}

function grid_ctpat()
{
	//alert();
	var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	/*
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}*/
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}




	var queryString="spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_ctpat/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			job_letter = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			job_letter.document.write(resp);
			//job_letter.stop();
		}
	}

}




function grid_pay_slip_non_compliance()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var year_month = report_year_sal+"-"+report_month_sal+"-"+"01";

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}


	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}



	//url =  hostname + "salary_report_con/grid_pay_slip"+"/"+year_month+"/"+sql+"/"+unit_id;

	//pay_slip = window.open(url,'pay_slip',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	//pay_slip.moveTo(0,0);
	var queryString="year_month="+year_month+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"salary_report_con/grid_pay_slip_non_compliance/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			pay_slip = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			pay_slip.document.write(resp);
			//pay_slip.stop();
		}
	}

}


function grid_pay_slip_com()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var year_month = report_year_sal+"-"+report_month_sal+"-"+"01";

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}


	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}



	//url =  hostname + "salary_report_con/grid_pay_slip"+"/"+year_month+"/"+sql+"/"+unit_id;

	//pay_slip = window.open(url,'pay_slip',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	//pay_slip.moveTo(0,0);
	var queryString="year_month="+year_month+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"salary_report_con/grid_pay_slip_com/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			pay_slip = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			pay_slip.document.write(resp);
			//pay_slip.stop();
		}
	}
}

function grid_pay_slip_com_non_com_mix()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var year_month = report_year_sal+"-"+report_month_sal+"-"+"01";

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}


	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}



	//url =  hostname + "salary_report_con/grid_pay_slip"+"/"+year_month+"/"+sql+"/"+unit_id;

	//pay_slip = window.open(url,'pay_slip',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	//pay_slip.moveTo(0,0);
	var queryString="year_month="+year_month+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"salary_report_con/grid_pay_slip_com_non_com_mix/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			pay_slip = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			pay_slip.document.write(resp);
			//pay_slip.stop();
		}
	}

}

function grid_provident_fund()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

var year_month = report_year_sal+"-"+report_month_sal+"-"+"01";

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}



	url =  hostname + "salary_report_con/grid_provident_fund"+"/"+year_month+"/"+sql;

	provident_fund = window.open(url,'provident_fund',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	provident_fund.moveTo(0,0);
}


function grid_prom_report()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	var seconddate = document.getElementById('seconddate').value;
	   if(firstdate =='')
	   {
		   alert("Please select First date");
		   return false;
	   }
	   if(seconddate =='')
	   {
		   alert("Please select Second date");
		   return false;
	   }
	   var unit_id = document.getElementById('unit_id').value;
	   if(unit_id =='Select')
	   {
		   alert("Please select Category options");
		   return false;
	   }


	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	   var queryString="firstdate="+firstdate+"&spl="+sql;
	//
	//
	   url =  hostname+"grid_con/prom_report/";

		  ajaxRequest.open("POST", url, true);
		  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
		  ajaxRequest.send(queryString);
	   ajaxRequest.onreadystatechange = function(){
		   if(ajaxRequest.readyState == 4){
			   var resp = ajaxRequest.responseText;

			   continuous_increment_promotion_proposal = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			   continuous_increment_promotion_proposal.document.write(resp);
			   //continuous_increment_promotion_proposal.stop();
		   }
	   }
}

function grid_pension_report()

{

 var ajaxRequest;

 try{

   ajaxRequest = new XMLHttpRequest();

 }catch (e){

   try{

      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");

   }catch (e) {

      try{

         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");

      }catch (e){


         alert("Your browser broke!");

         return false;

      }

   }

 }

	var firstdate = document.getElementById('firstdate').value;

	if(firstdate =='')

	{
		alert("Please select First date");

		return false;
	}


	var seconddate = document.getElementById('seconddate').value;

	if(seconddate =='')

	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;

	if(unit_id =='Select')

	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;

	if(status != 4)

	{
		alert("Please select category status to Resign");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql;
   url =  hostname+"grid_con/grid_pension_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			//daily_present_report.stop();
		}
	}

}


function grid_id_card_english()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

//
//
	url =  hostname + "grid_con/grid_id_card_english/"+sql+"/"+unit_id;

	id_card_english = window.open(url,'id_card_english',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	id_card_english.moveTo(0,0);
}

function grid_auto_notify_FW(){

	var ajaxRequest = new XMLHttpRequest();

	//alert('how');exit;
	var firstdate = document.getElementById('date').value;
	var grid_emp_id = document.getElementById('grid_emp_id').value;

	var queryString="grid_emp_id="+grid_emp_id+"&firstdate="+firstdate;
	//alert(queryString);exit;
   url =  hostname+"grid_con/grid_auto_notify_FW/";
   //alert(url);exit;

   ajaxRequest.open("POST", url, true);
   //exit;
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			// alert('hey');exit;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
		}
	}
}

function grid_auto_notify_SW(){

	var ajaxRequest = new XMLHttpRequest();

	//alert('how');exit;
	var firstdate = document.getElementById('date').value;
	var grid_emp_id = document.getElementById('grid_emp_id_2').value;

	var queryString="grid_emp_id="+grid_emp_id+"&firstdate="+firstdate;
	//alert(queryString);exit;
   url =  hostname+"grid_con/grid_auto_notify_SW/";
   //alert(url);exit;

   ajaxRequest.open("POST", url, true);
   //exit;
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//alert(resp);exit;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
		}
	}
}

function grid_auto_notify_TW(){

	var ajaxRequest = new XMLHttpRequest();

	//alert('how');exit;
	var firstdate = document.getElementById('date').value;
	var grid_emp_id = document.getElementById('grid_emp_id_3').value;

	var queryString="grid_emp_id="+grid_emp_id+"&firstdate="+firstdate;
	//alert(queryString);exit;
   url =  hostname+"grid_con/grid_auto_notify_TW/";
   //alert(url);exit;

   ajaxRequest.open("POST", url, true);
   //exit;
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//alert(resp);exit;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
		}
	}
}

function grid_auto_notify_LW()
{

	var ajaxRequest = new XMLHttpRequest();

	//alert('how');exit;
	var firstdate = document.getElementById('date').value;
	var grid_emp_id = document.getElementById('grid_emp_id_4').value;

	var queryString="grid_emp_id="+grid_emp_id+"&firstdate="+firstdate;
	//alert(queryString);exit;
   url =  hostname+"grid_con/grid_auto_notify_LW/";
   //alert(url);exit;

   ajaxRequest.open("POST", url, true);
   //exit;
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//alert(resp);exit;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
		}
	}
}

function grid_pf_statement()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var year  = document.getElementById('report_year_sal').value;
	var month = document.getElementById('salary_month').value;

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}



	url =  hostname + "grid_con/grid_pf_statement/"+year+"/"+month+"/"+sql;

	pf_statement = window.open(url,'pf_statement',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	pf_statement.moveTo(0,0);
}

function grid_extra_ot_mix()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_extra_ot_mix/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			extra_ot = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			extra_ot.document.write(resp);
			//extra_ot.stop();
		}
	}
}




function manual_attendance_entry(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate ==''){
		alert("Please select Second date");
		return false;
	}
	/*alert(firstdate+seconddate);
	return false;*/

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var m_s_time = document.getElementById('m_s_time').value;
	if(m_s_time ==''){
		alert("Please Enter 1st Time");
		return false;
	}
	/*var m_e_time = document.getElementById('m_e_time').value;
	if(m_e_time ==''){
		alert("Please Enter 2nd Time");
		return false;
	}*/

	var okyes;
	okyes=confirm('Are you sure you want to insert attendance?');
	if(okyes==false) return false;



	url =  hostname + "entry_system_con/manual_attendance_entry/";
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&m_s_time="+m_s_time+"&spl="+sql;

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			alert(resp);
		}
	}
}



function manual_entry_Delete()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var okyes;
 okyes=confirm('Are you sure you want to delete?');
if(okyes==false) return false;



	url =  hostname + "entry_system_con/manual_entry_Delete/";
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql;
    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
		var resp = ajaxRequest.responseText;
		alert(resp);
	}
}
}
function manual_attendance_sheet()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var manual_emp_id = document.getElementById('manual_emp_id').value;
	if(manual_emp_id =='')
	{
		alert("Please Enter Emp. ID");
		return false;
	}


	url =  hostname + "entry_system_con/manual_attendance_sheet/"+firstdate+"/"+seconddate+"/"+manual_emp_id;
	attn_sheet = window.open(url,'attn_sheet',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	attn_sheet.moveTo(0,0);
}
function manual_eot_modification()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var manual_eot_emp_id = document.getElementById('manual_eot_emp_id').value;
	if(manual_eot_emp_id =='')
	{
		alert("Please Enter Emp. ID");
		return false;
	}



	url =  hostname + "entry_system_con/manual_eot_modification/"+firstdate+"/"+seconddate+"/"+manual_eot_emp_id;

	eot_modification = window.open(url,'eot_modification',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	eot_modification.moveTo(0,0);
}
function manual_ot_eot_modification_for_multiple_employee()
{
   var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var manual_eot_hour = document.getElementById('manual_eot_hour_for_multiple_employee').value;
	if(manual_eot_hour =='')
	{
		alert("Please Enter EOT Hour!");
		return false;
	}

	if(manual_eot_hour =='0')
	{
		alert("O Is Not Allow For EOT Hour!");
		return false;
	}

	var grid_unit = document.getElementById('unit_id').value;
	if(grid_unit =='Select')
	{
		alert("Please select Unit!");
		return false;
	}


	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var okyes;
 	okyes=confirm('Are you sure ?');
	if(okyes==false) return false;



	url =  hostname + "entry_system_con/manual_ot_eot_modification_for_multiple/";


	var queryString="firstdate="+firstdate+"&spl="+sql+"&manual_eot_hour="+manual_eot_hour;

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
		var resp = ajaxRequest.responseText;
		alert(resp);
	}
}
}
function save_work_off(){
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
		ajaxRequest = new XMLHttpRequest();
	}catch (e){
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return false;
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select Category options");
		return false;
	}

	var chek = document.getElementById('chek');
	if(chek.checked==true){
		var F_rpl_val = 1;
	}else{
		var F_rpl_val = 0;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var okyes;
	okyes=confirm('Are you sure you want to insert weekend?');
	if(okyes==false) return false;



	url =  hostname + "entry_system_con/save_work_off/";

	var queryString="firstdate="+firstdate+"&spl="+sql+"&F_rpl_val="+F_rpl_val+"&unit_id="+unit_id;

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			alert(resp);
		}
	}
}

function delete_work_off()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var okyes;
 okyes=confirm('Are you sure you want to Delete weekend?');
if(okyes==false) return false;

//
//
	url =  hostname + "entry_system_con/delete_work_off/";

	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
		var resp = ajaxRequest.responseText;
		alert(resp);
	}
}
}
function save_holiday()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var chek = document.getElementById('h_chek');
	if(chek.checked==true){
		var h_rpl_val = 1;
	}else{
		var h_rpl_val = 0;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var holiday_description = document.getElementById('holiday_description').value;
	if(holiday_description =='')
	{
		alert("Please insert holiday description");
		return false;
	}

	var okyes;
 okyes=confirm('Are you sure you want to insert holiday?');
if(okyes==false) return false;



	url =  hostname + "entry_system_con/save_holiday/";

	/*extra_ot = window.open(url,'extra_ot',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	extra_ot.moveTo(0,0);*/

	var queryString="firstdate="+firstdate+"&holiday_description="+holiday_description+"&spl="+sql+"&h_rpl_val="+h_rpl_val+"&unit_id="+unit_id;;

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
		var resp = ajaxRequest.responseText;
		alert(resp);
	}
}
}
function delete_holiday()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var okyes;
 okyes=confirm('Are you sure you want to Delete holiday?');
if(okyes==false) return false;



	url =  hostname + "entry_system_con/delete_holiday/";

	/*extra_ot = window.open(url,'extra_ot',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	extra_ot.moveTo(0,0);*/

	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;;

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
		var resp = ajaxRequest.responseText;
		alert(resp);
	}
}
}

function save_date(){

	var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;

	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}


	var okyes;
	okyes=confirm('Are you sure you want to insert Date?');
	if(okyes==false) return false;




	var queryString="firstdate="+firstdate;
	// alert(firstdate);
	url = hostname + "entry_system_con/save_date/";

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			alert(resp);
			if(resp=='Date Updated Successfully'){
				//alert('Yes I am here');
				location.reload();
				var empid_leave = document.getElementById('firstdate').value='';
			}else{
				location.reload();
				var empid_leave = document.getElementById('firstdate').value='';
			}
		}
	}
}

function delete_shift_log_info(){

	var ajaxRequest = new XMLHttpRequest();

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var firstdate = document.getElementById('firstdate').value;

	if(firstdate ==''){
		alert("Please select First date");
		return false;
	}


	var okyes;
	okyes=confirm('Are you sure you want to Delete Date?');
	if(okyes==false) return false;




	var queryString="firstdate="+firstdate+"&spl="+sql;
	// alert(firstdate);
	url = hostname + "entry_system_con/delete_shift_log_info/";

    ajaxRequest.open("POST", url, true);
 	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			alert(resp);
			/*if(resp=='Data Delete Successfully'){
				alert('Data Delete Successfully');
			}else{
				alert('Have No Data In This Date');
			}*/
		}
	}
}


function grid_monthly_salary_sheet(){
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var grid_section = document.getElementById('grid_section').value;
	if(grid_section =='Select')
	{
		alert("Please select Section options");
		return false;
	}
	var status = document.getElementById('status').value;
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"salary_report_con/grid_monthly_salary_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			sal_sheet = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet.document.write(resp);
			//sal_sheet.stop();
		}
	}

}
function grid_actual_monthly_salary_sheet(){
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}
    // var custom_salarydate = document.getElementById('salarydate').value;

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month year");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var salary_draw = document.getElementById('grid_w_type').value;
	var grid_section = document.getElementById('grid_section').value;
	if(salary_draw == 2){
		var grid_section = document.getElementById('grid_section').value;
	}else{
		var grid_section = document.getElementById('grid_section').value;
		if(grid_section =='Select')
		{
			alert("Please select Section options");
			return false;
		}
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var sal_year_month = report_month_sal+"-"+"01";
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&spl="+sql+"&unit_id="+unit_id+"&salary_draw="+salary_draw+"&custom_salarydate="+custom_salarydate;
   url =  hostname+"salary_report_con/grid_actual_monthly_salary_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
			//sal_sheet_actual.stop();
		}
	}

}

function grid_actual_monthly_salary_sheet_not_sec()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	   // Opera 8.0+, Firefox, Safari
	   ajaxRequest = new XMLHttpRequest();
	}catch (e){
	   // Internet Explorer Browsers
	   try{
	      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	   }catch (e) {
	      try{
	         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	      }catch (e){
	         // Something went wrong
	         alert("Your browser broke!");
	         return false;
	      }
	   }
	}
    var custom_salarydate = document.getElementById('salarydate').value;

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var salary_draw = document.getElementById('grid_w_type').value;
	var grid_section = document.getElementById('grid_section').value;

	/*if(salary_draw == 2){
		var grid_section = document.getElementById('grid_section').value;
	}else{
		var grid_section = document.getElementById('grid_section').value;
		if(grid_section =='Select')
		{
			alert("Please select Section options");
			return false;
		}
	}*/

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&spl="+sql+"&unit_id="+unit_id+"&salary_draw="+salary_draw+"&custom_salarydate="+custom_salarydate;
   url =  hostname+"salary_report_con/grid_actual_monthly_salary_sheet_not_sec/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
			//sal_sheet_actual.stop();
		}
	}

}




function grid_mix_salary_sheet()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
    var custom_salarydate = document.getElementById('salarydate').value;

	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var grid_section = document.getElementById('grid_section').value;
	if(grid_section =='Select')
	{
		alert("Please select Section options");
		return false;
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&spl="+sql+"&unit_id="+unit_id+"&custom_salarydate="+custom_salarydate;
   url =  hostname+"salary_report_con/grid_mix_salary_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			sal_sheet_actual = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			sal_sheet_actual.document.write(resp);
			//sal_sheet_actual.stop();
		}
	}

}

function grid_monthly_allowance_with_eot()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";

	//
	//
	url =  hostname + "salary_report_con/grid_monthly_allowance_with_eot/"+sal_year_month+"/"+status+"/"+sql;

	monthly_allowance_with_eot = window.open(url,'monthly_allowance_with_eot',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	monthly_allowance_with_eot.moveTo(0,0);
}
function grid_festival_bonus()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select Secondary Month");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
    var sal_year_month = report_month_sal+"-"+"01";
	document.getElementById('loader').style.display = 'block';

	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&spl="+sql;
   	url =  hostname+"salary_report_con/grid_festival_bonus/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			festival_bonus = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=1600');
			festival_bonus.document.write(resp);
			festival_bonus.stop();
		}
	}
}

function grid_advance_salary_sheet(){
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	// var grid_section = document.getElementById('grid_section').value;
	// if(grid_section =='Select')
	// {
	// 	alert("Please select Section.");
	// 	return false;
	// }


	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
var sal_year_month = report_month_sal+"-"+"01";
	/*


	url =  hostname + "salary_report_con/grid_advance_salary_sheet/"+sal_year_month+"/"+status+"/"+sql;

	advance_salary_sheet = window.open(url,'advance_salary_sheet',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	advance_salary_sheet.moveTo(0,0); */



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&spl="+sql;
   url =  hostname+"salary_report_con/grid_advance_salary_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			advance_salary_sheet = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			advance_salary_sheet.document.write(resp);
			//advance_salary_sheet.stop();
		}
	}

}



function salary_summary_test(){

	var ajaxRequest = new XMLHttpRequest();
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var status = document.getElementById('status').value;
	//var stop_salary = document.getElementById('grid_stop_salary').value;
	var stop_salary = 1;

	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&stop_salary="+stop_salary;
   url =  hostname+"salary_report_con/salary_summary_test/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			summary_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			summary_report.document.write(resp);
		}
	}

}

function salary_summary_compliance(){

	var ajaxRequest = new XMLHttpRequest();
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var status = document.getElementById('status').value;
	//var stop_salary = document.getElementById('grid_stop_salary').value;
	var stop_salary = 1;

	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&stop_salary="+stop_salary;
   url =  hostname+"salary_report_con/salary_summary_compliance/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			summary_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			summary_report.document.write(resp);
		}
	}

}

function first_letter_of_maternity_leave()
{
   var ajaxRequest = new XMLHttpRequest();

   var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}



	url =  hostname + "grid_con/first_letter_of_maternity_leave/"+firstdate+"/"+sql

	incre_prom_report = window.open(url,'incre_prom_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	incre_prom_report.moveTo(0,0);
}

function grid_festival_bonus_summary()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var status = document.getElementById('status').value;

	var sal_year_month = report_month_sal+"-"+"01";
	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id;
    url =  hostname+"salary_report_con/grid_festival_bonus_summary/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			festival_bonus_summary = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			festival_bonus_summary.document.write(resp);
			//festival_bonus_summary.stop();
		}
	}
}
function grid_festival_bonus_summary_sec_wise()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var status = document.getElementById('status').value;

	var sal_year_month = report_month_sal+"-"+"01";



	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id;
   url =  hostname+"salary_report_con/grid_festival_bonus_summary_sec_wise/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			festival_bonus_summary = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			festival_bonus_summary.document.write(resp);
			//festival_bonus_summary.stop();
		}
	}
}

function eot_summary_report_sec()
{
var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	var status = document.getElementById('status').value;
	//alert(status);
	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
	// var stop_salary = document.getElementById('grid_stop_salary').value;


	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id/*+"&stop_salary="+stop_salary*/;
   url =  hostname+"salary_report_con/eot_summary_report_sec/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			eot_summary = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			eot_summary.document.write(resp);
			//eot_summary.stop();
		}
	}
}


function ot_hour_search()
{
	var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var ot_hour = document.getElementById('ot_hour').value;
	if(holiday_description =='')
	{
		alert("Please insert holiday description");
		return false;
	}

	var okyes;
 	 //okyes=confirm('Are you sure you want to insert holiday?');



	var queryString="firstdate="+firstdate+"&ot_hour="+ot_hour+"&spl="+sql;
    url =  hostname + "grid_con/ot_hour_search/";


   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			general_info = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			general_info.document.write(resp);
			//general_info.stop();
		}
   }

}

function grid_service_book(){
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}




	var queryString="spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_service_book/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			service_book = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			service_book.document.write(resp);
			//service_book.stop();
		}
	}
}


function grid_service_book2()
{

	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
/*
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}
*/
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/grid_service_book2/"+sql;

	age_estimation_form = window.open(url,'age_estimation_form',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	age_estimation_form.moveTo(0,0);
}

function grid_service_benifit()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}




	var queryString="spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_service_benifit/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			service_book = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			service_book.document.write(resp);
			//service_book.stop();
		}
	}
}




function grid_current_info()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	/*
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}*/
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	/*


	url =  hostname + "grid_con/grid_general_info/"+sql;

	gen_info = window.open(url,'gen_info',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	gen_info.moveTo(0,0); */



	var queryString="spl="+sql+"&unit_id="+unit_id;

   url =  hostname+"grid_con/grid_current_info/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			general_info = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			general_info.document.write(resp);
			//general_info.stop();
		}
	}
}
function grid_age_estimation()
{

	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/grid_age_estimation/"+sql;

	age_estimation_form = window.open(url,'age_estimation_form',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	age_estimation_form.moveTo(0,0);
}

function bando_certificate_report()
{

    var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	url =  hostname + "grid_con/bando_certificate_report/"+sql;

	certificate_report = window.open(url,'certificate_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	certificate_report.moveTo(0,0);
}

function grid_one_month_settel_paid_report()
{

    var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
// 	hostname = window .location . href;
//
	url =  hostname + "grid_con/one_month_settel_paid_report/"+sql+"/"+firstdate;

	one_month_settel_paid_report = window.open(url,'one_month_settel_paid_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	one_month_settel_paid_report.moveTo(0,0);
}

function grid_drugscreening_report()
{
    var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/grid_drugscreening_report/"+sql;

	drugscreening_report = window.open(url,'drugscreening_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	drugscreening_report.moveTo(0,0);
}

function grid_ackknowledgement_report()
{
    var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/ackknowledgement_report/"+sql;

	ackknowledgement_report = window.open(url,'ackknowledgement_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	ackknowledgement_report.moveTo(0,0);
}

function grid_earnl_payment()
{
    var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
// 	hostname = window .location .href;
//
	url =  hostname + "grid_con/earnl_payment/"+sql;

	earnl_payment = window.open(url,'earnl_payment',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	earnl_payment.moveTo(0,0);
}

function grid_nominee()
{

	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/grid_nominee/"+sql;

	age_estimation_form = window.open(url,'age_estimation_form',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	age_estimation_form.moveTo(0,0);
}
function grid_requitement_form()
{

	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
// 	hostname = window.location.hre f;
//
	url =  hostname + "grid_con/grid_requitement_form/"+sql;

	age_estimation_form = window.open(url,'age_estimation_form',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	age_estimation_form.moveTo(0,0);
}
function grid_verification_report()
{

	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
// 	hostname = window.loc ation.hr e f ;
//
	url =  hostname + "grid_con/grid_verification_report/"+sql;

	age_estimation_form = window.open(url,'age_estimation_form',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	age_estimation_form.moveTo(0,0);
}
function grid_job_description()
{

	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var grid_desig = document.getElementById('grid_desig').value;
	if(grid_desig =='Select')
	{
		alert("Please select Designation options");
		return false;
	}
	//alert(grid_desig);

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/grid_job_description/"+sql;

	age_estimation_form = window.open(url,'age_estimation_form',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	age_estimation_form.moveTo(0,0);
}

////////////////grid_bgm_new_join_report//////////////
function grid_bgm_new_join_report()
{


	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var unit_id = unit_id;
	//var status = document.getElementById('status').value;
	//if(status != 1)
	//{
	//	alert("Please select category status to Regular");
	//	return false;
	//}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&unit_id="+unit_id+"&spl="+sql;
   url =  hostname+"grid_con/grid_bgm_new_join_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			new_join_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			new_join_report.document.write(resp);
			//new_join_report.stop();
		}
	}

}
function grid_bank_note_req(){
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var sal_year_month = report_month_sal+"-"+"01";


	//
	//
	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&spl="+sql;
   url =  hostname+"salary_report_con/grid_bank_note_requisition/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			bank_note_req = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			bank_note_req.document.write(resp);
			//bank_note_req.stop();
		}
	}

}


function grid_resign_report_with_sal()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;
	if(status != 4)
	{
		alert("Please select category status to Resign");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
/*


	url =  hostname + "grid_con/grid_resign_report/"+firstdate+"/"+seconddate+"/"+sql;

	resign_report = window.open(url,'resign_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	resign_report.moveTo(0,0);
*/


	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_resign_report_with_sal/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			resign_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			resign_report.document.write(resp);
			resign_report.stop();
		}
	}

}

function grid_left_report_with_sal()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;
	if(status != 3)
	{
		alert("Please select category status to Left");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
/*


	url =  hostname + "grid_con/grid_resign_report/"+firstdate+"/"+seconddate+"/"+sql;

	resign_report = window.open(url,'resign_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	resign_report.moveTo(0,0);
*/


	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_left_report_with_sal/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			resign_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			resign_report.document.write(resp);
			resign_report.stop();
		}
	}

}

function grid_bgm_resign_report()
{

	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;
	if(status != 4)
	{
		alert("Please select category status to Resign");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
/*


	url =  hostname + "grid_con/grid_resign_report/"+firstdate+"/"+seconddate+"/"+sql;

	resign_report = window.open(url,'resign_report',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	resign_report.moveTo(0,0);
*/


	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_bgm_resign_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			resign_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			resign_report.document.write(resp);
			//resign_report.stop();
		}
	}

}



function grid_bgm_left_report()
{


	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var status = document.getElementById('status').value;

	var status = document.getElementById('status').value;
	if(status != 3)
	{
		alert("Please select category status to Left");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_bgm_left_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			left_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			left_report.document.write(resp);
			//left_report.stop();
		}
	}

}
function grid_bgm_left_resign_report()
{


	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var seconddate = document.getElementById('seconddate').value;
	if(seconddate =='')
	{
		alert("Please select Second date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var status = document.getElementById('status').value;



	var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_bgm_left_resign_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			left_resign_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			left_resign_report.document.write(resp);
			//left_resign_report.stop();
		}
	}

}
function grid_daily_eot()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_eot/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_eot = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_eot.document.write(resp);
			//daily_eot.stop();
		}
	}
}
function grid_daily_ot()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	//
	//
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_ot/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_ot = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_ot.document.write(resp);
			//daily_ot.stop();
		}
	}
}
function grid_daily_night_allowance_report()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	//
	//
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/grid_daily_night_allowance_report/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_night_allowance_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_night_allowance_report.document.write(resp);
			//daily_night_allowance_report.stop();
		}
	}
}
function grid_daily_allowance_bills()
{


	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/grid_daily_allowance_bills/"+firstdate+"/"+sql;

	daily_allowance = window.open(url,'daily_allowance',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	daily_allowance.moveTo(0,0);
}

function grid_daily_weekend_allowance_sheet()
{
	var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&spl="+sql;
   url =  hostname+"grid_con/grid_daily_weekend_allowance_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			monthly_ot_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_ot_register.document.write(resp);
		}
	}
}

function grid_daily_holiday_allowance_sheet()
{
	var ajaxRequest = new XMLHttpRequest();

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	//
	//
	var queryString="firstdate="+firstdate+"&spl="+sql;
   url =  hostname+"grid_con/grid_daily_holiday_allowance_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			monthly_ot_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_ot_register.document.write(resp);
		}
	}
}


function grid_monthly_allowance_register()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month selection");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
//
//
	url =  hostname + "grid_con/grid_monthly_allowance_register/"+firstdate+"/"+sql;

	monthly_allowance = window.open(url,'monthly_allowance',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	monthly_allowance.moveTo(0,0);
}


function grid_monthly_weekend_allowance_sheet()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
	//
	//
	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&spl="+sql;
   url =  hostname+"salary_report_con/grid_monthly_weekend_allowance_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			monthly_weekend_allowance= window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_weekend_allowance.document.write(resp);
			//monthly_weekend_allowance.stop();
		}
	}
}


function grid_monthly_stop_sheet()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Unit");
		return false;
	}

	// var grid_section = document.getElementById('grid_section').value;
	// if(grid_section =='Select')
	// {
	// 	alert("Please select Section options.");
	// 	return false;
	// }

	var status = document.getElementById('status').value;
	// var stop_salary = document.getElementById('grid_stop_salary').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
var sal_year_month = report_month_sal+"-"+"01";

	var queryString="sal_year_month="+sal_year_month+"&status="+status+"&unit_id="+unit_id+"&spl="+sql/*+"&stop_salary="+stop_salary*/;
   url =  hostname+"salary_report_con/grid_monthly_stop_sheet/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			monthly_eot_sheet = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_eot_sheet.document.write(resp);
			//monthly_eot_sheet.stop();
		}
	}
}
function grid_monthly_night_allowance_sheet()
{
	var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var report_month_sal = document.getElementById('salary_month').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return false;
	}

	// var report_year_sal = document.getElementById('report_year_sal').value;
	// if(report_year_sal =='')
	// {
	// 	alert("Please select year");
	// 	return false;
	// }

	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}

	var status = document.getElementById('status').value;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";

//
//
	url =  hostname + "salary_report_con/grid_monthly_night_allowance_sheet/"+sal_year_month+"/"+status+"/"+sql;

	night_allowance_sheet = window.open(url,'holiday_allowance_sheet',"menubar=1,resizable=1,scrollbars=1,width=1600,height=800");
	night_allowance_sheet.moveTo(0,0);
}

function shorts_emp_summery(){
	var ajaxRequest;  // The variable that makes Ajax possible!
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select Category options");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var status = "P";

	var queryString="firstdate="+firstdate+"&status="+status+"&spl="+sql+"&unit_id="+unit_id;
   url =  hostname+"grid_con/shorts_emp_summery/";

   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;

			daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			daily_present_report.document.write(resp);
			//daily_present_report.stop();

		}
	}
}


function main_grid(url)
{
jQuery("#list1").jqGrid({
url: url,
datatype: "json",
//width:'600px',
colModel: [
	{name:'id',index:'id', width:100, label: 'EMP ID', hidden: false},
	{name:'emp_full_name',index:'emp_full_name', width:200, label: 'Full Name'}
	// <!--{name:'emp_dob',index:'emp_dob', width:100, label: 'DOB'}-->

],
  rowNum:20000, rowList:[10,20,30],
 //imgpath: gridimgpath,
 pager: jQuery('#pager1'),
 sortname: 'emp_id',
 viewrecords: true,
 sortorder: "asc",
 multiselect:true
 }).navGrid('#pager1',{ edit:false, add:false, del: false });

}


function grid_service_book_info()
{
	 var ajaxRequest;  // The variable that makes Ajax possible!

 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if(sql =='')
	{
		alert("Please select Employee ID");
		return;
	}
	document.getElementById('loaader').style.display = 'flex';

	var queryString="spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/grid_service_book_info/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if (ajaxRequest.readyState == 4) {
			document.getElementById('loaader').style.display = 'none';
			var resp = ajaxRequest.responseText;
			service_book = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			service_book.document.write(resp);
			service_book.stop();
		}
	}
}




function grid_monthly_night_register(i=null)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month and year selection");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = i;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/grid_monthly_night_register/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			monthly_att_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_att_register.document.write(resp);
			//monthly_att_register.stop();
		}
	}
}
function grid_monthly_ifter_register(i=null)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month and year selection");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = i;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/grid_monthly_ifter_register/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			monthly_att_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_att_register.document.write(resp);
			//monthly_att_register.stop();
		}
	}
}
function grid_monthly_weekend_register(i=null)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month and year selection");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = i;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/grid_monthly_weekend_register/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			monthly_att_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_att_register.document.write(resp);
			//monthly_att_register.stop();
		}
	}
}
function grid_monthly_holiday_register(i=null)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
	}catch (e){
	// Internet Explorer Browsers
	try{
		ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	}catch (e) {
		try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
		}
	}
	}

	var firstdate = document.getElementById('firstdate').value;
	if(firstdate =='')
	{
		alert("Please select First date for month and year selection");
		return false;
	}


	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return false;
	}
	var status = i;

	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}


	document.getElementById('loaader').style.display = 'flex';
	var queryString="firstdate="+firstdate+"&spl="+sql+"&unit_id="+unit_id+"&status="+status;
   	url =  hostname+"grid_con/grid_monthly_holiday_register/";

	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		document.getElementById('loaader').style.display = 'none';
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			monthly_att_register = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			monthly_att_register.document.write(resp);
			//monthly_att_register.stop();
		}
	}
}
