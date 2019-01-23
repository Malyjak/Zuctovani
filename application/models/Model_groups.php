<?php
/*
This file is part of Zuctovani.

Zuctovani is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Zuctovani is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Zuctovani.  If not, see <https://www.gnu.org/licenses/>.
*/

class Model_groups extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGroupData($groupId = null)
    {
        if ($groupId) {
            $sql = "SELECT * FROM z_groups WHERE id = ?";
            $query = $this->db->query($sql, array($groupId));
            return $query->row_array();
        }

        $sql = "SELECT * FROM z_groups WHERE id != ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function create($data = '')
    {
        $create = $this->db->insert('Z_groups', $data);
        return ($create == true) ? true : false;
    }

    public function edit($data, $id)
    {
        $this->db->where('id', $id);
        $update = $this->db->update('Z_groups', $data);
        return ($update == true) ? true : false;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete('Z_groups');
        return ($delete == true) ? true : false;
    }

    public function existInUserGroup($id)
    {
        $sql = "SELECT * FROM z_user_group WHERE group_id = ?";
        $query = $this->db->query($sql, array($id));
        return ($query->num_rows() == 1) ? true : false;
    }

    public function getUserGroupByUserId($user_id)
    {
        $sql = "SELECT * FROM z_user_group 
		INNER JOIN z_groups ON z_groups.id = z_user_group.group_id 
		WHERE z_user_group.user_id = ?";
        $query = $this->db->query($sql, array($user_id));
        $result = $query->row_array();

        return $result;

    }
}