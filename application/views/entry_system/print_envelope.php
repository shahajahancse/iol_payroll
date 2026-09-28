<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Form with Table</title>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    @media print {
        @page {
            size: 926px 416px;
        }
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
        justify-content: center;
        align-items: center;
        height: 80vh;
    }
    .order-box {
        width: 926px;
        height: 416px;
        /* margin: 20px 0px 0px 20px; */
        /* background-color: #f0f0f0;  */
        /* border: 2px solid #333;     */
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }
    .left-section {
        width: 100%;
        font-size: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .logo {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .logo img {
        width: 60px;
        height: 40px;
        margin-right: 10px;
    }
    .company-details {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .company-address {
        font-size: 16px;
        color: #555;
    }
    .right-section {
        width: 50%;
    }
    .form-table {
        width: 35%;
        border-collapse: collapse;
    }
    .form-table td {
        padding: 2px;
        vertical-align: middle;
    }
</style>
</head>
<body style="font-family: SutonnyMJ">
    <div class="order-box">
        <div class="container">
            <!-- Left Section with Logo and Company Details -->
            <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
            <div class="left-section">
                <div class="logo">
                    <img style="width: 100px; height: 40px;" src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo">
                    <div>
                        <div class="company-details"><?= $com_info->company_name_bangla ?></div>
                        <div class="company-address">
                            <?= $com_info->company_add_bangla ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section with Form using Table -->
            <div class="right-section">
                <table class="form-table">
                    <tr>
                        <td class="form-label">প্রাপক,</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="form-label">নাম</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">পিতার নাম</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">বর্তমান ঠিকানা</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">গ্রাম</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">পোস্ট অফিস</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">থানা</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">জেলা</td>
                        <td class="colon">:</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- <br><br><br> -->
    <!-- <div style="page-break-after: always"></div> -->

    <div class="order-box">
        <div class="container">
            <!-- Left Section with Logo and Company Details -->
            <div class="left-section">
                <div class="logo">
                    <img style="width: 100px; height: 40px;" src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo">
                    <div>
                        <div class="company-details"><?= $com_info->company_name_bangla ?></div>
                        <div class="company-address">
                            <?= $com_info->company_add_bangla ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section with Form using Table -->
            <div class="right-section">
                <table class="form-table">
                    <tr>
                        <td class="form-label">প্রাপক,</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="form-label">নাম</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">পিতার নাম</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">বর্তমান ঠিকানা</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">গ্রাম</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">পোস্ট অফিস</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">থানা</td>
                        <td class="colon">:</td>
                    </tr>
                    <tr>
                        <td class="form-label">জেলা</td>
                        <td class="colon">:</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
