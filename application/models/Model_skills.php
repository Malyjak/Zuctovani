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

class Model_skills extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSkillData($id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM z_skills where id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM z_skills ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data)
    {
        if ($data) {
            $insert = $this->db->insert('Z_skills', $data);
            return ($insert == true) ? true : false;
        }
    }

    public function update($data, $id)
    {
        if ($data && $id) {
            $this->db->where('id', $id);
            $update = $this->db->update('Z_skills', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('Z_skills');
            return ($delete == true) ? true : false;
        }
    }

    public function countTotalSkills()
    {
        $sql = "SELECT * FROM z_skills";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

}