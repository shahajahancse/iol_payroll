Select Year :

	<select id='report_year_sal' name="report_year_sal">
		<?php
			$current_year = date('Y');
			for($i = $current_year-10; $i <= $current_year + 10; $i++)
			{
				if($current_year == $i){
				?>
					<option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
				<?php
				}else{
				?>
					<option value="<?php echo $i;?>" ><?php echo $i;?></option>
				<?php
				}
			}
		?>
	</select>