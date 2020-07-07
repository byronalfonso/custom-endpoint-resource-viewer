( function( $ ) {
	$( document ).ready( function() {
        /* Cache the modal */
        $modal = $('.cerv-modal-overlay');

        $('.user-details-link').on('click', function(e){
            e.preventDefault();
            let userId = $(this).data('user-id');
            $modal.show();

            // jQuery.ajax({
            //     type:"POST",
            //     url: esd_ajax_obj.ajax_url,
            //     data: {
            //     action: "esd_fetch_skills"
            //     },
            //     success:function(response){
            //     loadExamResults(response.data.skills);
            //     },
            //     error: function(errorThrown){
            //     alert('Unable to process request: ' + errorThrown);
            //     console.log(response, 'response');
            //     }
            // });

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