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
        // $sql = 'SELECT `id`,`name` FROM `content` WHERE `id_content` = '.$startID.';';
        $this->db->where('id_content', $startID);
        $this->db->select('id,name');
        $query = $this->db->get('content');
        // $query = $this->db->query($sql);
        foreach($query->result() as $result) {
            // $sql = 'SELECT COUNT(*) AS `numChildren` FROM `content` WHERE `id_content` = '.$result->id.';';
            $this->db->where('id_content', $result->id);
            $this->db->from('content');
            $numChildren = $this->db->count_all_results();
            // $innerQuery = $this->db->query($sql);
            // $innerResult = $innerQuery->result();
            $item = array(
                'id'=>$result->id,
                'name'=>$result->name,
                // 'numChildren'=>$innerResult[0]->numChildren
                'numChildren'=>$numChildren
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
     * Duplicate a language
     * @param   $id int The ID of the language to duplicate
     */
    function duplicateLanguage($id)
    {
        // TODO
        
    }
    
    /**
     * Duplicate an option
     * @param   $id int The ID of the option to duplicate
     */
    function duplicateOption($id)
    {
        // TODO
        
    }
    
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
     * Get a list of templates and if these are allowed to be a child of the current template
     * @param   $id int The ID of the current template
     * @return  array   A 2-dimensional array with the templates: [[id=int, allowed=bool], ...]
     */
    function getChildTemplates($id=0)
    {
        $templates = array();
        $this->db->select('id,name');
        $query = $this->db->get('templates');
        foreach($query->result() as $result) {
            if($id!=0 && $id!=false) {
                $this->db->where('id_template', $id);
                $this->db->where('id_child_template', $result->id);
                $this->db->from('templates_allowed_children');
                $allowed = $this->db->count_all_results()==1;
            } else {
                $allowed = false;
            }
            $item = array('id'=>$result->id, 'name'=>$result->name, 'allowed'=>$allowed);
            array_push($templates, $item);
        }
        return $templates;
    }
    
    /**
     * Set the templates which are allowed to be a child of the current template
     * @param   $id         int     The ID of the template
     * @param   $templates  array   A 2-dimensional array with the templates: [[id=int, allowed=bool], ...]
     */
    function saveChildTemplates($id, $templates)
    {
        // First delete all links
        $this->db->delete('templates_allowed_children', array('id_template'=>$id));
        // Then add new ones:
        foreach($templates as $item) {
            if($item['allowed']) {
                $this->db->insert('templates_allowed_children', array('id_template'=>$id, 'id_child_template'=>$item['id']));
            }
        }
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
    
    /**
     * Get the content data
     * @param   $id int The ID of the content to retrieve. Give 0 or false to get a empty array
     * @return  array   An array holding all the information of this content
     */
    function getContentData($id)
    {
        if($id!=0 && $id!=false) {
            $this->db->where('id', $id);
            $query = $this->db->get('content');
            $resultArray = $query->result_array();
            $contentData = $resultArray[0];
        } else {
            $contentData = $this->db->list_fields('content');
        }
        
        // Get the languages:
        $languages = array();
        $query = $this->db->get('languages');
        foreach($query->result_array() as $resultArray) {
            array_push($languages, $resultArray);
        }
        $contentData['languages'] = $languages;
        
        // Get the options and their values associated with this content:
        $content = array();
        /*
        $this->db->select('id_option');
        $this->db->join('templates', 'content.id_template = templates.id');
        $this->db->join('dataobjects_options', 'dataobjects_options.id_dataobject = templates.id_dataobject');
        $query = $this->db->get('dataobjects_options');
        */
        
        // TODO: Make this query Active Record Style:
        $sql = 'SELECT A.`id_option`, C.`name`, C.`type`, C.`default_value`, C.`multilanguage` FROM
            `dataobjects_options` A,
            `templates` B,
            `options` C
                WHERE
            B.`id` = '.$contentData['id_template'].' AND
            A.`id_dataobject` = B.`id_dataobject` AND
            C.`id` = A.`id_option`
        ';
        $query = $this->db->query($sql);
        
        foreach($query->result_array() as $result) {
            // Get the values by this option. This is done with the multilanguage aspect:
            /*
            $this->db->select('id_language,value');
            $this->db->where('id_option', $result['id_option']);
            $this->db->where('id_content', $id);
            $valueQuery = $this->db->get('values');
            $valueArray = $valueQuery->result_array();
            $result['value'] = $valueArray;
            */
            
            $values = array();
            foreach($languages as $language) {
                $this->db->select('value');
                $this->db->where('id_option', $result['id_option']);
                $this->db->where('id_content', $id);
                $this->db->where('id_language', $language['id']);
                $valueQuery = $this->db->get('values');
                $valueArray = $valueQuery->result_array();
                $value      = isset($valueArray[0]) ? $valueArray[0]['value'] : '';                
                array_push($values, array('id_language'=>$language['id'], 'value'=>$value));                
            }
            $result['value'] = $values;
            
            array_push($content, $result);
        }
        // Make one package:
        $contentData['content'] = $content;
        return $contentData;
    }
    
    
    
    function saveContentData($id, $contentData)
    {
        
    }
    
}
?>