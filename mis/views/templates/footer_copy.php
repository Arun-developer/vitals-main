
    <!--
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>    
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

    

      <!--<script src="<?php echo base_url() . 'source/mis/js/toastr.min.js'; ?>"></script>-->
    
     
    <script>
      

         $(document).ready(function () {
            $(".tlf_row1").click(function(){
               var activeClass= $(this).closest('tr').attr('class');
                $(".tlf_1").toggle(); 
                $('.selectedOne').addClass('active') ;
                if(activeClass=='selectedOne active'){
                    $('.selectedOne').removeClass('active') ;
                }        
            });
            $(".tlf_row2").click(function(){   
                var activeClass= $(this).closest('tr').attr('class');             
                $(".tlf_2").toggle(); 
                $('.selectedTwo').addClass('active') ;
                if(activeClass=='selectedTwo active'){
                    $('.selectedTwo').removeClass('active') ;
                }                 
            });
            $(".tlf_row3").click(function(){  
                var activeClass= $(this).closest('tr').attr('class');              
                $(".tlf_3").toggle(); 
                $('.selectedThree').addClass('active') ;
                if(activeClass=='selectedThree active'){
                    $('.selectedThree').removeClass('active') ;
                }                 
            });
       });

        



    // $('table').DataTable();

    // table row in a table clickable as a link
    // ---------------------------------------      


    $(document).ready(function() {

        $('#multiselect, #accessibleTo').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

    });

    function getSelectedValues() {
        var selectedVal = $("#multiselect, #accessibleTo").val();
        for (var i = 0; i < selectedVal.length; i++) {
            if (window.CP.shouldStopExecution(0)) break;

            function innerFunc(i) {
                setTimeout(function() {
                    location.href = selectedVal[i];
                }, i * 2000);
            }
            innerFunc(i);
        }
        window.CP.exitedLoop(0);
    }

        $(document).on('input', '.alphaonly', function () {
            if (this.value.match(/[^a-zA-Z .]/g)) {
                this.value = this.value.replace(/[^a-zA-Z .]/g, '');
            }
        });

        $(document).on('input', '.numberonly', function () {
            if (this.value.match(/[^0-9 ]/g)) {
                this.value = this.value.replace(/[^0-9 ]/g, '');
            }
        });

        $(document).on('input', '.mobilenumber', function () {
            if (this.value.match(/[^0-9+ ]/g)) {
                this.value = this.value.replace(/[^0-9+ ]/g, '');
            }
        });

        $(document).on('input', '.faxnumber', function () {
            if (this.value.match(/[^0-9+.\- ]/g)) {
                this.value = this.value.replace(/[^0-9+.\- ]/g, '');
            }
        });

        $(document).on('input', '.commonAlphaNum', function () {
            if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
            }
        });
        $(document).on('input', '.email_spc', function () {
            if (this.value.match(/[^a-zA-Z0-9.@_]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9.@_]/g, '');
            }
        });
		$(document).on('input', '.descp', function () {
            if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
            }
        });

        $(document).on('input', '.currencyField', function (evt) {
            var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            self.val(inrFormat(self.val()));
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
            var matchedString = self.val().match(patt);
            if (matchedString) {
                self.val(matchedString);
            }
        });



        function inrFormat(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            var z = 0;
            var len = String(x1).length;
            var num = parseInt((len / 2) - 1);
            while (rgx.test(x1)) {
                if (z > 0) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                } else {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    rgx = /(\d+)(\d{2})/;
                }
                z++;
                num--;
                if (num == 0) {
                    break;
                }
            }
            return x1 + x2;
        }
        // table row in a table clickable as a link
        // --------------------------------------- 
    </script>

</html>