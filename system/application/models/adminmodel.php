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
     * @param   $return     string  The name of the item to return to
     */
    function createScaffoldTable($tableName, $fields, $return='', $id=0)
    {
        $scaffold            = array();
        $showFields          = explode(',', $fields);
        $scaffold['table']   = $tableName;
        $scaffold['id']      = $id;
        $scaffold['return']  = $return;
        
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
                case 'enum' :
                    {
                        $options = explode(',', str_replace('\'', '', $item['type_length']));
                        $item['type_length'] = count($options);
                        $item['options'] = $options;
                        $inputType = 'select';
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
    
    /**
     * Default scaffolding save-function
     */
    function scaffoldSave()
    {
        // See if the table and the action are set
        $tableName = $this->input->post('three_table');
        $action    = $this->input->post('three_action');
        $return    = $this->input->post('three_return');
        // Only execute of tableName and action are set:
        if($tableName!=false && $action!=false && $return!=false) {
            // Save the data:
            $sql   = 'DESCRIBE `'.$tableName.'`;';
            $query = $this->db->query($sql);
            // Create items-array:
            $items = array();
            foreach($query->result() as $result) {
                // If the name of the field is 'id' then don't put it in the items-array, since it is a primary key:
                if($result->Field!='id') {
                    $item = array(
                        'name'=>$result->Field,
                        'value'=>$result->Default,
                        'type'=>$result->Type
                    );
                    $typeArray = explode('(', str_replace(')', '', $item['type']));
                    $item['type']        = $typeArray[0];
                    $item['type_length'] = isset($typeArray[1]) ? $typeArray[1] : 0;
                    // Set the values, according to the types:
                    switch($item['type']) {
                        case 'int' :
                        case 'tinytext' :
                        case 'varchar' :
                            {
                                if($this->input->post($item['name'])!=false) {
                                    $item['value'] = $this->input->post($item['name']);
                                }
                                break;
                            }
                        case 'tinyint' :
                            {
                                if($item['type_length']==1) {
                                    // Bool
                                    $item['value'] = isset($_POST[$item['name']]) ? 1 : 0;
                                } else {
                                    if($this->input->post($item['name'])!=false) {
                                        $item['value'] = $this->input->post($item['name']);
                                    }
                                }
                                break;
                            }
                        default :
                            {
                                if($this->input->post($item['name'])!=false) {
                                    $item['value'] = $this->input->post($item['name']);
                                }
                                break;
                            }
                    }
                    // Add the item to the array with items
                    array_push($items, $item);
                }
            }
            // See if this is an add- or a edit-action
            if($action=='add') {
                // Insert new record in the database:
                $sql = 'INSERT INTO `'.$tableName.'` (';
                $first = true;
                foreach($items as $item) {
                    if($item['value']!=='') {
                        if(!$first) {
                            $sql .= ', ';
                        }
                        $sql .= '`'.$item['name'].'`';
                        $first = false;
                    }
                }
                $sql.= ') VALUES (';
                $first = true;
                foreach($items as $item) {
                    if($item['value']!=='') {
                        if(!$first) {
                            $sql .= ', ';
                        }
                        $sql .= '\''.$item['value'].'\'';
                        $first = false;
                    }
                }
                $sql.= ');';
            } elseif($action=='edit') {
                // Update record:
                $id  = $this->input->post('id');
                if($id!=false) {
                    $sql = 'UPDATE `'.$tableName.'` SET ';
                    $first = true;
                    foreach($items as $item) {
                        // Cannot use empty() because '0' can also be a value
                        if($item['value']!=='') {
                            if(!$first) {
                                $sql .= ', ';
                            }
                            $sql .= '`'.$item['name'].'`=\''.$item['value'].'\'';
                            $first = false;
                        }
                    }                    
                    $sql.= ' WHERE `id` = '.$id.';';
                } else {
                    // TODO Show error if no ID is sent
                    
                }
            } else {
                // TODO Show error if action is not add or edit
                
            }            
            $this->db->query($sql);
            // Redirect to the correct page:
            redirect(site_url(array('admin', 'manage', $return)));
        } else {
            // TODO Show error if no tablename, action or return value are set
            
        }
    }
    
    function getLocaleTable($id=0)
    {
        $sql     = 'SELECT `id`,`name` FROM `languages`;';
        $query   = $this->db->query($sql);
        $locales = array();
        foreach($query->result() as $result) {
            $value = '';
            if($id!=0) {
                $sql = 'SELECT `value` FROM `locales_values` WHERE `id_language`='.$result->id.' AND `id_locale`='.$id.';';
                $valueQuery = $this->db->query($sql);
                $value      = $this->result()->value;
            }
            array_push($locales, array(
                'id'=>$result->id,
                'name'=>$result->name,
                'value'=>$value,
                'input_name'=>'language_'.$result->id
            ));
        }
        $return = array(
            'linkTable'=>'locales_values',
            'items'=>$locales
        );
        return $return;
    }
    
    /**
     * Get a language
     * @param $id   int The ID of the language
     * @return array
     */
    function getLanguage($id) {
        // If ID is empty or 0, return an empty result set:
        if($id==false || $id==0) {
            return array(
                'name'=>'',
                'code'=>'',
                'active'=>'',
                'id'=>0
            );
        }
        $this->db->where('id', $id);
        $query = $this->db->get('languages');
        $array = $query->result_array();
        return $array[0];
    }
    
    /**
     * Save a language by using the post-vars
     * @param   $data   An array holding the data
     */
    function saveLanguage($data)
    {
        if($data['id']==0) {
            // Insert
            $this->db->insert('languages', $data);
        } else {
            // Update
            $this->db->where('id', $data['id']);
            unset($data['id']);
            $this->db->update('languages', $data);
        }
    }
    
    /**
     * Delete a language
     * @param   $id int The ID of the language to delete
     */
    function deleteLanguage($id)
    {
        $this->db->delete('languages', array('id'=>$id));
        $this->db->delete('values', array('id_language'=>$id));
        $this->db->delete('locales_values', array('id_language'=>$id));
    }
    
    /**
     * Duplicate a language
     * @param   $id int The ID of the language to duplicate
     */
    function duplicateLanguage($id)
    {
        // TODO
    }
    
    /**
     * Get a language
     * @param $id   int The ID of the language
     * @return array
     */
    function getOption($id) {
        // If ID is empty or 0, return an empty result set:
        if($id==false || $id==0) {
            return array(
                'name'=>'',
                'type'=>'',
                'default_value'=>'',
                'multilanguage'=>'',
                'id'=>0
            );
        }
        $this->db->where('id', $id);
        $query = $this->db->get('options');
        $array = $query->result_array();
        return $array[0];
    }
    
    /**
     * Save a language by using the post-vars
     * @param   $data   An array holding the data
     */
    function saveOption($data)
    {
        if($data['id']==0) {
            // Insert
            $this->db->insert('options', $data);
        } else {
            // Update
            $this->db->where('id', $data['id']);
            unset($data['id']);
            $this->db->update('options', $data);
        }
    }
    
    /**
     * Delete a language
     * @param   $id int The ID of the language to delete
     */
    function deleteOption($id)
    {
        $this->db->delete('options', array('id'=>$id));
        $this->db->delete('values', array('id_option'=>$id));
        $this->db->delete('dataobject_options', array('id_option'=>$id));
    }
    
    /**
     * Duplicate a language
     * @param   $id int The ID of the language to duplicate
     */
    function duplicateOption($id)
    {
        // TODO
    }
}
?>