<?php get_header() ?>

<?php if ( !empty($resource) ) : ?>
<style>
    /* RESOURCE TABLE */

    div.cerv-container{
        max-width:100%;
        width: 1200px;
        margin: 0 auto;
        padding: 1.5em;
    }

    table.cerv-resource-table{
        font-size: 1em;
    }

    table.cerv-resource-table thead tr{
        background: #333;
        color: #fff;
    }

    table.cerv-resource-table td{
        padding: 10px;
    }

    table.cerv-resource-table td a{
        position: relative;
        left: 0;
        top: 0;        
        height: 100%;
        width: 100%;
        display: block;
    }

    table.cerv-resource-table tr:nth-child(even){
        background: #aaa;
    }

    table.cerv-resource-table td.user-id{
        text-align: center;
    }

	@media only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
        
        table.cerv-resource-table, 
        table.cerv-resource-table thead, 
        table.cerv-resource-table tbody, 
        table.cerv-resource-table th, 
        table.cerv-resource-table td, 
        table.cerv-resource-table tr {
            display: block;
        }

        table.cerv-resource-table thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        table.cerv-resource-table tr {
            margin: 0 0 1rem 0;
        }
        
        table.cerv-resource-table tr:nth-child(odd) {
            background: #ccc;
        }
    
        table.cerv-resource-table td {
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 45%;
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        table.cerv-resource-table td:before {
            position: absolute;
            top: 0;
            left: 6px;
            width: 35%;
            padding-right: 10px;
            white-space: nowrap;
            padding: 10px;
            background: #333;
            color: #fff;
        }

        table.cerv-resource-table td.user-id{
            text-align: left;
        }

        table.cerv-resource-table thead tr{
            background: none;
            color: #000;
        }

        table.cerv-resource-table tr:nth-child(even){
            background: none;
        }

        table.cerv-resource-table td:nth-of-type(1):before { content: "User ID"; }
        table.cerv-resource-table td:nth-of-type(2):before { content: "Username"; }
        table.cerv-resource-table td:nth-of-type(3):before { content: "Name"; }
        table.cerv-resource-table td:nth-of-type(4):before { content: "Email"; }
        table.cerv-resource-table td:nth-of-type(5):before { content: "Website"; }
        table.cerv-resource-table td:nth-of-type(6):before { content: "Company"; }
    }
</style>

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
        <?php foreach ($resource['data'] as $value) { ?>
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