
 <!-- BEGIN CORE JS FRAMEWORK-->

  <script src="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/breakpoints.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
  <!-- END CORE JS FRAMEWORK -->

  <!-- BEGIN PAGE LEVEL JS -->
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-autonumeric/autoNumeric.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/ios-switch/ios7-switch.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>

  <script src="<?=base_url()?>awedget/assets/plugins/boostrap-form-wizard/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-validation/dist/additional-methods.min.js" type="text/javascript"></script>


  <script src="<?=base_url()?>awedget/assets/plugins/jquery-superbox/js/superbox.js" type="text/javascript"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

  <!-- BEGIN PAGE DATATABLE -->
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-datatable/extra/js/TableTools.min.js" type="text/javascript" ></script>
  <script src="<?=base_url()?>awedget/assets/plugins/datatables-responsive/js/datatables.responsive.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/datatables-responsive/js/lodash.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- <script src="<?=base_url()?>awedget/assets/js/datatables.js" type="text/javascript"></script> -->
  <script src="<?=base_url()?>awedget/assets/js/tabs_accordian.js" type="text/javascript"></script>
  <script src="<?=base_url()?>awedget/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <script src="<?=base_url()?>awedget/assets/js/messages_notifications.js" type="text/javascript"></script>
  <!-- BEGIN CORE TEMPLATE JS -->
  <script src="<?=base_url()?>awedget/assets/js/core.js" type="text/javascript"></script>
  <!-- <script src="<?=base_url()?>awedget/assets/js/chat.js" type="text/javascript"></script>  -->
  <script src="<?=base_url()?>awedget/assets/js/demo.js" type="text/javascript"></script>

  <script src="<?=base_url()?>awedget/assets/croper/js/cropper.min.js"></script>
  <script src="<?=base_url()?>awedget/assets/croper/js/main.js"></script>

  <!-- END CORE TEMPLATE JS -->
  <script src="<?=base_url()?>js/common.js" type="text/javascript"></script>

  <script>
    function showMessage(icon, message) {
      const Toast = Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
          didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
          },
      });
      Toast.fire({
          icon: icon,
          title: message,
      });
    }
  </script>
  <script>
   function alert(d) {
        Swal.fire({
            icon: "success",
            title: d,
        });
    }
  </script>

  <script>
      $(document).ready(function() {
        $('#unit_id').trigger('change');
        $('.date').datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
          autocomplete: false,
          todayHighlight: true,
          fridayHighlight: true,

        });
        $('.date').on('change', function() {
            var date = $(this).datepicker('getDate');
            $(this).attr( $.datepicker.formatDate('dd-mm-yyyy', date));
        }).datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
          autocomplete: false,
          todayHighlight: true,
          fridayHighlight: true
        });
        //  $('.date').attr("placeholder", "dd-mm-yyyy");
      });
  </script>

  <script>
      setTimeout(function() {
        $('#mydivdanger').fadeOut('fast');
      }, 4000); // <-- time in milliseconds

      function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
      }
      function printSpecificContents(id)
      {
            var divContents = document.getElementById(id).innerHTML;
            var printWindow = window.open('', '', 'height=800,width=1000');
            printWindow.document.write(divContents);

            printWindow.print();

      }
  </script>

  <script type="text/javascript">
    $(".edit-text").on("keyup", function() {
        $(".default-text").html($(".edit-text").val());
    });

    function en2bn(sum){
      var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};

      String.prototype.getDigitBanglaFromEnglish = function() {
          var retStr = this;
          for (var x in finalEnlishToBanglaNumber) {
               retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
          }
          return retStr;
      };

      var english_number=String(sum);

      var bangla_converted_number=english_number.getDigitBanglaFromEnglish();

      return bangla_converted_number;
    }

  </script>

  <script language="javascript" type="text/javascript">
    function convertNumberToWords(amount) {
        var words = new Array();
        words[0] = '';
        words[1] = 'One';
        words[2] = 'Two';
        words[3] = 'Three';
        words[4] = 'Four';
        words[5] = 'Five';
        words[6] = 'Six';
        words[7] = 'Seven';
        words[8] = 'Eight';
        words[9] = 'Nine';
        words[10] = 'Ten';
        words[11] = 'Eleven';
        words[12] = 'Twelve';
        words[13] = 'Thirteen';
        words[14] = 'Fourteen';
        words[15] = 'Fifteen';
        words[16] = 'Sixteen';
        words[17] = 'Seventeen';
        words[18] = 'Eighteen';
        words[19] = 'Nineteen';
        words[20] = 'Twenty';
        words[30] = 'Thirty';
        words[40] = 'Forty';
        words[50] = 'Fifty';
        words[60] = 'Sixty';
        words[70] = 'Seventy';
        words[80] = 'Eighty';
        words[90] = 'Ninety';
        amount = amount.toString();
        var atemp = amount.split(".");
        var number = atemp[0].split(",").join("");
        var n_length = number.length;
        var words_string = "";
        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++, j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }
            value = "";
            for (var i = 0; i < 9; i++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    value = n_array[i] * 10;
                } else {
                    value = n_array[i];
                }
                if (value != 0) {
                    words_string += words[value] + " ";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Crores ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Lakhs ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Thousand ";
                }
                if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                    words_string += "Hundred and ";
                } else if (i == 6 && value != 0) {
                    words_string += "Hundred ";
                }
            }
            words_string = words_string.split("  ").join(" ");
        }
        return words_string;
    }
  </script>

  <script>
     $(document).ready(function() {

        $("#main-menu ul > li").click(function(e) {
            $(this).siblings('li.active').removeClass("active");
            $(this).find('li.open').removeClass("open");
            $(this).addClass("active");
         });


        $('.anchor_cls').on('click', function(){
          $('#main-menu ul > li').siblings('ul li').find("a.mactive").removeClass("mactive");
          $(this).parent().siblings().find('.mactive').removeClass('mactive');
          $(this).addClass('mactive');
        });
     });
  </script>

  <script>
    $(document).ready(function() {
      $('.select22').select2();
    });
  </script>
<script>
    $(document).ready(function(){
        $(".date").datepicker({
            dateFormat: 'dd-mm-yy' // Set the desired date format
        });
   });
</script>


</body>
</html>
