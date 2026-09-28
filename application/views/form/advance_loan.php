
<div class="content">

	<div class="tablebox">
        <fieldset style="width:600px; border:1px;">
            <legend><b>Advance Loan</b></legend>
            <form action="<?php echo base_url('entry_system_con/advance_loan_insert')?>"  method="POST">
                <div class="form-group">
                    <label for="emp_id">Enter employee ID</label>
                    <input class="form-control" type="text" name="emp_id" id="emp_id" />
                </div>
                <div class="form-group">
                    <label for="loan_amt">Enter loan amount</label>
                    <input class="form-control" type="text" name="loan_amt" id="loan_amt" />
                </div>
                <div class="form-group">
                    <label for="pay_amt">Enter payment/month</label>
                    <input class="form-control" type="text" name="pay_amt" id="pay_amt" />
                </div>
                <div class="form-group">
                    <label for="loan_date">Select Loan Date</label>
                    <div class="input-group">
                        <input style="width: 90%" class="form-control" type="text" name="loan_date" id="loan_date" size="16">
                        <span class="input-group-addon">
                            <script language="JavaScript">
                                // Calendar initialization code here
                            </script>
                        </span>
                    </div>
                </div>
                <button class="btn btn-success" type="submit" name="btn">Submit</button>
            </form>
        </fieldset>
	</div>
</div>

