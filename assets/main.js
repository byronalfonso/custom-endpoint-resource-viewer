( function( $ ) {
	$( document ).ready( function() {
        /* Cache the modal */
        $modal = $('.cerv-modal-overlay');

        $('.user-details-link').on('click', function(e){
            e.preventDefault();
            let userId = $(this).data('user-id');
            $modal.show();
        })

        /* Hide the modal window if overlay is clicked */
        $modal.on('click', function(e){
            $modal.hide();
        })

        /* Hide the modal window if x button is clicked */
        $('.close-cerv-modal-btn').on('click', function(e){
            $modal.hide();
        })
    });
}( jQuery ) );