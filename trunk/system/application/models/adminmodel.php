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
        // Add this id to the session of trees that are expanded:
        $expandedTrees = $this->session->userdata('treeArray');
        array_push($expandedTrees, $startID);
        $this->session->set_userdata('treeArray', $expandedTrees);
        // Create the tree:
        $tree  = array();
        $this->db->where('id_content', $startID);
        $this->db->select('id,name');
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('content');
        foreach($query->result() as $result) {
            $this->db->where('id_content', $result->id);
            $this->db->from('content');
            $numChildren = $this->db->count_all_results();
            $item = array(
                'id'=>$result->id,
                'name'=>$result->name,
                'numChildren'=>$numChildren,
                'tree'=>null
            );
            if(in_array($result->id, $expandedTrees)) {
                $childTree = $this->getTree($result->id);
                $item['tree'] = $childTree;
            }
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
        $query  = $this->db->get_where('templates', array('id'=>$id));
        $values = $query->result_array();
        $values = $values[0];
        $values['name'] = $this->lang->line('action_duplicate_prefix').$values['name'];
        unset($values['id']);
        $this->db->insert('templates', $values);
        // Duplicate allowed child templates linked to this template:
        $id_template = $this->db->insert_id();
        $this->db->select('id_child_template');
        $this->db->where('id_template', $id);
        $query = $this->db->get('templates_allowed_children');
        foreach($query->result_array() as $values) {
            $values['id_template'] = $id_template;
            $this->db->insert('templates_allowed_children', $values);
        }        
    }
    
    /**
     * Duplicate a data object
     * @param   $id int The ID of the dataobject to duplicate
     */
    function duplicateDataObject($id)
    {
        $query  = $this->db->get_where('dataobjects', array('id'=>$id));
        $values = $query->result_array();
        $values = $values[0];
        $values['name'] = $this->lang->line('action_duplicate_prefix').$values['name'];
        unset($values['id']);
        $this->db->insert('dataobjects', $values);
        // Duplicate options linked to this dataobject:
        $id_dataObject = $this->db->insert_id();
        $this->db->select('id_option,order');
        $this->db->where('id_dataobject', $id);
        $query = $this->db->get('dataobjects_options');
        foreach($query->result_array() as $values) {
            $values['id_dataobject'] = $id_dataObject;
            $this->db->insert('dataobjects_options', $values);
        }
    }
    
    /**
     * Duplicate an option
     * @param   $id int The ID of the option to duplicate
     */
    function duplicateOption($id)
    {
        $query  = $this->db->get_where('options', array('id'=>$id));
        $values = $query->result_array();
        $values = $values[0];
        $values['name'] = $this->lang->line('action_duplicate_prefix').$values['name'];
        unset($values['id']);
        $this->db->insert('options', $values);
    }
    
    /**
     * Duplicate a language
     * @param   $id int The ID of the language to duplicate
     */
    function duplicateLanguage($id)
    {
        $query  = $this->db->get_where('languages', array('id'=>$id));
        $values = $query->result_array();
        $values = $values[0];
        $values['name'] = $this->lang->line('action_duplicate_prefix').$values['name'];
        unset($values['id']);
        $this->db->insert('languages', $values);
    }
    
    /**
     * Duplicate a locale
     * @param   $id int The ID of the locale to duplicate
     */
    function duplicateLocale($id)
    {
        $query  = $this->db->get_where('locales', array('id'=>$id));
        $values = $query->result_array();
        $values = $values[0];
        $values['name'] = $this->lang->line('action_duplicate_prefix').$values['name'];
        unset($values['id']);
        $this->db->insert('locales', $values);
        // Duplicatie the locales values:
        $id_locale = $this->db->insert_id();
        $this->db->select('id_language,value');
        $this->db->where('id_locale', $id);
        $query = $this->db->get('locales_values');
        foreach($query->result_array() as $values) {
            $values['id_locale'] = $id_locale;
            $this->db->insert('locales_values', $values);
        }
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
     * Get the templates that can be added to the root
     * @return  array   A 2-dimensional array of the templates: [[id=int, name=string], ...]
     */
    function getRootTemplates()
    {
        $templates = array();
        $this->db->select('id,name');
        $this->db->where('root', 1);
        $query = $this->db->get('templates');
        foreach($query->result() as $result) {
            array_push($templates, array('id'=>$result->id, 'name'=>$result->name));
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
            content.*,
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
        $pf = $this->db->dbprefix;
        $sql = 'SELECT A.`id_option`, C.`name`, C.`type`, C.`default_value`, C.`multilanguage` FROM
            `'.$pf.'dataobjects_options` A,
            `'.$pf.'templates` B,
            `'.$pf.'options` C
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
            'alias'=>$contentData['alias'],
            'order'=>$contentData['order']
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
     * @param   $id         int     The ID of the content to duplicate
     * @param   $parentId   int     The ID of the parent to set (leave null to leave original parent, which is the case for the first document)
     */
    function duplicateContent($id, $parentId=null)
    {
        $query  = $this->db->get_where('content', array('id'=>$id));
        $values = $query->result_array();
        $values = $values[0];
        if($parentId==null) {
            // Only add the duplicate-prefix if there is nu parent-id set, which is the case for the first document:
            $values['name'] = $this->lang->line('action_duplicate_prefix').$values['name'];
        }
        if($parentId!=null) {
            $values['id_content'] = $parentId;
        }
        unset($values['id']);
        $this->db->insert('content', $values);
        // Duplicate the values that belong to this content:
        $id_content = $this->db->insert_id();
        $this->db->select('id_option,id_language,value');
        $this->db->where('id_content', $id);
        $query = $this->db->get('values');
        foreach($query->result_array() as $values) {
            $values['id_content'] = $id_content;
            $this->db->insert('values', $values);
        }
        // Duplicate the subpages belonging to this content (recursive)
        $this->db->select('id');
        $this->db->where('id_content', $id);
        $query = $this->db->get('content');
        foreach($query->result() as $result) {
            $this->duplicateContent($result->id, $id_content);
        }
    }
    
    /**
     * Delete content including all it's children
     * @param   $id     int     The ID of the content to delete
     */
    function deleteContent($id)
    {
        // Create an array of the children of this document:
        $this->db->select('id');
        $this->db->where('id_content', $id);
        $query = $this->db->get('content');
        $ids = array();
        foreach($query->result() as $result) {
            array_push($ids, $result->id);
        }
        // Delete this content:
        $this->db->delete('content', array('id'=>$id));
        $this->db->delete('values', array('id_content'=>$id));
        // Delete this contents' children (recursive):
        foreach($ids as $id_content) {
            $this->deleteContent($id_content);
        }
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
    
    /**
     * Check if ID of the parent is not a descendant of the ID of the content
     * @param   $idContent  int     The ID of the content
     * @param   $idParent   int     The ID of the parent
     * @return  boolean             True of the parent is a descendant, false if not.
     */
    function checkDescendant($idContent, $idParent)
    {
        // Get a list of all the documents which have this document as parent:
        $this->db->select('id');
        $this->db->where('id_content', $idContent);
        $query = $this->db->get('content');
        foreach($query->result() as $result) {
            if($result->id==$idParent) {
                // Descendant found!
                return true;
            }
            // Recursive:
            $isDescendant = $this->checkDescendant($result->id, $idParent);
            if($isDescendant) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Create a folder
     * @param   $name   string  The name of the folder
     */
    function createFolder($name)
    {
        mkdir($name);
    }
    
    /**
     * Store an upload
     * @param   $fileArray  array   File array, as given in $_FILES
     * @param   $folder     string  Name of the folder to store the file in.
     */
    function storeUpload($fileArray, $folder)
    {
        move_uploaded_file($fileArray['tmp_name'], $folder.'/'.$fileArray['name']);
    }
    
    /**
     * Get the users
     * @return  $users  array   A 2-dimensional array with user information
     */
    function getUsers()
    {
        $users = array();
        $this->db->select('*');
        $query = $this->db->get('users');
        foreach($query->result_array() as $user) {
            $this->db->select('name');
            $this->db->where('id', $user['id_rank']);
            $userQuery = $this->db->get('ranks');
            $result = $userQuery->result_array();
            if(!empty($result)) {
                $user['rank'] = $result[0]['name'];
            } else {
                $user['rank'] = '<em>unknown</em>';
            }
            array_push($users, $user);
        }
        return $users;
    }
    
    /**
     * Get the ranks
     * @return  $ranks  array   A 2-dimensional array with rank information
     */
    function getRanks()
    {
        $ranks = array();
        $this->db->select('*');
        $query = $this->db->get('ranks');
        foreach($query->result_array() as $rank) {
            array_push($ranks, $rank);
        }
        return $ranks;
    }
    
    /**
     * Check the login
     * @param   $username   string  The username
     * @param   $password   string  The password
     */
    function checkLogin($username, $password)
    {
        $this->db->select('*');
        $this->db->where(array('username'=>$username, 'password'=>$password));
        $query = $this->db->get('users');
        $info  = $query->result_array();
        if(empty($info)) {
            return false;
        } else {
            return $info;
        }
    }
}
?>