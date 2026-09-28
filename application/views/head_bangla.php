
<h3 style="text-align: center;line-height: 1px;font-family:SutonnyMJ"><?php echo $unit_name_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_name_bangla;?></h3>
<h5 style="text-align: center;line-height: 1px;font-family:SutonnyMJ"><?php echo $unit_add_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_add_bangla;?></h5>
