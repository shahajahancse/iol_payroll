// JavaScript Document
function yarn_type_find()
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
	  var style_no =document.getElementById('style_no').value;
	 if(style_no=='Select'){
	 	alert("Please insert Style No");
		return;
	 }
	 
	 var queryString="style_no="+style_no;
	// alert(queryString);
	hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	url = hostname + "product_con/yarn_type/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//empty();
			//alert(resp);
			alldata = resp.split("===");
			//alert(alldata);
			yarn_type_id = alldata[0].split("***");
			//alert(yarn_type_id);
			yarn_type_name = alldata[1].split("***");
			//alert(yarn_type_name);
			
			document.form_yarn_type.yarn_type.options.length=0;
	        document.form_yarn_type.yarn_type.options[0]=new Option("Select","Select", true, false);
			for (i=0; i < yarn_type_id.length; i++){
			document.form_yarn_type.yarn_type.options[i+1]=new Option(yarn_type_name[i],yarn_type_id[i], false, false);
		    }
		}
	}
}


function yarn_type_color()
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
	  var yarn_type =document.getElementById('yarn_type').value;
	 if(yarn_type=='Select'){
	 	alert("Please insert Style No");
		return;
	 }
	 
	 var queryString="yarn_type="+yarn_type;
	hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	url =  hostname + "product_con/yarn_type_color/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString);
		ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//empty();
			alert(resp);
			alldata = resp.split("===");
			//alert(alldata);
			yarn_type_id = alldata[0].split("***");
			//alert(yarn_type_id);
			yarn_type_name = alldata[1].split("***");
			//alert(yarn_type_name);
			
			document.form_yarn_type.yarn_type.options.length=0;
	        document.form_yarn_type.yarn_type.options[0]=new Option("Select","Select", true, false);
			for (i=0; i < yarn_type_id.length; i++){
			document.form_yarn_type.yarn_type.options[i+1]=new Option(yarn_type_name[i],yarn_type_id[i], false, false);
		    }
		}
	}

	
}



function yarn_qty()
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
	  var yarn_color =document.getElementById('yarn_color').value;
	 if(yarn_color=='Select'){
	 	alert("Please insert Style No");
		return;
	 }
	 
	 var queryString="yarn_color="+yarn_color;
	//alert(queryString);


	hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	url =  hostname + "product_con/yarn_color/";
	ajaxRequest.open("POST", url, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString);
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var resp = ajaxRequest.responseText;
			//empty();
			//alert(resp);
			
	    	alldata = resp.split("===");
			order_qty = alldata[0].split("***");
			style_no = alldata[1].split("***");
			document.getElementById('required').value=order_qty ;
			document.getElementById('total_yarn').value=order_qty ;
			document.getElementById('s_no').value=style_no ;
			//document.form_yarn_type.yarn_type.options.length=0;
	      //  document.form_yarn_type.yarn_type.options[0]=new Option("Select","Select", true, false);
			//for (i=0; i < yarn_type_id.length; i++){
			//document.form_yarn_type.yarn_type.options[i+1]=new Option(yarn_type_name[i],yarn_type_id[i], false, false);
		   // }
		}
	}



}

function button_save()
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
	 
	 
	 var s_no 	= document.getElementById('s_no').value;
	 var yarn_color 	= document.getElementById('yarn_color').value;
	 var required 	= document.getElementById('required').value;
	 var total_yarn 	= document.getElementById('total_yarn').value;
	  if(yarn_color=='Select'){
	 	alert("Please insert Style No");
		return;
	 }

	var queryString="s_no="+s_no+"&yarn_color="+yarn_color+"&required="+required+"&total_yarn="+total_yarn;
	//alert(queryString);
	
	hostname = window.location.href;
	hostname = hostname.substring(0, (hostname.indexOf("index.php") == -1) ? hostname.length : hostname.indexOf("index.php"));
	url =  hostname + "product_con/required_winding/";
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

	
 
 
 
 
