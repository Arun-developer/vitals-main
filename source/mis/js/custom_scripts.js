function manual_required(form_id,retrict_type){ 
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
          $("#"+label_err).text('The field is required');
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