<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
        <p class="description"><?php echo $description; ?></p>
        <table class="items">
            <tr>
                <?php foreach($tableHeaders as $header) { ?>
                <th><?php echo ucfirst($header); ?></th> 
                <?php } ?>
                <th><?php echo $lang->line('default_actions'); ?></th>
            </tr>
            <?php foreach($tableData->result_array() as $data) { ?>
            <tr>
                <?php foreach($data as $value) { ?>
                <td><?php echo $value; ?></td>
                <?php } ?>
                <td>
                    <?php
                        $modify    = $lang->line('action_modify');
                        $delete    = $lang->line('action_delete');
                        $duplicate = $lang->line('action_duplicate');
                        echo '
                            <a href="'.site_url(array('admin', 'scaffold', $action, 'edit', $data['id'])).'" class="edit" title="'.$modify.'">'.$modify.'</a>
                            <a href="'.site_url(array('admin', 'duplicate', $action, $data['id'])).'" class="duplicate" title="'.$duplicate.'">'.$duplicate.'</a>
                            <a href="'.site_url(array('admin', 'delete', $action, $data['id'])).'" class="delete" title="'.$delete.'">'.$delete.'</a>
                        ';
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="<?php echo site_url(array('admin', 'scaffold', $action, 'add')); ?>" class="add" title="<?php echo $lang->line('action_add'); ?>"><?php echo $button_text; ?></a>
    </div>
</div>