$(()=>{
    $( '.single_add_to_cart_button_vis' ).on( 'click', (e)=>{
        var thisbutton = $(e.target.closest('.single_add_to_cart_button_vis'));
        var prod_id = thisbutton.val();
        var prod_sku = thisbutton.attr('data-sku');
        
        if(thisbutton.closest('.prod_params')){
            var prod_qty = $('#qty').val();
        }
        if(document.querySelector('.variations_form.cart button')){
            if(!$('.variations_form.cart button').hasClass('disabled')){
                let variation = 0;
                var params = JSON.parse($('.variations_form').attr('data-product_variations'))
                let sels = {};
                let f = '';
                let w = '';
                document.querySelectorAll('.prod_params_cuts_width_select').forEach(sel=>{
                    let attr_name = sel.getAttribute('data-attribute_name')
                        sels[`${attr_name}`] = sel.value;
                });
                params.forEach(param=>{
                    if(JSON.stringify(param.attributes) === JSON.stringify(sels) ){
                        variation = param.variation_id;
                    }
                });
                if(document.querySelector('#prod_params_nocut')){
                    f = document.querySelector('#prod_params_nocut').checked;
                }
                if(document.querySelector('.prod_params_cuts_width_select')){
                    w = $('[data-nam]').find('select').val();
                }
                var data = {
                    action: 'psm_woocommerce_ajax_add_to_cart',
                    nonce: images_oject.nonce,
                    product_id: prod_id,
                    product_sku: prod_sku > 0 ? prod_sku : "",
                    quantity: prod_qty > 0 ? prod_qty : 1,
                    variation: variation > 0 ? variation : 0,
                    full: f,
                    width: w
                };
                sendAjax(data, thisbutton);
            }
        } else{
            data = {
                action: 'psm_woocommerce_ajax_add_to_cart',
                nonce: images_oject.nonce,
                product_id: prod_id,
                product_sku: prod_sku > 0 ? prod_sku : "",
                quantity: prod_qty > 0 ? prod_qty : 1,
            };
            sendAjax(data, thisbutton);
        }
    });

    $('.sucsess_wrapper_continue, .sucsess_wrappe_close').on('click', ()=>{
        $('.sucsess_wrapper').removeClass('show');
    })

    function sendAjax (data, button) {
        $.ajax({
            type: 'post',
            url: images_oject.ajaxurl,
            data: data,
            beforeSend: function (response) {
                button.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                button.addClass('added').removeClass('loading');
            },
            success: function (response) {
                var data = JSON.parse(response);
                button.addClass('single_add_to_cart_button_in_cart');
                button.html('<img src="'+data.img+'" alt="">'+'В корзине');
                $('.sucsess_wrapper').addClass('show');
                var cc = document.querySelector('#cart_count');
                if (cc) {
                    cc.innerHTML = data.prod_count;
                } else {
                    var f = document.createElement('span');
                    f.setAttribute('class', 'header_count')
                    f.setAttribute('id', 'cart_count');
                    f.innerHTML = data.prod_count;
                    document.querySelector('#cart_count_link').appendChild(f);
                }
            },
        });
    }
});