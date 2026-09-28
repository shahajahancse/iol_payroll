<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
        table{
        border-collapse: collapse;
        }

        table td, th{
            border: 1px solid black;
        }
        table.header-top td, th{
          border: none;
        }
    </style>
</head>
<body>
    <table class="header-top" style="width:600px;margin:0 auto;">
      <tr>
       <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
       <td width="105" style="vertical-align: top;"><img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_information("company_logo"); ?>" />
        </td>
        <td style="font-size:15px;text-align:center">
            <?php $this->load->view("head_english");?>
            <span style="font-size: 24px;font-weight: bold;">Designation Wise All Employee List </span>
        </td>
    </tr>
  </table>
<div align="center" style="width:600px; border-bottom:3px solid #000;margin:20px auto 20px"></div>
<div style="width: 600px;margin:0 auto;">
 <table style="width: 600px;">
 <tr>
     <th>Designation Name</th>
     <th>Total Employee</th>
 </tr>
  <?php 
 
        $count = 112;
        for($i=1; $i <=$count; $i++){
            echo "<tr>";
                echo "<td>";
                $id = $value[$i]['id'];
                $this->db->select('*');
                $this->db->where('desig_id',$id);
                $query = $this->db->get('pr_designation');
                $row = $query->row();
                echo $name = $row->desig_name;
                echo "</td>";
                echo "<td>";
                echo $value[$i]['sum'];
                echo "</td>";
            echo "</tr>";
        }
        

  ?>
  </table>
  </div>
</body>
</html>