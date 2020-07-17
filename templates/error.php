<?php get_header() ?>

<?php if ( !empty($templateResource) ) : ?>

<div class="cerv-container">
    <div class="cerv-error">
        <h1>Oops! Unable to load resources.</h1>
        <p>Please make sure that you are not disconnected from the internet.</p>
        <p>You may also try reloading the page. If issues persists, please contact your administrator or try again later.</p>
    </div>
</div>
<?php endif; ?>

<?php get_footer();