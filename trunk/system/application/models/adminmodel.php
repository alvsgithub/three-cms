<?php

/**
 *  AdminModel
 *  ---------------------------------------------------------------------------
 *  The AdminModel is used to store all the get- and storefunctions used by the
 *  admin-part of the CMS. All actions that load, manipulate or store data are
 *  located in this class.
 *  ---------------------------------------------------------------------------
 *  Author:     Giel Berkers
 *  E-mail:     giel.berkers@gmail.com
 *  Revision:   1
 *  ---------------------------------------------------------------------------
 *  Changelog:
 *
 *
 */

// TODO: Add an order-index to the content
// TODO: Changing of templates (what happens with the options?)
// TODO: Changing of the parents (move)

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
        $this->db->where('id_content', $startID);
        $this->db->select('id,name');
        $query = $this->db->get('content');
        foreach($query->result() as $result) {
            $this->db->where('id_content', $result->id);
            $this->db->from('content');
            $numChildren = $this->db->count_all_results();
            $item = array(
                'id'=>$result->id,
                'name'=>$result->name,
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
     * Duplicate a template
     * @param   $id int The ID of the template to duplicate
     */
    function duplicateTemplate($id)
    {
        // TODO
        
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
     * Duplicate an option
     * @param   $id int The ID of the option to duplicate
     */
    function duplicateOption($id)
    {
        // TODO
        
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
            content.id          as id,
            content.name        as name,
            content.alias       as alias,
            content.id_template as id_template,
            templates.name      as templateName
        ');
        $this->db->where('content.id', $id);
        $this->db->join('templates', 'content.id_template = templates.id');
        $query = $this->db->get('content');
        
        $result = $query->result_array();
        return $result[0];
    }
    
    /**
     * Get the content data
     * @param   $id         int     The ID of the content to retrieve. Give 0 or false to get a empty array
     * @param   $idParent   int     The ID of the parent document. Only needed if id=0
     * @param   $idTemplate int     The ID of the template to use. Only needed if id=0
     * @return  array               An array holding all the information of this content
     */
    function getContentData($id, $idParent=null, $idTemplate=null)
    {
        if($id!=0 && $id!=false) {
            /*
            $this->db->where('id', $id);
            $query = $this->db->get('content');
            $resultArray = $query->result_array();
            $contentData = $resultArray[0];
            */
            $contentData = $this->getData('content', $id);
        } else {
            if($idTemplate!=null && $idParent!=null) {
                $contentData = $this->getData('content');
                $contentData['id_template'] = $idTemplate;
                $contentData['id_content']  = $idParent;
            } else {
                show_error('Error: No parent and/or template supplied when creating new content.<br /><br />AdminModel :: getContentData()');
                return false;
            }
        }
        
        // Get the languages:
        $languages = $this->getLanguages();
        $contentData['languages'] = $languages;
        
        // Get the options and their values associated with this content:
        $content = array();
        
        // TODO: Make this query Active Record Style:
        $sql = 'SELECT A.`id_option`, C.`name`, C.`type`, C.`default_value`, C.`multilanguage` FROM
            `dataobjects_options` A,
            `templates` B,
            `options` C
                WHERE
            B.`id` = '.$contentData['id_template'].' AND
            A.`id_dataobject` = B.`id_dataobject` AND
            C.`id` = A.`id_option`
                ORDER BY A.`order`
        ';
        $query = $this->db->query($sql);
        
        foreach($query->result_array() as $result) {
            // Get the values by this option. This is done with the multilanguage aspect:
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
    
    
    /**
     * Save the contentData.
     * @param   $id             int     The ID of the content to save. If this is set to 0, new content will be added
     * @param   $contentData    array   A ContentData array
     * @return  int The ID of the content
     */
    function saveContentData($idContent, $contentData)
    {
        // TODO: Check if the alias already exists. If so, create a new alias with an increasing number.
        // TODO: Auto-check / auto-generate alias.
        // TODO: Check if the id of the parent is not the same as this contents own ID.
        // TODO: Check if the id of the parent is not a child or deeper of this contents own ID.
        // TODO: Check if the id of the parent is not an infinite loop of some sort.
        // TODO: Also do these checks AJAX-wise when they get changed in the editing screen.
        $content = array(
            'id_content'=>$contentData['id_content'],
            'id_template'=>$contentData['id_template'],
            'name'=>$contentData['name'],
            'alias'=>$contentData['alias']
        );
        // Insert/update base content information:
        if($idContent==0) {
            $this->db->insert('content', $content);
            $idContent = $this->db->insert_id();
        } else {
            $this->db->where('id', $idContent);
            $this->db->update('content', $content);
        }
        // Store the optionValues:
        foreach($contentData['content'] as $item) {
            $idOption = $item['id_option'];
            foreach($item['value'] as $valueItem) {
                $idLanguage = $valueItem['id_language'];
                $value      = $valueItem['value'];
                // Now we have idContent, idOption, idLanguage and the value. Enough to store this item in the database:
                // See if this value already exists in the database. If so, update it, else insert a new value.
                // Don't default delete all values and insert new ones, because if there would be an error when inserting
                // new data, the original data will be lost. Although this is not bound to happen, it still feels safe to
                // have a little extra safety... ;-)
                $this->db->where('id_content', $idContent);
                $this->db->where('id_option', $idOption);
                $this->db->where('id_language', $idLanguage);
                $this->db->from('values');                
                if($this->db->count_all_results()==0) {
                    // Insert:
                    $valueArray = array(
                        'id_content'=>$idContent,
                        'id_option'=>$idOption,
                        'id_language'=>$idLanguage,
                        'value'=>$value
                    );
                    $this->db->insert('values', $valueArray);
                } else {
                    // Update:
                    $this->db->where('id_content', $idContent);
                    $this->db->where('id_option', $idOption);
                    $this->db->where('id_language', $idLanguage);
                    $this->db->update('values', array('value'=>$value));
                }
            }
        }
        return $idContent;
    }
    
    /**
     * Duplicate content including all it's children
     * @param   $idContent  int The ID of the content to duplicate
     */
    function duplicateContent($idContent)
    {
        // TODO
        
    }
    
    /**
     * Get the settings
     * @return  array   Associated array with the settings
     */
    function getSettings()
    {
        $settings = array();
        $this->db->select('name,value');
        $query = $this->db->get('settings');
        foreach($query->result() as $setting) {
            $settings[$setting->name] = $setting->value;
        }
        return $settings;
    }
    
    /**
     * Save the settings
     * @param   $settings   array   Associated array with the settings
     */
    function saveSettings($settings)
    {
        foreach($settings as $key=>$value) {
            $this->db->where('name', $key);
            $this->db->from('settings');
            if($this->db->count_all_results()==0) {
                // Insert
                $this->db->insert('settings', array('name'=>$key, 'value'=>$value));
            } else {
                // Update
                $this->db->where('name', $key);
                $this->db->update('settings', array('name'=>$key, 'value'=>$value));                
            }
        }
    }
    
    /**
     * Get an array holding the languages
     * @return  array   The languages
     */
    function getLanguages()
    {
        $languages = array();
        $query = $this->db->get('languages');
        foreach($query->result_array() as $resultArray) {
            array_push($languages, $resultArray);
        }
        return $languages;
    }
}
?>