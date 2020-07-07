<?php get_header() ?>

<?php if ( !empty($resource) ) : ?>
<style>
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

    table.cerv-resource-table tr:nth-child(even){
        background: #aaa;
    }

    table.cerv-resource-table td.user-id{
        text-align: center;
    }

	@media only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
        
        table, thead, tbody, th, td, tr {
            display: block;
        }

        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            margin: 0 0 1rem 0;
        }
        
        tr:nth-child(odd) {
            background: #ccc;
        }
    
        td {
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 45%;
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        td:before {
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

        td:nth-of-type(1):before { content: "User ID"; }
        td:nth-of-type(2):before { content: "Username"; }
        td:nth-of-type(3):before { content: "Name"; }
        td:nth-of-type(4):before { content: "Email"; }
        td:nth-of-type(5):before { content: "Website"; }
        td:nth-of-type(6):before { content: "Company"; }
    }
</style>

<div class="cerv-container">
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
            <td role="cell" class="user-id"><?php echo $value['id'] ?></td>
            <td role="cell"><?php echo $value['username'] ?></td>            
            <td role="cell"><?php echo $value['name'] ?></td>
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