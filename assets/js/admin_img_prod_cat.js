if(document.querySelector('#add_new_doc')){
    document.querySelector('#add_new_doc').addEventListener('click', add_new_doc_fields)
}
jQuery('.remove_doc_block').on('click', delete_doc_field)

// Only show the "remove image" button when needed
document.querySelectorAll('.document_attrs_image_id').forEach(doc_img=>{
    if(doc_img.value === '0'){
        doc_img.closest('.form-field').querySelector('.remove_document_image').setAttribute('style', 'display: none')
    }
})

// Uploading files

jQuery( document ).on( 'click', '.upload_document_image', function( event ) {
    var document_image_frame;
    var id = event.target.getAttribute('id');
    var last_land = id.lastIndexOf('_');
    var ind = id.substring(last_land + 1);

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( document_image_frame ) {
        document_image_frame.open();
        return;
    }

    // Create the media frame.
    document_image_frame = wp.media.frames.downloadable_file = wp.media({
        title: 'Выберете изображение',
        button: {
            text: 'Использовать изображение'
        },
        multiple: false
    });

    // When an image is selected, run a callback.
    document_image_frame.on( 'select', function() {
        var attachment           = document_image_frame.state().get( 'selection' ).first().toJSON();
        var attachment_thumbnail = attachment.sizes.full;
        jQuery( '#document_attrs_image_id_'+ind ).val( attachment.id );
        jQuery( '#document_image_'+ind ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
        jQuery( '#remove_document_image_'+ind ).show();
    });

    // Finally, open the modal.
    document_image_frame.open();
});

jQuery( document ).on( 'click', '.remove_document_image', function(event) {
    var id = event.target.getAttribute('id');
    var last_land = id.lastIndexOf('_');
    var ind = id.substring(last_land + 1);

    jQuery( '#document_image_'+ind ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
    jQuery( '#document_attrs_image_id_'+ind ).val( '' );
    jQuery( '#remove_document_image_'+ind ).hide();
    return false;
});


//ФАЙЛ

document.querySelectorAll('.document_attrs_file_id').forEach(doc_img=>{
    if(doc_img.value === '0'){
        doc_img.closest('.form-field').querySelector('.remove_document_file').setAttribute('style', 'display: none')
    }
})

// Uploading files

jQuery( document ).on( 'click', '.upload_document_file', function( event ) {
    var document_file_frame;
    var id = event.target.getAttribute('id');
    var last_land = id.lastIndexOf('_');
    var ind = id.substring(last_land + 1);

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( document_file_frame ) {
        document_file_frame.open();
        return;
    }

    // Create the media frame.
    document_file_frame = wp.media.frames.downloadable_file = wp.media({
        title: 'Выбрать файл',
        button: {
            text: 'Выбрать файл'
        },
        multiple: false
    });

    // When an image is selected, run a callback.
    document_file_frame.on( 'select', function() {
        var attachment           = document_file_frame.state().get( 'selection' ).first().toJSON();
        jQuery( '#document_attrs_file_id_'+ind ).val( attachment.id );
        jQuery( '#document_attrs_filesize_'+ind ).val( attachment.filesizeHumanReadable );
        jQuery( '#document_link_'+ind ).attr('href', attachment.link);
        jQuery( '#document_link_'+ind ).html(attachment.filename);
        jQuery( '#document_attrs_filename_'+ind ).val(attachment.filename);
        jQuery( '#remove_document_file_'+ind ).show();
    });

    // Finally, open the modal.
    document_file_frame.open();
});

jQuery( document ).on( 'click', '.remove_document_file', function(event) {
    var id = event.target.getAttribute('id');
    var last_land = id.lastIndexOf('_');
    var ind = id.substring(last_land + 1);

    jQuery( '#document_attrs_filename_'+ind ).val('') ;
    jQuery( '#document_attrs_file_id_'+ind ).val( '' );
    jQuery( '#document_attrs_filesize_'+ind ).val( '' );
    jQuery( '#document_link_'+ind ).attr('href', '');
    jQuery( '#document_link_'+ind ).html('');
    jQuery( '#remove_document_file_'+ind ).hide();
    return false;
});


function add_new_doc_fields () {
    var docFields = Array.from(document.querySelectorAll('.document_attrs_fields'));
    if(docFields.length > 0){
    var id = docFields[docFields.length - 1].getAttribute('id')
    var last_land = id.lastIndexOf('_');
    var ind = parseInt(id.substring(last_land + 1));
    ind = ind + 1;} else {
        ind = 0;
    }
    var forms_wrapper = document.querySelector('.document_attrs_fields_wrapper') ? document.querySelector('.document_attrs_fields_wrapper') : '';
    forms_wrapper.innerHTML = forms_wrapper.innerHTML + `
    <div class="document_attrs_fields" id="document_attrs_fields_${ind}">
    <div class="form-field document_attrs[${ind}][img]_product_field">
        <div id="document_image_${ind}" class="document_image" style="float:left; margin-right: 10px"><img src="" width="60px" height="60px" /></div>
        <div style="line-height: 30px;">
            <input type="hidden" class="document_attrs_image_id" id="document_attrs_image_id_${ind}" name="document_attrs[${ind}][img]" value="0" />
            <button type="button" id="upload_document_image_${ind}" class="upload_document_image button">Загрузить/добавить изображение</button>
            <button type="button" id="remove_document_image_${ind}" class="remove_document_image button">Удалить изображение</button>
        </div>
    </div>
    <div class="form-field document_attrs[${ind}][file]_product_field">
        <div style="line-height: 30px;">
            <input type="hidden" id="document_attrs_filename_${ind}" name="document_attrs[${ind}][filename]" value="0" />
            <input type="hidden" class="document_attrs_file_id" id="document_attrs_file_id_${ind}" name="document_attrs[${ind}][file]" value="0" />
            <input type="hidden" class="document_attrs_filesize" id="document_attrs_filesize_${ind}" name="document_attrs[${ind}][filesize]" value="0" />
            <a href="" class='document_link' id='document_link_${ind}' download></a>
            <button type="button" id="upload_document_file_${ind}" class="upload_document_file button">Загрузить/добавить файл</button>
            <button type="button" id="remove_document_file_${ind}" class="remove_document_file button">Удалить файл</button>
        </div>
    </div>
    <p class="form-field document_attrs[${ind}][descr]_product_field">
        <label for="document_description" class="document_description_${ind}_label">Название файла</label>
        <input id="document_description_${ind}" class='document_description_${ind} short' type="text" name="document_attrs[${ind}][descr]" id="document_attrs_descr_id_${ind}" style="float: unset">
    </p>
    <button type="button" class="remove_doc_block button is_destructive" id="remove_doc_block_${ind}" class="button">Удалить документ</button>

    </div>
    `
    jQuery('.remove_doc_block').on('click', delete_doc_field)
}

function delete_doc_field (e) {
    e.target.closest('.document_attrs_fields').remove();
}