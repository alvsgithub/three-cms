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
    /*
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
    */
    /**
     * Default scaffolding save-function
     */
    /*
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
    */
    
    /**
     * Generic getData function
     * @param   $tableName  string  The name of the table to retrieve the data from
     * @param   $id         int     The ID of the data, or 0 for an empty dataset
     * @return  array               An array, holding the data
     */
    function getData($tableName, $id=0)
    {
        if($id==false || $id==0) {
            $fieldArray = $this->db->list_fields($tableName);
            $fields = array();
            foreach($fieldArray as $fieldName) {
                $fields[$fieldName] = '';
            }
            return $fields;
        } else {
            $this->db->where('id', $id);
            $query = $this->db->get($tableName);
            $array = $query->result_array();
            return $array[0];
        }
    }
    
    /**
     * Generic saveData function
     * @param   $tableName  string  The name of the table to save the data to
     * @param   $data       array   An array holding the data to save
     * @param   $id         int     In case of an update, the ID of the data, otherwise 0
     * @return  int                 The ID of the saved data.
     */
    function saveData($tableName, $data, $id=0)
    {
        unset($data['id']);
        if($id==0) {
            // Insert
            $this->db->insert($tableName, $data);
            $id = $this->db->insert_id();
        } else {
            // Update            
            $this->db->where('id', $id);
            $this->db->update($tableName, $data);
        }
        return $id;
    }
    
    /**
     * Generic deleteData function
     * @param   $tableInformation   array   An associated array with 'tableName'=>'IDFieldName'
     * @param   $id                 int     The ID of the data to delete
     */
    function deleteData($tableInformation, $id)
    {
        foreach($tableInformation as $tableName=>$idField) {
            $this->db->delete($tableName, array($idField=>$id));
        }
    }
    
    /**
     * Get a language
     * @param $id   int The ID of the language
     * @return array
     */
    /*
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
    */
    
    /**
     * Save a language by using the post-vars
     * @param   $data   An array holding the data
     * @return  int     The ID of the inserted value;
     */
    /*
    function saveLanguage($data)
    {
        if($data['id']==0) {
            // Insert
            unset($data['id']);
            $this->db->insert('languages', $data);
            $id = $this->db->insert_id();
        } else {
            // Update
            $id = $data['id'];
            $this->db->where('id', $id);
            unset($data['id']);
            $this->db->update('languages', $data);
        }
        return $id;
    }
    */
    
    /**
     * Delete a language
     * @param   $id int The ID of the language to delete
     */
    /*
    function deleteLanguage($id)
    {
        $this->db->delete('languages', array('id'=>$id));
        $this->db->delete('values', array('id_language'=>$id));
        $this->db->delete('locales_values', array('id_language'=>$id));
    }
    */
    
    /**
     * Duplicate a language
     * @param   $id int The ID of the language to duplicate
     */
    function duplicateLanguage($id)
    {
        // TODO
    }
    
    /**
     * Get an option
     * @param $id   int The ID of the option
     * @return array
     */
    /*
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
    */
    
    /**
     * Save an option by using the post-vars
     * @param   $data   An array holding the data
     * @return  int     The ID of the inserted value;
     */
    /*
    function saveOption($data)
    {
        if($data['id']==0) {
            // Insert
            unset($data['id']);
            $this->db->insert('options', $data);
            $id = $this->db->insert_id();
        } else {
            // Update
            $id = $data['id'];
            $this->db->where('id', $id);
            unset($data['id']);
            $this->db->update('options', $data);
        }
        return $id;
    }
    */
    
    /**
     * Delete an option
     * @param   $id int The ID of the option to delete
     */
    /*
    function deleteOption($id)
    {
        $this->db->delete('options', array('id'=>$id));
        $this->db->delete('values', array('id_option'=>$id));
        $this->db->delete('dataobject_options', array('id_option'=>$id));
    }
    */
    
    /**
     * Duplicate an option
     * @param   $id int The ID of the option to duplicate
     */
    function duplicateOption($id)
    {
        // TODO
    }
    
    /**
     * Get a locale
     * @param   $id int The ID of the locale
     * @return  array   An array with data
     */
    /*
    function getLocale($id) {
        // If ID is empty or 0, return an empty result set:
        if($id==false || $id==0) {
            return array(
                'name'=>'',
                'id'=>0
            );
        }
        $this->db->where('id', $id);
        $query = $this->db->get('locales');
        $array = $query->result_array();
        return $array[0];
    }
    */
    
    /**
     * Save a locale by using the post-vars
     * @param   $data   An array holding the data
     * @return  int     The ID of the inserted value;
     */
    /*
    function saveLocale($data)
    {
        if($data['id']==0) {
            // Insert
            unset($data['id']);
            $this->db->insert('locales', $data);
            $id = $this->db->insert_id();            
        } else {
            // Update
            $id = $data['id'];
            $this->db->where('id', $id);
            unset($data['id']);
            $this->db->update('locales', $data);
        }
        return $id;
    }
    */
    
    /**
     * Delete a locale
     * @param   $id int The ID of the locale to delete
     */
    /*
    function deleteLocale($id)
    {
        $this->db->delete('locales', array('id'=>$id));
        $this->db->delete('locales_values', array('id_locale'=>$id));
    }
    */
    
    /**
     * Duplicate a locale
     * @param   $id int The ID of the locale to duplicate
     */
    function duplicateLocale($id)
    {
        // TODO
    }
    
    /**
     * Get an array holding all the locale values (for each language)
     * @param   $id int The ID of the locale
     * @return  array   An array holding all the locale values
     */
    function getLocaleValues($id=0)
    {
        $query   = $this->db->get('languages');
        $locales = array();
        foreach($query->result() as $result) {
            $value = '';
            if($id!=0) {
                // $sql = 'SELECT `value` FROM `locales_values` WHERE `id_language`='.$result->id.' AND `id_locale`='.$id.';';
                $this->db->select('value');
                $this->db->where('id_language', $result->id);
                $this->db->where('id_locale', $id);
                $valueQuery = $this->db->get('locales_values');
                if($valueQuery->num_rows!=0) {                    
                    $value = $valueQuery->row()->value;
                } else {
                    $value = '';
                }
            }
            array_push($locales, array(
                'id'=>$result->id,
                'name'=>$result->name,
                'value'=>$value
            ));
        }
        return $locales;
    }
    
    /**
     * Save locale values
     * @param   $id         int     The ID of the locale
     * @param   $locales    array   An Array holding the locale values
     */
    function saveLocaleValues($id, $locales)
    {
        // First delete the current values:
        $this->db->where('id_locale', $id);
        $this->db->delete('locales_values');
        // Then add the new values:
        foreach($locales as $locale)
        {
            $this->db->insert('locales_values', array(
                'id_locale'=>$id,
                'id_language'=>$locale['id'],
                'value'=>$locale['value']
            ));
        }
    }
    
    /**
     * Duplicate a template
     * @param   $id int The ID of the template to duplicate
     */
    function duplicateTemplate($id)
    {
        // TODO
    }
    
    /**
     * Get a list of all available data objects
     * @return  array   An array with all the available data objects
     */
    function getDataObjects()
    {
        $dataObjects = array();
        $query = $this->db->get('dataobjects');
        foreach($query->result() as $result) {
            $dataObject = array(
                'id'=>$result->id,
                'name'=>$result->name
            );
            array_push($dataObjects, $dataObject);
        }
        return $dataObjects;
    }
    
    /**
     * Get the options that are linked to this dataobject
     * @param   $id int The ID of the data object
     * @return  array   An array with all the options linked to this dataobject
     */
    function getDataObjectOptions($id)
    {
        $options = array();
        $this->db->where('id_dataobject', $id);
        $this->db->select('id_option,name');
        $this->db->order_by('order');
        $this->db->join('options', 'options.id = dataobjects_options.id_option');
        $query = $this->db->get('dataobjects_options');
        foreach($query->result() as $result) {
            $option = array(
                'id'=>$result->id_option,
                'name'=>$result->name
            );
            array_push($options, $option);
        }        
        return $options;
    }
    
    /**
     * Save the data object options
     * @param   $options    array   An array holding the ID's of the options
     * @param   $id         int     the ID of the dataobject where the options belong to
     */
    function saveDataObjectOptions($options, $id)
    {
        // First, delete all the links that are already made:
        $this->db->where('id_dataobject', $id);
        $this->db->delete('dataobjects_options');
        // Then store the data:
        $order = 0;
        foreach($options as $id_option) {
            $data = array(
                'id_option'=>$id_option,
                'id_dataobject'=>$id,
                'order'=>$order
            );
            $this->db->insert('dataobjects_options', $data);
            $order++;
        }
    }
    
    /**
     * Get a list of all available options
     * @return  array   An array with all the available options
     */
    function getOptions()
    {
        $options = array();
        $query = $this->db->get('options');
        foreach($query->result() as $result) {
            $option = array(
                'id'=>$result->id,
                'name'=>$result->name
            );
            array_push($options, $option);
        }
        return $options;
    }
    
    /**
     * Duplicate a data object
     * @param   $id int The ID of the dataobject to duplicate
     */
    function duplicateDataObject($id)
    {
        // TODO
    }
    
    /**
     * Get information about the content object
     * @param   $id int The ID of the content object
     * @return  array   An array with information
     */
    function getContent($id)
    {
        $this->db->select('
            content.id     as id,
            content.name   as name,
            content.alias  as alias,
            templates.name as templateName
        ');
        $this->db->where('content.id', $id);
        $this->db->join('templates', 'content.id_template = templates.id');
        $query = $this->db->get('content');
        
        $result = $query->result_array();
        return $result[0];
    }
}
?>