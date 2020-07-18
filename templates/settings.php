<div class="container">

    <h1>CERV Settings Page</h1> 

    <?php settings_errors(); ?>

    <form method="POST" action="options.php">

        <?php settings_fields('cerv_settings_group'); ?>

        <?php do_settings_sections('cerv_settings'); ?>

    </form>

</div>