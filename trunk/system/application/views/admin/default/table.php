<h1><?php echo $title; ?></h1>
<table class="items">
    <tr>
        <?php foreach($tableHeaders as $header) { ?>
        <th><?php echo ucfirst($header); ?></th> 
        <?php } ?>
        <th>Actions</th>
    </tr>
    <?php foreach($tableData->result_array() as $data) { ?>
    <tr>
        <?php foreach($data as $value) { ?>
        <td><?php echo $value; ?></td>
        <?php } ?>
        <td>
            <a href="<?php echo site_url(array('admin', 'manage', 'languages', 'edit', $data['id'])); ?>" class="edit" title="edit">edit</a>
            <a href="<?php echo site_url(array('admin', 'manage', 'languages', 'duplicate', $data['id'])); ?>" class="duplicate" title="duplicate">duplicate</a>
            <a href="<?php echo site_url(array('admin', 'manage', 'languages', 'delete', $data['id'])); ?>" class="delete" title="delete">delete</a>
        </td>
    </tr>
    <?php } ?>
</table>