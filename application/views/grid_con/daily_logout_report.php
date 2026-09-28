<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $title; ?></title>
    <style>
        table{
            line-height:20px;
        }
        @media print {
        #btnExport {
				display: none;
			}
        }
    </style>
</head>
    <body id='report-data'>
        <?php // print_r($values); ?>
        <div style=" margin:0 auto;  width:auto;">
        <div id="no_print" style="float:right;"></div>
            <?php
                $data['unit_id'] = $unit_id;
                $this->load->view("head_english",$data);
            ?>
	        <button style='position:absulate;margin-left:50px' id="btnExport">Download as Excel</button>

            <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
                <?php echo $title; ?> Wise Manpower Summary <?php echo $report_date; ?></span>
                <br />
                <br />
                <table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:13px; width:950px;">
                    <tr style="background:#C1E0FF">
                        <th width="30">SL</th>
                        <th width="120"><?php echo $category; ?> Name</th>
                        <th width="50">T.P</th>
                        <th width="50" style="white-space:nowrap">>05 PM</th>
                        <th width="50">05 PM</th>
                        <th width="50">06 PM</th>
                        <th width="50">07 PM</th>
                        <th width="50">08 PM</th>
                        <th width="50">09 PM</th>
                        <th width="50">10 PM</th>
                        <th width="50">11 PM</th>
                        <th width="50">12 PM</th>
                        <th width="50">01 AM</th>
                        <th width="50">02 AM</th>
                        <th width="50">03 AM</th>
                        <th width="50">04 AM</th>
                        <th width="50">05 AM</th>
                        <th width="50">06 AM</th>
                        <th width="80">P.Error</th>
                        <th width="80" style="white-space:nowrap">TTL O.T</th>
                        <th width="80">Remarks</th>
                    </tr>
                    <?php
                        $i=1;
                        $total = 0;
                        $total_error = 0;
                        $total_ot = 0;
                        $total_four_pm=0;
                        $total_five_pm=0;
                        $total_six_pm=0;
                        $total_seven_pm=0;
                        $total_eight_pm=0;
                        $total_nine_pm=0;
                        $total_ten_pm=0;
                        $total_eleven_pm=0;
                        $total_tweelve_pm=0;
                        $total_one_am=0;
                        $total_two_am=0;
                        $total_three_am=0;
                        $total_four_am=0;
                        $total_five_am=0;
                        $total_six_am=0;
                        foreach($values as $row){
                            $total            += $row->all_present;
                            $total_error      += $row->present_error;
                            $total_ot      += $row->total_ot;
                            $total_four_pm    += $row->four_pm;
                            $total_five_pm    += $row->five_pm;
                            $total_six_pm     += $row->six_pm;
                            $total_seven_pm   += $row->seven_pm;
                            $total_eight_pm   += $row->eight_pm;
                            $total_nine_pm    += $row->nine_pm;
                            $total_ten_pm     += $row->ten_pm;
                            $total_eleven_pm += $row->eleven_pm;
                            $total_tweelve_pm += $row->tweelve_pm;
                            $total_one_am     += $row->one_am;
                            $total_two_am     += $row->two_am;
                            $total_three_am   += $row->three_am;
                            $total_four_am    += $row->four_am;
                            $total_five_am    += $row->five_am;
                            $total_six_am    += $row->six_am;
                        ?>
                        <tr>
                            <th width="30"><?php  echo $i++?></th>
                            <th width="120" style="white-space:nowrap"><?php echo $row->line_name_en?></th>
                            <th width="120"><?php echo $row->all_present?></th>
                            <th width="120"><?php echo $row->four_pm?></th>
                            <th width="120"><?php echo $row->five_pm?></th>
                            <th width="120"><?php echo $row->six_pm?></th>
                            <th width="120"><?php echo $row->seven_pm?></th>
                            <th width="120"><?php echo $row->eight_pm?></th>
                            <th width="120"><?php echo $row->nine_pm?></th>
                            <th width="120"><?php echo $row->ten_pm?></th>
                            <th width="120"><?php echo $row->eleven_pm?></th>
                            <th width="120"><?php echo $row->tweelve_pm?></th>
                            <th width="120"><?php echo $row->one_am?></th>
                            <th width="120"><?php echo $row->two_am?></th>
                            <th width="120"><?php echo $row->three_am?></th>
                            <th width="120"><?php echo $row->four_am?></th>
                            <th width="120"><?php echo $row->five_am?></th>
                            <th width="120"><?php echo $row->six_am?></th>
                            <th width="120"><?php echo $row->present_error?></th>
                            <th width="120"><?php echo $row->total_ot?></th>
                            <th width="120"><?php echo ''?></th>
                        </tr>
                    <?php } ?>
                    <tr style="background:#C1E0FF">
                        <th colspan="2"> Total </th>
                        <th><?php echo $total; ?></th>
                        <th><?php echo $total_four_pm;?></th>
                        <th><?php echo $total_five_pm;?></th>
                        <th><?php echo $total_six_pm;?></th>
                        <th><?php echo $total_seven_pm;?></th>
                        <th><?php echo $total_eight_pm;?></th>
                        <th><?php echo $total_nine_pm;?></th>
                        <th><?php echo $total_ten_pm;?></th>
                        <th><?php echo $total_eleven_pm;?></th>
                        <th><?php echo $total_tweelve_pm;?></th>
                        <th><?php echo $total_one_am;?></th>
                        <th><?php echo $total_two_am;?></th>
                        <th><?php echo $total_three_am;?></th>
                        <th><?php echo $total_four_am;?></th>
                        <th><?php echo $total_five_am;?></th>
                        <th><?php echo $total_six_am;?></th>
                        <th><?php echo $total_error;?></th>
                        <th><?php echo $total_ot;?></th>
                        <th></th>
                    </tr>
                </table>
            </div>
        </div>
        <br><br>

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
	<script>
		function convert_excel(type, fn, dl) {
			var elt = document.getElementById('report-data');
			var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
			return dl ?
				XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
				XLSX.writeFile(wb, fn || ('Sales-Report.' + (type || 'xlsx')));
		}
		$("#btnExport").click(function(event) {
		convert_excel('xlsx');
		});
	</script>
    </body>
</html>
<?php exit(); ?>
