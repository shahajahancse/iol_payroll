function salary_structure_cal(){
   var gsal = parseFloat(document.getElementById('gross_sal').value) || 0;

   if (gsal > 0) { 
      var bsal = Math.round(gsal * 0.60);
      var hrent = Math.round(gsal * 0.20);
      var mallow = Math.round(gsal * 0.10);
      var food = Math.round(gsal * 0.05);
      var trans_allow = Math.round(gsal * 0.05);
      
      // Ensure total equals gross without rounding mismatch
      var sum = bsal + hrent + mallow + food + trans_allow;
      if (sum !== gsal) {
         trans_allow = gsal - (bsal + hrent + mallow + food);
      }

      if (document.getElementById('basic_sal')) document.getElementById('basic_sal').value = bsal;
      if (document.getElementById('house_rent')) document.getElementById('house_rent').value = hrent;
      if (document.getElementById('medical')) document.getElementById('medical').value = mallow;
      if (document.getElementById('food')) document.getElementById('food').value = food;
      if (document.getElementById('trans_allow')) document.getElementById('trans_allow').value = trans_allow;

      if (document.getElementById('com_gross_sal')) document.getElementById('com_gross_sal').value = gsal;
      if (document.getElementById('basic_sall')) document.getElementById('basic_sall').value = bsal;
      if (document.getElementById('house_rentt')) document.getElementById('house_rentt').value = hrent;
      if (document.getElementById('medicall')) document.getElementById('medicall').value = mallow;
      if (document.getElementById('foodd')) document.getElementById('foodd').value = food;
      if (document.getElementById('trans_alloww')) document.getElementById('trans_alloww').value = trans_allow;
   }
}

function salary_structure_cal2(){
   var com_gsal = parseFloat(document.getElementById('com_gross_sal').value) || 0;

   if (com_gsal > 0) { 
      var com_bsal = Math.round(com_gsal * 0.60);
      var com_hrent = Math.round(com_gsal * 0.20);
      var com_mallow = Math.round(com_gsal * 0.10);
      var com_food = Math.round(com_gsal * 0.05);
      var com_trans_allow = Math.round(com_gsal * 0.05);

      var sum = com_bsal + com_hrent + com_mallow + com_food + com_trans_allow;
      if (sum !== com_gsal) {
         com_trans_allow = com_gsal - (com_bsal + com_hrent + com_mallow + com_food);
      }

      if (document.getElementById('gross_sal')) document.getElementById('gross_sal').value = com_gsal;
      if (document.getElementById('basic_sal')) document.getElementById('basic_sal').value = com_bsal;
      if (document.getElementById('house_rent')) document.getElementById('house_rent').value = com_hrent;
      if (document.getElementById('medical')) document.getElementById('medical').value = com_mallow;
      if (document.getElementById('food')) document.getElementById('food').value = com_food;
      if (document.getElementById('trans_allow')) document.getElementById('trans_allow').value = com_trans_allow;

      if (document.getElementById('basic_sall')) document.getElementById('basic_sall').value = com_bsal;
      if (document.getElementById('house_rentt')) document.getElementById('house_rentt').value = com_hrent;
      if (document.getElementById('medicall')) document.getElementById('medicall').value = com_mallow;
      if (document.getElementById('foodd')) document.getElementById('foodd').value = com_food;
      if (document.getElementById('trans_alloww')) document.getElementById('trans_alloww').value = com_trans_allow;
   }
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