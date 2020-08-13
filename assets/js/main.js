( function( $ ) {
	$( document ).ready( function() {
        // Cache the modal and loader
        $modal = $('.cerv-modal-overlay');
        $loader = $('.cerv-loader-container');

        $('.user-details-link').on('click', function(e){
            e.preventDefault();
            runModal();
            let userId = $(this).data('user-id');
            let userDetailsPath = `${cervObj.api_endpoint}/${userId}`;

            console.log({userDetailsPath});

            getResourceDetails( userDetailsPath );
        });

        // Hide the modal window if overlay is clicked
        $modal.on('click', function(e){
            terminateModal();
        });

        // Hide the modal window if x button is clicked
        $('.close-cerv-modal-btn').on('click', function(e){
            terminateModal();
        });


        // Display the loader and modal
        function runModal(){
            $loader.show();
            $modal.show();            
        }

        // Hide the loader and modal
        function terminateModal(){
            $loader.hide();
            $modal.hide();            
        }

        // processes the API request for resource details
        function getResourceDetails($url){
            _GET($url, populateResourceDetails, displayError);
        }
        
        // If request is successful, populate the modal box with dynamic data
        function populateResourceDetails(data){
            let address = data.address;
            let company = data.company;

            let content = (
                `<div class="user-info">
                    <h5>User Info</h5>
                    <p><span class="modal-label">Username: </span> ${data.username}</p>
                    <p><span class="modal-label">Email: </span> ${data.email}</p>
                    <p><span class="modal-label">Phone: </span> ${data.phone}</p>
                    <p><span class="modal-label">Website: </span> ${data.website}</p>
                    <p><span class="modal-label">Address: </span> ${address.suite}, ${address.street}, ${address.city}, ${address.zipcode}</p>
                </div>
                <hr />
                <div class="company">
                    <h5>Company</h5>
                    <p><span class="modal-label">Name: </span>${company.name}</p>
                    <p><span class="modal-label">Catch Phrase: </span>${company.catchPhrase}</p>
                    <p><span class="modal-label">BS: </span>${company.bs}</p>
                </div>`
            );
            
            $('.cerv-modal-header .title').text(data.name);
            $('.cerv-modal-content').html(content);
            $loader.hide();
        }
        
        // If request failed, make sure to display an error to the user
        function displayError(jqXHR, textStatus, error){
            $('.cerv-modal-header .title').text('Error');

            let content = (
                `<div class="error">
                    <p>Unable to process your request.</p>
                    <p>Please reload your page or try again later.</p>
                </div>`
            );

            $('.cerv-modal-content').html(content);
            $loader.hide();
        }
        
        // Encapsulate an ajax GET request
        function _GET(url, successCB, failCB){
            $.ajax({
                type:"GET",
                url: url,
                success:function(resp){
                    successCB(resp)
                },
                error: function(jqXHR, textStatus, error){
                    failCB(jqXHR, textStatus, error);
                }
            });
        }
    });
}( jQuery ) );