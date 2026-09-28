function earn_leave_process(i) {
	// alert(i); return false;
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
				return false;
			}
		}
	}
	var month_year = document.getElementById('earn_leave_process_month').value;
	if(month_year ==''){
		alert("Please select month year");
		return false;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select Unit.");
		return false;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}
	var okyes;
	okyes=confirm('Are you sure you want to start process?');
	if(okyes==false) return;

	loading_open();
	var queryString='month_year='+month_year+'&unit_id='+unit_id+'&emp_ids='+sql+"&type="+i;
	url = hostname+"earn_leave_con/earn_leave_process/";
    
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);

	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			loading_close();
			var resp = ajaxRequest.responseText;
			alert(resp);
		}
	}
}


function grid_earn_leave_general_info(){
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
	var year = document.getElementById('salary_month').value;
	if(year ==''){
		alert("Please select year");
		return;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return;
	}
	var grid_status = document.getElementById('status').value;
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var queryString="year="+year+"&status="+grid_status+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname + "earn_leave_con/grid_earn_leave_general_info/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function () {
		if (ajaxRequest.readyState == 4) {
			var resp = ajaxRequest.responseText;
			earn_leave_general_info_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			earn_leave_general_info_report.document.write(resp);
		}
	}
}
function grid_earn_leave_payment_buyer(){
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

	var year = document.getElementById('salary_month').value;
	if(year ==''){
		alert("Please select year");
		return;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return;
	}
	var grid_status = document.getElementById('status').value;
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);

	if (sql == '') {
		alert('Please select employee Id');
		return false;
	}

	var queryString="year="+year+"&status="+grid_status+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname + "earn_leave_con/grid_earn_leave_payment_buyer/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			earn_leave_general_info_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			earn_leave_general_info_report.document.write(resp);		
		}
	}
}
function grid_earn_leave_summery(){
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
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var year = document.getElementById('salary_month').value;
	if(year ==''){
		alert("Please select year");
		return;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return;
	}
	var grid_status = document.getElementById('status').value;
	var queryString="year="+year+"&grid_status="+grid_status+"&unit_id="+unit_id;
	url =  hostname+"earn_leave_con/grid_earn_leave_summery/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			earn_leave_summery_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			earn_leave_summery_report.document.write(resp);			
		}
	}
	
}
function grid_earn_leave_payment(){
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
	var report_month_sal = document.getElementById('report_month_sal').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return;
	}
	
	var report_year_sal = document.getElementById('report_year_sal').value;
	if(report_year_sal =='')
	{
		alert("Please select year");
		return;
	}
	
	var unit_id = document.getElementById('grid_start').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return;
	}
	
	var grid_status = document.getElementById('grid_status').value;
	
	$grid  = $("#list1");
	var id_array = $grid.getGridParam('selarrrow');
	var selected_id_list = new Array();
	var spl = (id_array.join('xxx'));
		
	if(spl =='')
	{
		alert("Please select Employee ID");
		return;
	}
	var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
	hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	var queryString="sal_year_month="+sal_year_month+"&grid_status="+grid_status+"&spl="+spl+"&unit_id="+unit_id;
	url =  hostname+"earn_leave_con/grid_earn_leave_payment/";
	 
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			$(".clearfix").dialog("close");		
			earn_leave_payment_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			earn_leave_payment_report.document.write(resp);		
		}
	}
	
}


function earn_leave_pay(){
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
	var year = document.getElementById('earn_leave_pay_year').value;
	if(year ==''){
		alert("Please select year");
		return;
	}
	var pay_date = document.getElementById('pay_date').value;
	if(pay_date ==''){
		alert("Please select pay date");
		return;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if(sql ==''){
		alert("Please select Employee ID");
		return;
	}


	// var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
	var queryString="year="+year+"&pay_date="+pay_date+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/earn_leave_pay/";
	 
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			// $(".clearfix").dialog("close");		
			if(resp != "")
				alert(resp);
			// earn_leave_payment_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			// earn_leave_payment_report.document.write(resp);		
		}
	}
	
}
function earn_leave_list(){
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
	var year = document.getElementById('earn_leave_pay_year').value;
	if(year ==''){
		alert("Please select year");
		return;
	}
	var pay_date = document.getElementById('pay_date').value;
	if(pay_date ==''){
		alert("Please select pay date");
		return;
	}
	var unit_id = document.getElementById('unit_id').value;
	if(unit_id =='Select'){
		alert("Please select unit !");
		return;
	}
	var checkboxes = document.getElementsByName('emp_id[]');
	var sql = get_checked_value(checkboxes);
	if(sql ==''){
		alert("Please select Employee ID");
		return;
	}
	// var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
	var queryString="year="+year+"&pay_date="+pay_date+"&spl="+sql+"&unit_id="+unit_id;
	url =  hostname+"grid_con/earn_leave_list/";
	 
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			// $(".clearfix").dialog("close");		
			// if(resp != "")
				// alert(resp);
			earn_leave_payment_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			earn_leave_payment_report.document.write(resp);		
		}
	}
	
}




function grid_earn_leave_payment_at_atime(){
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
	var report_month_sal = document.getElementById('report_month_sal').value;
	if(report_month_sal =='')
	{
		alert("Please select month");
		return;
	}
	
	var report_year_sal = document.getElementById('report_year_sal').value;
	if(report_year_sal =='')
	{
		alert("Please select year");
		return;
	}
	
	var unit_id = document.getElementById('grid_start').value;
	if(unit_id =='Select')
	{
		alert("Please select unit !");
		return;
	}
	
	var grid_status = document.getElementById('grid_status').value;
	
	$grid  = $("#list1");
	var id_array = $grid.getGridParam('selarrrow');
	var selected_id_list = new Array();
	var spl = (id_array.join('xxx'));
		
	if(spl =='')
	{
		alert("Please select Employee ID");
		return;
	}
var sal_year_month = report_year_sal+"-"+report_month_sal+"-"+"01";
		
hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	var queryString="sal_year_month="+sal_year_month+"&grid_status="+grid_status+"&spl="+spl+"&unit_id="+unit_id;
   url =  hostname+"earn_leave_con/grid_earn_leave_payment_at_atime/";
    
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(queryString);
   ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			$(".clearfix").dialog("close");		
			earn_leave_payment_at_atime = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
			earn_leave_payment_at_atime.document.write(resp);		
		}
	}
}
function all_search(){
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
	
	var year = document.getElementById('report_year_sal').value;
	if(year =='')
	{
		alert("Please select year");
		return;
	}
	
	//alert(year_month);
	var start 		= document.getElementById('grid_start').value;	
	var dept 		= document.getElementById('grid_dept').value;	
	var section 	= document.getElementById('grid_section').value;
	var line 		= document.getElementById('grid_line').value;
	var designation = document.getElementById('grid_desig').value;
	var sex = document.getElementById('grid_sex').value;
	var status = document.getElementById('grid_status').value;
	
	$('#list1').jqGrid('GridUnload');
	
	hostname = window.location.href;
hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	url =  hostname + "earn_leave_con/all_search/"+dept+"/"+section+"/"+line+"/"+designation+"/"+sex+"/"+status+"/"+start;
	//var url = "http://localhost/payroll/grid_con/grid_all_search/"+dept+"/"+section+"/"+line+"/"+designation;
	main_grid(url)
}
function main_grid(url){
	jQuery("#list1").jqGrid({
	url: url,
	datatype: "json",
	//width:'600px',
	colModel: [
		{name:'id',index:'id', width:100, label: 'EMP ID', hidden: false},
		{name:'emp_full_name',index:'emp_full_name', width:200, label: 'Full Name'}
		<!--{name:'emp_dob',index:'emp_dob', width:100, label: 'DOB'} 
		// -->
		
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
function get_all_data(){

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
 var start = document.getElementById('grid_start').value;	
 if(start == "Select" || start == '')
 {
	 alert("Please select ALL");
	 return;
 }

	//alert(year_month);
 	//var queryString="year_month="+year_month;
	var queryString="start="+start;
	hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
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
		
		document.grid.grid_status.options.length=0;
		//document.grid.grid_status.options[0]=new Option("Select","Select", true, false); 
		for (i=0; i<status_id.length; i++){
			document.grid.grid_status.options[i]=new Option(status_name[i],status_id[i], false, false);

		}
		document.grid.grid_status.options[i]=new Option("ALL","ALL", true, true);
		
		
//		var stop_id = ["1","2"];
//		var stop_name = ["Running","Stop"];
//		
//		document.grid.grid_stop_salary.options.length=0;
//		document.grid.grid_stop_salary.options[0]=new Option("Select","Select", true, false); 
//		for (i=0; i<stop_id.length; i++){
//			document.grid.grid_stop_salary.options[i+1]=new Option(stop_name[i],stop_id[i], false, false);
//
//		}
		
		
		
	$('#list1').jqGrid('GridUnload');
	
	hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	url =  hostname + "earn_leave_con/get_all_data/"+start;
	//var url = "http://localhost/payroll/grid_con/grid_get_all_data";
	main_grid(url)
	
	
	}
	}
}