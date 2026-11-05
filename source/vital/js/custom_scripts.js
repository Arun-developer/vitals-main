$("#select_all").click(function() {
    $(".delete_ids").html("");
    $('input:checkbox').not(this).prop('checked', this.checked);
    $("#delete_btn").attr({
        "data-target": ""
    });
    if (this.checked && this.checked != '') {
        if ($('.display_lists input:checked').length > 0) {
            $(".master_deluser").addClass("master_deluser_mark");
            $(".master_deluser").css("color", "#e52644");
            $("#delete_btn").attr({
                "data-target": "#deleteModal"
            });
            $("#dummy_edit_btn").css('display', 'none');
            $("#edit_btn").css('display', 'block');
        }
    }
    if (!this.checked) {
        $('form input[type="text"],select,textarea').attr("disabled", true);
        $(".master_deluser").removeClass("master_deluser_mark");
        $("#delete_btn").attr({
            "data-target": ""
        });
        $('.saveLinkView').addClass("display-hide");
        $('.saveLinkView').removeClass("display-show");
        $("#dummy_edit_btn").css('display', 'block');
        $("#edit_btn").css('display', 'none');
    }
    if ($('#select_all').is(":checked")) {
        delete_checkbox();
    }

});

$("#edit_btn").click(function() {
    $(".check_box_list").each(function() {
        var ischecked = $(this).is(':checked');
        if ($('.display_lists input:checked').length > 0) {
            if (ischecked && this.value != '') {
                console.log("#td_" + this.value + " td > textarea");
                $("#td_" + this.value + " td > input").attr("disabled", false);
                $("#td_" + this.value + " td > select").attr("disabled", false);
                $("#td_" + this.value + " td > textarea").attr("disabled", false);
                $("#hid_" + this.value).attr("disabled", false);
                $('.saveLinkView').removeClass("display-hide");
                $('.saveLinkView').addClass("display-show");
            }
        }
        if (!ischecked) {
            console.log("#td_" + this.value + " td > textarea");
            $("#td_" + this.value + " td > input").attr("disabled", true);
            $("#td_" + this.value + " td > select").attr("disabled", true);
            $("#td_" + this.value + " td > textarea").attr("disabled", true);
            $("#hid_" + this.value).attr("disabled", true);
            $("input[type='checkbox']").attr("disabled", false);
            if ($('.display_lists input:checked').length == 0) {
                $('.saveLinkView').addClass("display-hide");
                $('.saveLinkView').removeClass("display-show");
            }
        }
    });
});


$(".check_box_list").click(function() {
    $(".delete_ids").html("");
    $(".master_deluser").removeClass("master_deluser_mark");
    var ischecked = $(this).is(':checked');
    if ($('.display_lists input:checked').length > 0) {
        delete_checkbox();
        $("#delete_btn").attr({
            "data-target": "#deleteModal"
        });
        $(".master_deluser").css("color", "#e52644");
        $(".master_deluser").addClass("master_deluser_mark");
        $("#dummy_edit_btn").css('display', 'none');
        $("#edit_btn").css('display', 'block');
    }
    if (!ischecked) {
        if ($('.display_lists input:checked').length < 1) {
            $('#select_all').prop('checked', false);
            $(".master_deluser").removeClass("master_deluser_mark");
            $('.saveLinkView').addClass("display-hide");
            $('.saveLinkView').removeClass("display-show");
            $("#dummy_edit_btn").css('display', 'block');
            $("#edit_btn").css('display', 'none');
        }
        $("#td_" + this.value + " td > input").attr("disabled", true);
        $("#td_" + this.value + " td > select").attr("disabled", true);
        $("#td_" + this.value + " td > textarea").attr("disabled", true);
        $("#hid_" + this.value).attr("disabled", true);

        $("input[type='checkbox']").attr("disabled", false);
        $("#delete_btn").attr({
            "data-target": ""
        });
    }
});


function delete_checkbox() {
    checkbox_ids = [];
    i = 0;
    $(".check_box_list").each(function() {
        if (this.checked) {
            checkbox_ids[i] = this.value;
            i++;
        }
    });
    console.log(checkbox_ids);
    $(".delete_ids").html("<input type='hidden' name='delete_ids' id='delete_ids' value='" + checkbox_ids + "'>");
}


function manual_required(form_id,retrict_type,error_msg){ 
   // console.log('retrict_type'+retrict_type);
   //console.log(type + ' -- ');console.log(label_err);
    //console.log('Value :'+this.value);
    $i=0;
    err_count = 0;
    //$('form input[type="text"],select').not(":disabled").each(function(){
    $('#'+form_id).find('input[type="text"],select,textarea').not(":disabled").each(function(){
        
        var label_err = $(this).attr('data-err');
        var type = this.type;
        console.log('type :'+type);
        $("#"+label_err).text('');
        if((this.value =='' || this.value == undefined) && type !='textarea'){ 
          err_count+=$i+1;
          if(error_msg!=''){
            $("#"+label_err).text(error_msg);    
          }else{
            $("#"+label_err).text('The field is required');
          }   
        }else{
            if(type =='text' && retrict_type ==''){
                var regex = new RegExp("^[a-zA-Z ]+$");
                if (!regex.test(this.value)){
                    err_count+=$i+1;
                    $("#"+label_err).text('The field is required only alphabets');
                }
            }else if((type =='text' || type =='textarea') && retrict_type =="alpha_special" ){ console.log('label_err '+label_err);
                var values = this.value;
                var value_without_space = values.replace(/\s/g, "");
                if(value_without_space!=''){
                    var regex = new RegExp("^[a-zA-Z,•()&.-:\-/–+’ ]+$");
                    if (!regex.test(value_without_space)){
                        err_count+=$i+1;
                        $("#"+label_err).text('The field is required value');
                    }
                }
                
            }
        }
        $i++;
    });
    if(err_count > 0){
        //console.log('err_count '+ err_count);
        return false;
    }
}