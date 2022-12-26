<?php
namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{

	public function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = '') {

        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $sql = "SELECT * FROM `categories` WHERE `parent_id` = $parent  and status='1' ORDER BY id ASC";
        $query = $this->db->query($sql);
        $results = $query->getResultArray();
        if (!empty($results)) {
            foreach ($results AS $result) {
                $user_tree_array[] = array("id" => $result['id'], "title" => $spacing . $result['title'], "parent_id" => $result['parent_id'],"alias" => $result['alias']);
                $user_tree_array = $this->fetchCategoryTree($result['id'], $spacing . '- ', $user_tree_array);
            }
        }
        return $user_tree_array;
    }
    
    public function fetchCategoryTreeAdmin($parent = 0, $spacing = '', $user_tree_array = '') {

        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $sql = "SELECT * FROM `categories` WHERE 1 AND status='1' and `parent_id` = $parent ORDER BY id ASC";
        $query = $this->db->query($sql);
        $results = $query->getResultArray();
        if (!empty($results)) {
            foreach ($results AS $result) {
                $user_tree_array[] = array("id" => $result['id'], "title" => $spacing . $result['title'], "parent_id" => $result['parent_id'],"alias" => $result['alias']);
                $user_tree_array = $this->fetchCategoryTree($result['id'], $spacing . '- ', $user_tree_array);
            }
        }
        return $user_tree_array;
    }

}