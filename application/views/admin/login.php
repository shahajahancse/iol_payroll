<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <title>Mysoftheaven (BD) LTD | Log in</title> -->
  <title>AJ Group</title>
  <link rel='shortcut icon' href='<?=base_url()?>awedget/assets/img/loopdot.png' />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>awedget/assets/plugins/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url()?>awedget/assets/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>awedget/assets/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url()?>awedget/assets/css/blue.css">

</head>
<style>

</style>
<body class="hold-transition login-page" style="background-position: center center; background-size: cover; background-image: url('<?=base_url()?>awedget/assets/img/pos-background.jpg')">
  <div class="login-box">

  <!-- /.login-logo -->
  <div class="login-box-body">
    <div class="login-logo" style="border-bottom: 1px solid blue;padding-bottom: 25px;">
      <a href="http://mysoftheaven.com/" target="_blank">
        <!-- <img src="<?=base_url()?>awedget/assets/img/loopdot.png" width="" height="70px"> -->
        <img src="<?=base_url()?>awedget/assets/img/logo.png" width="160px" height="40px">
      </a>
    </div>
    <!-- <p class="login-box-msg" style="font-size: 20px;">MHL KORMOCHARI</p> -->
    <p class="login-box-msg">Sign In</p>
     <div class="text-danger tex-center"></div>
     <div class="text-success tex-center"></div>

    <?php  echo form_open('user_autentication');  ?>
    <!-- <form action="http://mysoftheaven.com/mipos-cloud/login/verify" method="post"> -->
    <!-- <form action="" method="post"> -->

      <input type="hidden" name="csrf_test_name" value="b4df53659d7baec0b06216d99a4f9359">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" id="username" name="username" autofocus><span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="pass" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label style="padding-left: 20px;">
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- <a href="javascript:">Forgot password?</a><br> -->
    <div class="row">
    </div>
  </div>
  <!-- /.login-box-body -->
</div>

<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<!-- <script src="http://mysoftheaven.com/mipos-cloud/theme/plugins/jQuery/jquery-2.2.3.min.js"></script> -->
<script src="<?=base_url()?>awedget/assets/plugins/jquery-3.2.1.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/js/bootstrap.min.js"></script>
<!-- iCheck -->

<script type="text/javascript" >
$(function($) { // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({ data: {'csrf_test_name' : 'b4df53659d7baec0b06216d99a4f9359' }  }); });
</script>

</body>
</html>
