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

class Model_auth extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function check_email($email)
    {
        if ($email) {
            $sql = 'SELECT * FROM z_users WHERE email = ?';
            $query = $this->db->query($sql, array($email));
            $result = $query->num_rows();
            return ($result == 1) ? true : false;
        }

        return false;
    }

    public function login($email, $password)
    {
        if ($email && $password) {
            $sql = "SELECT * FROM z_users WHERE email = ?";
            $query = $this->db->query($sql, array($email));

            if ($query->num_rows() == 1) {
                $result = $query->row_array();

                $hash_password = password_verify($password, $result['password']);
                if ($hash_password === true) {
                    return $result;
                } else {
                    return false;
                }


            } else {
                return false;
            }
        }
    }

}