<label for="book_gallery_idList">
    <?php echo __('Add your gallery images by selecting from the media library', 'bk5') ?>
</label>

<input type="hidden" id="book_gallery_idList" 
    name="book_gallery_idList" value="<?php esc_attr($gallery_list); ?>"
/>

<div id="book_gallery_thumbnails">

    <?php

    if ($gallery_list) {
        $images = explode(',', $gallery_list);
        foreach ($images as $image_id) {
            echo wp_get_attachment_image($image_id, 'thumbnail');
        }
    }
    ?>

</div>

<button type="button" class="button" id="book_gallery_button">Add Images</button>

<script>

    document.addEventListener('DOMContentLoaded', function() {

        const galleryButton = document.getElementById('book_gallery_button');

        const galleryField = document.getElementById('book_gallery_idList');

        const galleryThumbnails = document.getElementById('book_gallery_thumbnails');

        const frame = wp.media({
            title: 'Select or Upload Images',
            button: {
                text: 'Use these images'
            },
            multiple: true
        });

        frame.on('select', () => {


            // mystrious code
            const attachments = frame.state().get('selection').map(function(attachment) {
                attachment.toJSON();
                return attachment;
            });

            let imgIdList = [];
            let thumbnails = '';

            attachments.forEach(function(attachment) {

                imgIdList.push(attachment.id);
                thumbnails += `<img class="metabox_img_item" src="${attachment.attributes.sizes.thumbnail.url}" />`;

            });

            galleryField.value = imgIdList.join(',');
            galleryThumbnails.innerHTML = thumbnails;
        });

        galleryButton.addEventListener('click', function(e) {

            e.preventDefault();

            frame.open();

        });
    });

</script>