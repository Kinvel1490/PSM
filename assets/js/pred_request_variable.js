document.addEventListener("DOMContentLoaded", ()=>{
    jQuery('body').on('change', '[id^="variable_stock_status"]', (e)=>{
        var t = jQuery(e.target);
        var stokstat = t.val();
        var radios = t.parents('.woocommerce_variable_attributes').find('.variable_pred_request_radio');
        var input = t.parents('.woocommerce_variable_attributes').find('[id^="variable_pred_request_manual_value"]')
        if (stokstat == 'onbackorder'){
            radios.removeAttr('disabled');
        } else {
            radios.attr('disabled', '');
            radios.prop('checked',  false);
            input.val('');
            input.attr('disabled');
        }
    })
    jQuery('body').on('change', '.variable_pred_request_radio', (e)=>{
        var rbtn = jQuery(e.target);
        var check = rbtn.val();
        console.log(check);
        if(check == 'manual'){
            rbtn.parents('.variable_pred_request_field').find('[id^="variable_pred_request_manual_value"]').removeAttr('disabled');
        } else {
            rbtn.parents('.variable_pred_request_field').find('[id^="variable_pred_request_manual_value"]').attr('disabled', '');
            rbtn.parents('.variable_pred_request_field').find('[id^="variable_pred_request_manual_value"]').val('');
        }
    })
});