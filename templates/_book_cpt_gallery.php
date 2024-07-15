<div class="book-gallery-images">

    <ul class="book-gallery-container">
        <?php if ( $book_gallery ) : ?>
            <?php foreach ( $book_gallery as $image_id => $image_url ) : ?>
                <li>
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="">
                    <input type="hidden" name="book_gallery[<?php echo esc_attr( $image_id ); ?>]" value="<?php echo esc_attr( $image_url ); ?>">
                    <button type="button" class="remove-book-gallery-image button">Remove Image</button>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <button type="button" class="button" id="upload-book-gallery-images">Upload Images</button>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const uploadButton = document.getElementById('upload-book-gallery-images');

        const galleryContainer = document.querySelector('.book-gallery-container');

        // Event listener for upload button
        uploadButton.addEventListener('click', () => {
           
            const mediaUploader = wp.media({
                title: 'Select Images for Book Gallery',
                button: { text: 'Add to gallery' },
                multiple: true
            });

            mediaUploader.on('select', function() {

                const attachments = mediaUploader.state().get('selection').toJSON();

                console.log(attachments);

                attachments.forEach(function(attachment) {
                    var li = document.createElement('li');
                    li.innerHTML = '<img src="' + attachment.url + '" alt=""><input type="hidden" name="book_gallery[' + attachment.id + ']" value="' + attachment.url + '"><button type="button" class="remove-book-gallery-image button">Remove Image</button>';
                    galleryContainer.appendChild(li);
                });
            });

            mediaUploader.open();

        });

        galleryContainer.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-book-gallery-image')) {
                e.target.parentNode.remove();
            }
        });
    });
</script>