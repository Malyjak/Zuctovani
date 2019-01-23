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

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_auth');
    }

    public function login()
    {
        $this->logged_in();

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $email_exists = $this->model_auth->check_email($this->input->post('email'));

            if ($email_exists == TRUE) {
                $login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));

                if ($login) {

                    $logged_in_sess = array(
                        'id' => $login['id'],
                        'username' => $login['username'],
                        'email' => $login['email'],
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($logged_in_sess);
                    redirect('dashboard', 'refresh');
                } else {
                    $this->data['errors'] = '<div align="center"><p class="text-red">Nesprávné heslo</p></div>';
                    $this->load->view('login', $this->data);
                }
            } else {
                $this->data['errors'] = '<div align="center"><p class="text-yellow">Email nebyl rozpoznán</br>Pro registraci prosím kontaktujte vypravěče</p></div>';

                $this->load->view('login', $this->data);
            }
        } else {
            $this->load->view('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login', 'refresh');
    }

}