<?php
class AdminModel extends Model
{
    function AdminModel()
    {
        parent::Model();
    }
    
    function getTableData($tableName, $fields)
    {
        $this->db->select($fields);
        $query = $this->db->get($tableName);
        return $query;
    }
}
?>