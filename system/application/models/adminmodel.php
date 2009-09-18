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
        
        $sql = 'DESCRIBE `'.$tableName.'`;';
        $query = $this->db->query($sql);
        
        foreach($query->result() as $result) {
            $item = array(
                'name'=>$result->Field,
                'value'=>$result->Default,
                'type'=>$result->Type
            )
            $typeArray = explode('(', str_replace(')', '', $item['type']));            
        }
        
        /*
stdClass Object
(
    [Field] => id
    [Type] => int(11)
    [Null] => NO
    [Key] => PRI
    [Default] => 
    [Extra] => auto_increment
)
stdClass Object
(
    [Field] => name
    [Type] => tinytext
    [Null] => NO
    [Key] => 
    [Default] => 
    [Extra] => 
)
stdClass Object
(
    [Field] => code
    [Type] => varchar(2)
    [Null] => NO
    [Key] => 
    [Default] => 
    [Extra] => 
)
stdClass Object
(
    [Field] => active
    [Type] => tinyint(1)
    [Null] => NO
    [Key] => 
    [Default] => 
    [Extra] => 
)
        */
        
        /*
        $fieldData   = $this->db->field_data($tableName);
        if($id==0) {            
            $tableFields = array();
            $fieldArray  = $this->db->list_fields($tableName);
            foreach($fieldArray as $fieldName) {
                $tableFields[$fieldName] = '';
            }
            $scaffold['todo'] = 'new';
        } else {
            $sql         = 'SELECT * FROM `'.$tableName.'` WHERE `id` = '.$id.';';
            $query       = $this->db->query($sql);
            $tableFields = $query->first_row('array');
            $scaffold['todo'] = 'edit';
        }
        
        $scaffold['table']   = $tableName;
        $scaffold['values']  = $tableFields;        
        
        $types = array();
        foreach($fieldData as $field) {
            $types[$field->name] = array("type"=>$field->type, "default"=>$field->default, "maxLength"=>$field->max_length);
        }
        $scaffold['types'] = $types;
        
        print_r($scaffold);
        */
        /*
        foreach($tableFields as $fieldName) {
            
        }
        */
    }
}
?>