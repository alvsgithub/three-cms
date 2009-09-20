<div id="content">
	<div id="innerContent">
        <h1><?php echo $title; ?></h1>
        <form method="post" action="<?php echo site_url(array('admin', 'scaffold')); ?>">
            <table class="scaffold">
                <?php
                    $hiddenFields = array();
                    foreach($items as $item) {
                        if($item['input_type']!='hidden') {
                            if($item['input_type']=='checkbox') {
                                $checked = $item['value']==1 ? ' checked="checked" ' : '';
                            } else {
                                $checked = '';
                            }
                            echo '
                                <tr>
                                    <th>'.ucfirst($item['name']).':</th>
                                    <td><input type="'.$item['input_type'].'" name="'.$item['name'].'" value="'.$item['value'].'" '.$checked.' /></td>
                                </tr>
                            ';
                        } else {
                            array_push($hiddenFields, array('name'=>$item['name'], 'value'=>$item['value']));
                        }
                    }
                ?>
                <tr>
                    <th>&nbsp;</th>
                    <td><?php
                // Show the hidden fields:
                foreach($hiddenFields as $hidden) {
                    echo '
                        <input type="hidden" name="'.$hidden['name'].'" value="'.$hidden['value'].'" />
                    ';
                }
                    ?>
                        <input type="hidden" name="three_table" value="<?php echo $table; ?>" />
                        <input type="hidden" name="three_action" value="<?php echo $action; ?>" />
                        <input type="submit" value="<?php echo $lang->line('button_save'); ?>" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>