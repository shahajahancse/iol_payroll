<div style="font-size:15px; font-weight:bold; line-height: 2px; padding-top: 2px; position:relative; text-align:center; font-family:SolaimanLipi;"><?php 
echo $unit_name_bangla = $this->db->where("unit_id",$unit_id)->get('pr_units')->row()->unit_name_bangla;
//echo $company_name_bangla = $this->common_model->company_information("company_name_bangla"); 
?></div>