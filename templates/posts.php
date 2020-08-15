<?php get_header() ?>

<?php if ( !empty($templateResource) ) : ?>

<style>
    @media only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
        table.cerv-resource-table td:nth-of-type(1):before { content: "Post ID"; }
        table.cerv-resource-table td:nth-of-type(2):before { content: "Title"; }
    }
</style>

<div class="cerv-container">
    <h2 class="cerv-resource-title"><?php echo $templateResource['title']?></h2>
    <?php include_once  plugin_dir_path( __FILE__ ) . 'partials/modal.php'; ?>
    <table class="cerv-resource-table" role="table">
        <thead role="rowgroup">
            <tr role="row">
                <th role="columnheader">Post ID</th>
                <th role="columnheader">Title</th>
            </tr>
        </thead>
        <tbody role="rowgroup">
        <?php foreach ($templateResource['data'] as $value) { ?>
            <tr role="row">
            <td role="cell" class="user-id">
                <a href="#" class="resource-details-link" data-resource-id="<?php echo $value['id'] ?>">
                    <?php echo $value['id'] ?>
                </a>
            </td>
            <td role="cell">
                <a href="#" class="resource-details-link" data-resource-id="<?php echo $value['id'] ?>">
                    <?php echo ucwords($value['title']) ?>
                </a>
            </td>            
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php get_footer();