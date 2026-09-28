<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-3" style="padding: 7px;">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/company_info_setup') ?>">
                        < < Back</a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
                </div>
            </div>
            <div class="col-md-6">
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="">
                        <form class="navbar-form pull-right" role="search">
                            <div class="input-group">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
    <div class="row">
        <?php
            $failuer = $this->session->flashdata('failure');
            ?>
    </div>
    <div class="tablebox">
        <h3>Update Company Unit</h3>
        <form enctype="multipart/form-data" method="post" name="creatcompanyunit"
            action="<?php echo base_url().'setup_con/company_edit/'.$company_infos->id;?>">
            <input type="hidden" name="id" value="<?=$company_infos->id?>" class="form-control">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Company Name English</label>
                            <input type="text" name="name"
                                value="<?=set_value('company_name_english',$company_infos->company_name_english)?>"
                                class="form-control">
                            <?php echo form_error('name');?>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Company Name Bangla</label>
                            <input type="text" name="bname"
                                value="<?php echo set_value('company_name_bangla',$company_infos->company_name_bangla)?>"
                                class="form-control bfont">
                            <?php echo form_error('bname');?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Company Address English</label>
                            <input type="text" name="en_add" value="<?php echo set_value('company_add_english',$company_infos->company_add_english)?>" class="form-control">
                            <?php echo form_error('en_add');?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Company Address Bangla</label>
                            <input type="text" name="bn_add" value="<?php echo set_value('company_add_bangla',$company_infos->company_add_bangla)?>" class="form-control bfont">
                            <?php echo form_error('bn_add');?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Company Phone No</label>
                            <input type="text" name="phn"
                                value="<?php echo set_value('company_phone',$company_infos->company_phone)?>"
                                class="form-control">
                            <?php echo form_error('phn');?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Company Logo</label>
                            <img width="55" height="55"
                                src="<?=base_url()?>images/<?=$company_infos->company_logo ?>" />
                            <input style="padding: 4px 9px;height: 37px!important;border: 1px solid #0aa699 !important;"
                                type="file" name="comlogo" id="comlogo"
                                value="<?php echo set_value('company_logo',$company_infos->company_logo)?>"
                                class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Company Signature</label>
                            <img width="55" height="55"
                                src="<?=base_url()?>images/<?=$company_infos->company_signature ?>" />
                            <input style="padding: 4px 9px;height: 37px!important;border: 1px solid #0aa699 !important;"
                                type="file" name="comsign" value="" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Register Signature</label>
                            <img width="55" height="55"
                                src="<?=base_url()?>images/<?=$company_infos->register ?>" />
                            <input style="padding: 4px 9px;height: 37px!important;border: 1px solid #0aa699 !important;"
                                type="file" name="register" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group footer_button">
                        <button class="btn btn-primary">Update</button>
                        <a href="" class="btn-warning btn">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
