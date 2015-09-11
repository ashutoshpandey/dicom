$(function(){
    $("input[name='btn-save-quotation']").click(saveQuotation);
});

function saveQuotation(){

    if(isQuotationFormValid()){

        var data = $("#form-quotation").serialize();

        $.ajax({
            url: root + '/save-quotation',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Quotation saved successfully');

                    $("input[name='btn-save-quotation']").remove();
                }
            }
        });
    }
}

function isQuotationFormValid(){
    return true;
}