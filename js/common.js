function salary_structure_cal(){
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
   var gsal = document.getElementById('gross_sal').value;
   var com_gsal = document.getElementById('com_gross_sal').value;


  




   //==================================BGMEA Salary Rule=================================
   today = new Date().toISOString().slice(0, 10);
   if (today >= '2023-12-01') {
      var mallow = 750;
      var trans_allow = 450;
      var lunch_allow = 1250;
   } else {
      var mallow = 600;
      var trans_allow = 350;
      var lunch_allow = 900;
   }
   document.getElementById('medical').value = mallow;
   document.getElementById('trans_allow').value = trans_allow;
   document.getElementById('food').value = lunch_allow;

   document.getElementById('medicall').value = mallow;
   document.getElementById('trans_alloww').value = trans_allow;
   document.getElementById('foodd').value = lunch_allow;


   if (gsal) { 
      var bsal = Math.round((gsal - (mallow + trans_allow + lunch_allow)) / 1.5);
      document.getElementById('basic_sal').value = bsal;
      var hrent = Math.round(gsal - (mallow + trans_allow + lunch_allow + bsal));
      document.getElementById('house_rent').value = hrent;
   }
   if(com_gsal) { 
      var com_bsal = Math.round((com_gsal - (mallow + trans_allow + lunch_allow)) / 1.5);
      document.getElementById('basic_sall').value = com_bsal;
      var com_hrent = Math.round(com_gsal - (mallow + trans_allow + lunch_allow + com_bsal));
      document.getElementById('house_rentt').value = com_hrent;
   }
   $('#com_gross_sal').val($('#gross_sal').val())
   $('#basic_sall').val($('#basic_sal').val())
   $('#house_rentt').val($('#house_rent').val())
   //==================================LOCAL Salary Rule==================================
}
function salary_structure_cal2(){

   //var gsal = document.getElementById('gross_sal').value;
   var com_gsal = document.getElementById('com_gross_sal').value;
   //==================================BGMEA Salary Rule=================================
   today = new Date().toISOString().slice(0, 10);
   if (today >= '2023-12-01') {
      var mallow = 750;
      var trans_allow = 450;
      var lunch_allow = 1250;
   } else {
      var mallow = 600;
      var trans_allow = 350;
      var lunch_allow = 900;
   }
  //  document.getElementById('medical').value = mallow;
  //  document.getElementById('trans_allow').value = trans_allow;
  //  document.getElementById('food').value = lunch_allow;

   document.getElementById('medicall').value = mallow;
   document.getElementById('trans_alloww').value = trans_allow;
   document.getElementById('foodd').value = lunch_allow;


  //  if (gsal) { 
  //     var bsal = Math.round((gsal - (mallow + trans_allow + lunch_allow)) / 1.5);
  //     document.getElementById('basic_sal').value = bsal;
  //     var hrent = Math.round(gsal - (mallow + trans_allow + lunch_allow + bsal));
  //     document.getElementById('house_rent').value = hrent;
  //  }
   if(com_gsal) { 
      var com_bsal = Math.round((com_gsal - (mallow + trans_allow + lunch_allow)) / 1.5);
      document.getElementById('basic_sall').value = com_bsal;
      var com_hrent = Math.round(com_gsal - (mallow + trans_allow + lunch_allow + com_bsal));
      document.getElementById('house_rentt').value = com_hrent;
   }
   //$('#com_gross_sal').val($('#gross_sal').val())
  //  $('#basic_sall').val($('#basic_sal').val())
  //  $('#house_rentt').val($('#house_rent').val())
   //==================================LOCAL Salary Rule==================================
}

function attendance_process(){
   var ajaxRequest = new XMLHttpRequest();
   unit_id = document.getElementById('unit_id').value;
   if(unit_id == '')
   {
     alert('Please select Unit');
     return ;
   }   

   process_date = document.getElementById('process_date').value;
   if(process_date == '')
   {
     alert('Please select process date');
     return ;
   }

   var checkboxes = document.getElementsByName('emp_id[]');
   var sql = get_checked_value(checkboxes);
   if(sql =='')
   {
     alert('Please select employee Id');
     return ;
   }

   var okyes;
   okyes=confirm('Are you sure you want to start process?');
   if(okyes==false) return;

   loading_open();
   var data = "process_date="+process_date+"&unit_id="+unit_id+'&sql='+sql;
   
   // console.log(data); return;
   url = hostname + "attn_process_con/attendance_process";
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(data);

   ajaxRequest.onreadystatechange = function(){
     if(ajaxRequest.readyState == 4){
       // console.log(ajaxRequest);
       var resp = ajaxRequest.responseText;
       loading_close();
       alert(resp);
     }
   }
}
function attendance_process2(){
   var ajaxRequest = new XMLHttpRequest();
   unit_id = document.getElementById('unit_id').value;
   if(unit_id == '')
   {
     alert('Please select Unit');
     return ;
   }   

   process_date1 = document.getElementById('process_date1').value;
   if(process_date1 == '')
   {
     alert('Please select from date');
     return ;
   }
   process_date2 = document.getElementById('process_date2').value;
   if(process_date2 == '')
   {
     alert('Please select to date');
     return ;
   }

   var checkboxes = document.getElementsByName('emp_id[]');
   var sql = get_checked_value(checkboxes);
   if(sql =='')
   {
     alert('Please select employee Id');
     return ;
   }

   var okyes;
   okyes=confirm('Are you sure you want to start process?');
   if(okyes==false) return;

   loading_open();
   var data = "process_date1="+process_date1+"&process_date2="+process_date2+"&unit_id="+unit_id+'&sql='+sql;
   
   // console.log(data); return;
   url = hostname + "attn_process_con/attendance_process2";
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(data);

   ajaxRequest.onreadystatechange = function(){
     if(ajaxRequest.readyState == 4){
       // console.log(ajaxRequest);
       var resp = ajaxRequest.responseText;
       loading_close();
       alert(resp);
     }
   }
}

// get check box select value
function get_checked_value(checkboxes) {
   var vals = "";
   for (var i=0, n=checkboxes.length;i<n;i++) 
   {
       if (checkboxes[i].checked) 
       {
           vals += ","+checkboxes[i].value;
       }
   }
   if (vals) vals = vals.substring(1);
   return vals;
}

function loading_open() {
    $('#loader').css('display', 'block');
}

function loading_close() {
    $('#loader').css('display', 'none');
}


// salary process
function salary_process(){
   var ajaxRequest = new XMLHttpRequest();
   unit_id = document.getElementById('unit_id').value;
   if(unit_id == '')
   {
     alert('Please select Unit');
     return ;
   }   

   process_month = document.getElementById('process_month').value;
   if(process_month == '')
   {
     alert('Please select process date');
     return ;
   }

   var checkboxes = document.getElementsByName('emp_id[]');
   var sql = get_checked_value(checkboxes);
   if(sql =='')
   {
     alert('Please select employee Id');
     return ;
   }

   var okyes;
   okyes=confirm('Are you sure you want to start process?');
   if(okyes==false) return;

   loading_open();
   var data = "process_month="+process_month+"&unit_id="+unit_id+'&sql='+sql;
   
   // console.log(data); return;
   url = hostname + "salary_process_con/salary_process";
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(data);

   ajaxRequest.onreadystatechange = function(){
     if(ajaxRequest.readyState == 4){
       // console.log(ajaxRequest);
       var resp = ajaxRequest.responseText;
       loading_close();
       alert(resp);
     }
   }
}

// salary process block
function salary_process_block(){
   var ajaxRequest = new XMLHttpRequest();
   unit_id = document.getElementById('unit_id').value;
   if(unit_id == '')
   {
     alert('Please select Unit');
     return ;
   }   

   salary_month = document.getElementById('process_month').value;
   if(salary_month == '')
   {
     alert('Please select salary month');
     return ;
   }

   var okyes;
   okyes=confirm('Are you sure you want to block this month?');
   if(okyes==false) return;

   loading_open();
   var data = "salary_month="+salary_month+"&unit_id="+unit_id;
   
   // console.log(data); return;
   url = hostname + "salary_process_con/salary_process_block";
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(data);

   ajaxRequest.onreadystatechange = function(){
     if(ajaxRequest.readyState == 4){
       // console.log(ajaxRequest);
       var resp = ajaxRequest.responseText;
       loading_close();
       alert(resp);
     }
   }
}

// salary process block delete
function salary_block_delete(){
   var ajaxRequest = new XMLHttpRequest();
   unit_id = document.getElementById('unit_id').value;
   if(unit_id == '')
   {
     alert('Please select Unit');
     return ;
   }   

   salary_month = document.getElementById('process_month').value;
   if(salary_month == '')
   {
     alert('Please select salary month');
     return ;
   }

   var okyes;
   okyes=confirm('Are you sure you want to delete this block?');
   if(okyes==false) return;

   loading_open();
   var data = "salary_month="+salary_month+"&unit_id="+unit_id;
   
   // console.log(data); return;
   url = hostname + "salary_process_con/salary_block_delete";
   ajaxRequest.open("POST", url, true);
   ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(data);

   ajaxRequest.onreadystatechange = function(){
     if(ajaxRequest.readyState == 4){
       // console.log(ajaxRequest);
       var resp = ajaxRequest.responseText;
       loading_close();
       alert(resp);
     }
   }
}