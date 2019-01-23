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

class Model_users extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserData($userId = null)
    {
        if ($userId) {
            $sql = "SELECT * FROM z_users WHERE id = ?";
            $query = $this->db->query($sql, array($userId));
            return $query->row_array();
        }

        $sql = "SELECT * FROM z_users WHERE id != ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function getUserGroup($userId = null)
    {
        if ($userId) {
            $sql = "SELECT * FROM z_user_group WHERE user_id = ?";
            $query = $this->db->query($sql, array($userId));
            $result = $query->row_array();

            $group_id = $result['group_id'];
            $g_sql = "SELECT * FROM z_groups WHERE id = ?";
            $g_query = $this->db->query($g_sql, array($group_id));
            $q_result = $g_query->row_array();
            return $q_result;
        }
    }

    public function create($data = '', $group_id = null)
    {
        if ($data && $group_id) {
            $create = $this->db->insert('Z_users', $data);

            $user_id = $this->db->insert_id();

            $group_data = array(
                'user_id' => $user_id,
                'group_id' => $group_id
            );

            $group_data = $this->db->insert('Z_user_group', $group_data);

            return ($create == true && $group_data) ? true : false;
        }
    }

    public function edit($data = array(), $id = null, $group_id = null)
    {
        $this->db->where('id', $id);
        $update = $this->db->update('Z_users', $data);

        if ($group_id) {
            // user group
            $update_user_group = array('group_id' => $group_id);
            $this->db->where('user_id', $id);
            $user_group = $this->db->update('Z_user_group', $update_user_group);
            return ($update == true && $user_group == true) ? true : false;
        }

        return ($update == true) ? true : false;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete('Z_users');

        $this->db->where('user_id', $id);
        $delete = $this->db->delete('Z_user_group');
        return ($delete == true) ? true : false;
    }

    public function countTotalUsers()
    {
        $sql = "SELECT * FROM z_users";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function countTotalPlayers()
    {
        $sql = "SELECT * FROM z_user_group WHERE group_id = 3";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

}