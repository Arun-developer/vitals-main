
<script src="<?php echo base_url() . 'source/vital/js/custom_scripts.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            //'height': (($(window).height()) - 200) + 'px'
        });
    });
    //$('table').DataTable();
    /* $('table').DataTable({
        "bPaginate": false,
        "showNEntries" : false
    });
    $('table').DataTable();
    $(document).ready(function() {
        $('table').dataTable({
            "bPaginate": false,
            "showNEntries" : false,
            "aoColumnDefs": [{"bSortable": false, "aTargets": [4]}],
            "aaSorting": [[1, 'asc']],
            "order": [[ 1, 'desc' ]],  
        });
    }); */
    // table row in a table clickable as a link
    // ---------------------------------------
    (function() {
        'use strict';
        $(activate);
        function activate() {
            $('.nav-tabs')
                .scrollingTabs({
                    enableSwiping: true
                })
                .on('ready.scrtabs', function() {
                    $('.tab-content').show();
            });
        }
    }());


    
    $(document).on('input', '.alphaonly', function () {
            if (this.value.match(/[^a-zA-Z ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z ]/g, '');
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

  
</script>
