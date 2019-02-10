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

class Model_npcs extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getNpcData($id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM z_npcs where id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM z_npcs ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data)
    {
        if ($data) {
            $insert = $this->db->insert('Z_npcs', $data);
            return ($insert == true) ? true : false;
        }
    }

    public function update($data, $id)
    {
        if ($data && $id) {
            $this->db->where('id', $id);
            $update = $this->db->update('Z_npcs', $data);
            return ($update == true) ? true : false;
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('Z_npcs');
            return ($delete == true) ? true : false;
        }
    }

    public function existInNpcs($id)
    {
        $sql = "SELECT * FROM z_npcs WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        return ($query->num_rows() == 1) ? true : false;
    }

    public function countTotalNpcs()
    {
        $sql = "SELECT * FROM z_npcs";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

}