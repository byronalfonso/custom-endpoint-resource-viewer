<?php if ( !empty($nonceActionKey) ) : ?>
<div class="container">

    <h1>CERV Settings Page</h1>

    <?php settings_errors(); ?>

    <form method="POST" action="options.php">

        <?php wp_nonce_field( $nonceActionKey, 'cerv_settings_form_nonce' ); ?>

        <?php settings_fields('cerv_settings_group'); ?>

        <?php do_settings_sections('cerv_settings'); ?>

        <?php submit_button(); ?>

    </form>

</div>

<?php endif; ?>