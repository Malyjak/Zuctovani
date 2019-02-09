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

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}

class Admin_Controller extends MY_Controller
{
    var $permission = array();

    public function __construct()
    {
        parent::__construct();

        $group_data = array();
        if (empty($this->session->userdata('logged_in'))) {
            $session_data = array('logged_in' => FALSE);
            $this->session->set_userdata($session_data);
        } else {
            $user_id = $this->session->userdata('id');
            $this->load->model('model_groups');
            $group_data = $this->model_groups->getUserGroupByUserId($user_id);

            $this->data['user_permission'] = unserialize($group_data['permission']);
            $this->permission = unserialize($group_data['permission']);
        }
    }

    public function logged_in()
    {
        $session_data = $this->session->userdata();
        if ($session_data['logged_in'] == TRUE) {
            redirect('dashboard', 'refresh');
        }
    }

    public function not_logged_in()
    {
        $session_data = $this->session->userdata();
        if ($session_data['logged_in'] == FALSE) {
            redirect('auth/login', 'refresh');
        }
    }

    public function render_template($page = null, $data = array())
    {

        $this->load->view('templates/header', $data);
        $this->load->view('templates/header_menu', $data);
        $this->load->view('templates/side_menubar', $data);
        $this->load->view('templates/dices', $data);
        $this->load->view($page, $data);
        $this->load->view('templates/footer', $data);
    }

}