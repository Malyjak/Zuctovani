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

class Model_character extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCharacterData($user_id = null)
    {
        if ($user_id) {
            $sql = "SELECT * FROM z_characters where user_id = ?";
            $query = $this->db->query($sql, array($user_id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM z_characters ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data)
    {
        if ($data) {
            $insert = $this->db->insert('Z_characters', $data);
            return ($insert == true) ? true : false;
        }
    }

    public function update($data, $user_id)
    {
        if ($data && $user_id) {
            $this->db->where('user_id', $user_id);
            $update = $this->db->update('Z_characters', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('Z_characters');
            return ($delete == true) ? true : false;
        }
    }

    public function countTotalCharacters()
    {
        $sql = "SELECT * FROM z_characters";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function haveNoCharacter($user_id)
    {
        $sql = "SELECT * FROM z_characters WHERE user_id = ?";
        $query = $this->db->query($sql, array($user_id));
        if ($query->num_rows() > 0) {
            return false;
        }
        return true;
    }

}