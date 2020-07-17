<?php get_header() ?>

<?php if ( !empty($templateResource) ) : ?>

<div class="cerv-container">
    <?php include_once  plugin_dir_path( __FILE__ ) . 'partials/modal.php'; ?>
    <table class="cerv-resource-table" role="table">
        <thead role="rowgroup">
            <tr role="row">                
                <th role="columnheader">User ID</th>                
                <th role="columnheader">Username</th>                
                <th role="columnheader">Name</th>
                <th role="columnheader">Email</th>                   
                <th role="columnheader">Website</th>
                <th role="columnheader">Company</th>
            </tr>
        </thead>
        <tbody role="rowgroup">
        <?php foreach ($templateResource['data'] as $value) { ?>
            <tr role="row">
            <td role="cell" class="user-id">
                <a href="#" class="user-details-link" data-user-id="<?php echo $value['id'] ?>">
                    <?php echo $value['id'] ?>
                </a>
            </td>
            <td role="cell">
                <a href="#" class="user-details-link" data-user-id="<?php echo $value['id'] ?>">
                    <?php echo $value['username'] ?>
                </a>
            </td>
            <td role="cell">
                <a href="#" class="user-details-link" data-user-id="<?php echo $value['id'] ?>">
                    <?php echo $value['name'] ?>
                </a>
            </td>
            <td role="cell"><?php echo $value['email'] ?></td>            
            <td role="cell"><?php echo $value['website'] ?></td>
            <td role="cell"><?php echo $value['company']['name'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php get_footer();