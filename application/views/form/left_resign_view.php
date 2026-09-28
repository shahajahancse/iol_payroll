<div class="content">
	<div class="col-md-6 tablebox">
		<div class="row">
			<div class="col-md-6">
				<h4><b>Add Left/Resign</b></h4>
			</div>
		</div><br>
	<form class="form-group" name="left_resign">
		<div class="card">
		<div class="card-body">
			<div class="form-group row">
			<label for="emp_id" class="col-sm-3 col-form-label">Employee ID</label>
			<div class="col-sm-9">
				<input class="form-control" name="emp_id" type="text" id="emp_id" disabled="disabled">
			</div>
			</div>
			<div class="form-group row">
			<label for="effective_date" class="col-sm-3 col-form-label">Effective Date</label>
			<div class="col-sm-9">
				<input class="form-control" type="text" id="effective_date" name="effective_date">
				<script language="JavaScript">
				var o_cal = new tcal({
					'formname': 'left_resign',
					'controlname': 'effective_date'
				});
				o_cal.a_tpl.yearscroll = false;
				o_cal.a_tpl.weekstart = 6;
				</script>
			</div>
			</div>
			<div class="form-group row">
			<label for="left_resign_status" class="col-sm-3 col-form-label">Left / Resign</label>
			<div class="col-sm-9">
				<select class="form-control" name="left_resign_status" id="left_resign_status" width="150px">
				<option value="3">Left</option>
				<option value="4">Resign</option>
				</select>
			</div>
			</div>
			<div class="form-group row">
			<label for="search_empid" class="col-sm-3 col-form-label">Search Employee ID</label>
			<div class="col-sm-9">
				<input class="form-control" style="background-color: yellow;" type="text" size="25px" id="search_empid" name="search_empid">
			</div>
			</div>
			<div class="form-group row">
			<div class="col-sm-9 offset-sm-3">
				<input class="btn btn-danger" type="button" value="Submit" id="left_or_resign" disabled="disabled" class="left_res_button">
				<input class="btn btn-primary" type="button" value="Regular" id="left_resign_to_regular" disabled="disabled" class="left_res_button">
			</div>
			</div>
		</div>
		</div>
	</form>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<fieldset  id="auto_gen1"  style="display:none;background:#F2F2E6; font-size:11px; font-weight:bold; margin-top: 20px;">
		</fieldset>
	</div>
</div>


<script>
$(function() {
	
	$('#search_empid').keydown(function(){
		$(this).autocomplete(
		{
			source: "<?php echo base_url(); ?>left_resign_con/search_empid_for_resign_left",
			minLength: 0,
			autoFocus: false,
			select:function(event,ui){
			var left_resign_emp_id = ui.item.left_resign_emp_id ;
			var search_data = {
			left_resign_search_text: left_resign_emp_id//$("#mslc_search_text").val()
			};
			 $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>left_resign_con/get_left_resign_info",
				data: search_data,
				cache: false,
				success: function(data){
					if(data == "This Employee ID Not Exists!")
					{
						alert(data);
						return false;
					}
					if(data == "Please Log In As a Unit User !")
					{
						alert(data);
						return false;
					}
					if(data == "Please Enter Valid Employee ID !")
					{
						alert(data);
						return false;
					}
					left_res_info = data.split("===");
					document.getElementById('emp_id').value 			= left_res_info[0];
					document.getElementById('effective_date').value 	= left_res_info[1];
					//alert(left_res_info[3]);
					if(left_res_info[3] != "Null")
					{
						$("#left_resign_status option[value='"+left_res_info[2]+"']").remove();
						$("#left_resign_status").append("<option selected='selected' value='"+left_res_info[2]+"'>"+left_res_info[3]+"</option>");
						document.getElementById("left_or_resign").disabled 	= true;
						document.getElementById("left_resign_to_regular").disabled 	= false;
						document.getElementById("left_resign_status").disabled 	= true;
						document.getElementById("effective_date").disabled 	= true;
					}
					else{
						document.getElementById("left_or_resign").disabled 	= false;
						document.getElementById("left_resign_status").disabled 	= false;
						document.getElementById("effective_date").disabled 	= false;
						document.getElementById("left_resign_to_regular").disabled 	= true;
					}
					//alert(left_res_info);
					$('#auto_gen1').load('<?php echo base_url();?>left_resign_con/get_left_resign_employee_basic_info/'+left_res_info[0]);
					$('#auto_gen1').show();
					return false;
				}
				});
			}
		});
	});
	
	$('#left_resign_to_regular').on('click',function(){
   		var left_res_button_value = $(this).val();

   		var button_data = {
   			emp_id	:$("#emp_id").val(),
   			effective_date	:$("#effective_date").val(),
			left_res_button_value: $(this).val(),//$("#mslc_search_text").val()
			left_resign_status: $("#left_resign_status").val()
		};
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>left_resign_con/left_resign_and_regular_action",
			data: button_data,
			cache: false,
			success: function(data){
				alert(data);
				window.location.href = "<?php echo base_url();?>left_resign_con/left_resign_entry";
				return false;
			}
		});
			
	});
	$('#left_or_resign').on('click',function(){
   		var effective_date = $("#effective_date").val();
   		
   		if(effective_date == '')
		{
			alert("Enter Effective Date!");
			return;
		}
   		var button_data = {
   			emp_id	:$("#emp_id").val(),
   			effective_date	:$("#effective_date").val(),
			left_res_button_value: $(this).val(),//$("#mslc_search_text").val()
			left_resign_status: $("#left_resign_status").val()
		};
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>left_resign_con/left_resign_and_regular_action",
			data: button_data,
			cache: false,
			success: function(data){
				alert(data);
				window.location.href = "<?php echo base_url();?>left_resign_con/left_resign_entry";
				return false;
			}
		});
	});
});
</script>