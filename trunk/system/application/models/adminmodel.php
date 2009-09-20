<?php
class AdminModel extends Model
{
    function AdminModel()
    {
        parent::Model();
    }
    
    /**
     * Get the tree information, given from a certain start-ID
     * @param $startID  int The ID of the root of the tree
     * @return  array   An array holding the information of the tree
     */
    function getTree($startID=0)
    {
        $tree  = array();
        /*
        $sql   = 'SELECT A.`id`, A.`name`, COUNT(B.`id`) AS `numChildren` FROM
            `content` A,
            `content` B
                WHERE
            A.`id_content` = '.$startID.' AND
            B.`id_content` = A.`id`;
        ';
        */
        $sql = 'SELECT `id`,`name` FROM `content` WHERE `id_content` = '.$startID.';';        
        $query = $this->db->query($sql);
        foreach($query->result() as $result) {
            $sql = 'SELECT COUNT(*) AS `numChildren` FROM `content` WHERE `id_content` = '.$result->id.';';
            $innerQuery = $this->db->query($sql);
            $innerResult = $innerQuery->result();
            $item = array(
                'id'=>$result->id,
                'name'=>$result->name,
                'numChildren'=>$innerResult[0]->numChildren
            );
            array_push($tree, $item);
        }
        return $tree;
    }
    
    /**
     * Get the table data
     * @param   $tableName  string  The name of the table
     * @param   $fields     string  The values to retrieve, comma-seperated
     * @return  query   The Query-object
     */
    function getTableData($tableName, $fields)
    {
        $this->db->select($fields);
        $query = $this->db->get($tableName);
        return $query;
    }
    
    /**
     * Create a scaffold table
     * @param   $tableName  string  The name of the table
     * @param   $fields     string  The values to retrieve, comma-seperated
     * @param   $id         int     The ID of the item to retrieve
     */
    function createScaffoldTable($tableName, $fields, $id=0)
    {
        $scaffold            = array();
        $showFields          = explode(',', $fields);
        $scaffold['table']   = $tableName;
        $scaffold['id']      = $id;
        
        $sql = 'DESCRIBE `'.$tableName.'`;';
        $query = $this->db->query($sql);
        
        if($id!=0) {
            $sql = 'SELECT * FROM `'.$tableName.'` WHERE `id` = '.$id;
            $resultQuery = $this->db->query($sql);
            $values = $resultQuery->result_array();
            $scaffold['action'] = 'edit';
        } else {
            $values = array(array());
            $scaffold['action'] = 'add';
        }        
        $items = array();
        
        foreach($query->result() as $result) {
            $item = array(
                'name'=>$result->Field,
                'value'=>$result->Default,
                'type'=>$result->Type
            );
            if(array_key_exists($item['name'], $values[0])) {
                $item['value'] = $values[0][$item['name']];                
            }
            $typeArray = explode('(', str_replace(')', '', $item['type']));
            $item['type']        = $typeArray[0];
            $item['type_length'] = isset($typeArray[1]) ? $typeArray[1] : 0;
            switch($item['type']) {
                case 'int' :
                case 'tinytext' :
                case 'varchar' :
                    {
                        $inputType = 'text';
                        break;
                    }
                case 'tinyint' :
                    {
                        if($item['type_length']==1) {
                            // Bool
                            $inputType = 'checkbox';
                        } else {
                            $inputType = 'text'; 
                        }
                        break;
                    }
                default :
                    {
                        $inputType = 'text';
                        break;
                    }
            }
            if(!in_array($item['name'], $showFields)) {
                $inputType = 'hidden';
            }
            $item['input_type'] = $inputType;
            array_push($items, $item);
        }
        
        $scaffold['items'] = $items;        
        return($scaffold);
    }
    
    function scaffoldSave()
    {
        // See if the table and the action are set
        $tableName = $this->input->post('three_table');
        $action    = $this->input->post('three_action');
    }
}
?>