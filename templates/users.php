<?php get_header() ?>

<?php if ( !empty($templateResource) ) : ?>

<style>
    @media only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
        table.cerv-resource-table td:nth-of-type(1):before { content: "User ID"; }
        table.cerv-resource-table td:nth-of-type(2):before { content: "Username"; }
        table.cerv-resource-table td:nth-of-type(3):before { content: "Name"; }
        table.cerv-resource-table td:nth-of-type(4):before { content: "Email"; }
        table.cerv-resource-table td:nth-of-type(5):before { content: "Website"; }
        table.cerv-resource-table td:nth-of-type(6):before { content: "Company"; }
    }
</style>

<div class="cerv-container">
    <h2 class="cerv-resource-title"><?php echo $templateResource['title']?></h2>
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
                <a href="#" class="resource-details-link" data-resource-id="<?php echo $value['id'] ?>">
                    <?php echo $value['id'] ?>
                </a>
            </td>
            <td role="cell">
                <a href="#" class="resource-details-link" data-resource-id="<?php echo $value['id'] ?>">
                    <?php echo $value['username'] ?>
                </a>
            </td>
            <td role="cell">
                <a href="#" class="resource-details-link" data-resource-id="<?php echo $value['id'] ?>">
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