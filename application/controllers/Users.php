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

class Users extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Hráči';

        $this->load->model('model_users');
        $this->load->model('model_groups');
    }

    public function index()
    {
        if (!in_array('viewUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $user_data = $this->model_users->getUserData();

        $result = array();
        foreach ($user_data as $k => $v) {
            $result[$k]['user_info'] = $v;

            $group = $this->model_users->getUserGroup($v['id']);
            $result[$k]['user_group'] = $group;
        }

        $this->data['user_data'] = $result;

        $this->render_template('users/index', $this->data);
    }

    public function password_hash($pass = '')
    {
        if ($pass) {
            $password = password_hash($pass, PASSWORD_DEFAULT);
            return $password;
        }
    }

    public function create()
    {
        if (!in_array('createUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('group', 'Skupina', 'required');
        $this->form_validation->set_rules('name', 'Jméno', 'trim|required|min_length[3]|max_length[12]|is_unique[z_users.username]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[z_users.email]');
        $this->form_validation->set_rules('password', 'Heslo', 'trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('confPassword', 'Potvrzení hesla', 'trim|required|matches[password]');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'username' => $this->input->post('name'),
                'password' => $this->password_hash($this->input->post('password')),
                'email' => $this->input->post('email'),
            );

            $create = $this->model_users->create($data, $this->input->post('group'));
            if ($create == true) {
                $this->session->set_flashdata('success', 'Uživatel byl úspěšně vytvořen');
                redirect('users/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('users/create', 'refresh');
            }
        } else {
            $group_data = $this->model_groups->getGroupData();
            $this->data['group_data'] = $group_data;

            $this->render_template('users/create', $this->data);
        }
    }

    public function update($id = null)
    {
        if (!in_array('updateUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$id) {
            redirect('users', 'refresh');
        }

        if ($this->model_users->existInUsers($id) == FALSE) {
            $this->session->set_flashdata('error', 'Hráč neexistuje!');
            redirect('users', 'refresh');
        } else {
            $this->form_validation->set_rules('groups', 'Group', 'required');

            $user_data = $this->model_users->getUserData($id);

            if ($user_data['username'] !== $this->input->post('name')) {
                $this->form_validation->set_rules('name', 'Jméno', 'trim|required|min_length[3]|max_length[12]|is_unique[z_users.username]');
            }

            if ($user_data['email'] !== $this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[z_users.email]');
            }

            $password = array_key_exists('password', $_POST) ? trim($_POST['password']) : null;
            $confPassword = array_key_exists('confPassword', $_POST) ? trim($_POST['confPassword']) : null;

            if ($this->form_validation->run() == TRUE) {
                if (empty($password) && empty($confPassword)) {
                    $data = array(
                        'username' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                    );

                    $update = $this->model_users->update($data, $id, $this->input->post('groups'));
                    if ($update == true) {
                        $this->session->set_flashdata('success', 'Hráč byl úspěšně upraven');
                        redirect('users/', 'refresh');
                    } else {
                        $this->session->set_flashdata('errors', 'Nastala chyba!');
                        redirect('users/update/' . $id, 'refresh');
                    }
                } else {
                    $this->form_validation->set_rules('password', 'Heslo', 'trim|required|min_length[3]|max_length[20]');
                    $this->form_validation->set_rules('confPassword', 'Potvrzení hesla', 'trim|required|matches[password]');

                    if ($this->form_validation->run() == TRUE) {
                        $password = $this->password_hash($this->input->post('password'));

                        $data = array(
                            'username' => $this->input->post('name'),
                            'password' => $password,
                            'email' => $this->input->post('email'),
                        );

                        $update = $this->model_users->update($data, $id, $this->input->post('groups'));
                        if ($update == true) {
                            $this->session->set_flashdata('success', 'Hráč byl úspěšně upraven');
                            redirect('users/', 'refresh');
                        } else {
                            $this->session->set_flashdata('errors', 'Nastala chyba!');
                            redirect('users/update/' . $id, 'refresh');
                        }
                    } else {
                        $user_data = $this->model_users->getUserData($id);
                        $groups = $this->model_users->getUserGroup($id);

                        $this->data['user_data'] = $user_data;
                        $this->data['user_group'] = $groups;

                        $group_data = $this->model_groups->getGroupData();
                        $this->data['group_data'] = $group_data;

                        $this->render_template('users/update', $this->data);
                    }

                }
            } else {
                $user_data = $this->model_users->getUserData($id);
                $groups = $this->model_users->getUserGroup($id);

                $this->data['user_data'] = $user_data;
                $this->data['user_group'] = $groups;

                $group_data = $this->model_groups->getGroupData();
                $this->data['group_data'] = $group_data;

                $this->render_template('users/update', $this->data);
            }
        }
    }

    public function delete($id)
    {
        if (!in_array('deleteUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if ($id) {
            if ($this->model_users->existInUsers($id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'Hráč neexistuje!';
            } else {
                if ($this->input->post('confirm')) {
                    $delete = $this->model_users->delete($id);
                    if ($delete == true) {
                        $this->session->set_flashdata('success', 'Hráč byl úspěšně odstraněn');
                        redirect('users/', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Nastala chyba!');
                        redirect('users/delete/' . $id, 'refresh');
                    }
                }
            }
        } else {
            $this->data['id'] = $id;
            $this->render_template('users/delete', $this->data);
        }
    }

    public function settings()
    {
        if (!in_array('updateSettings', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->session->userdata('id');

        if ($id) {
            if ($this->model_users->existInUsers($id) == FALSE) {
                $this->session->set_flashdata('error', 'Hráč neexistuje!');
                redirect('dashboard', 'refresh');
            } else {
                $this->form_validation->set_rules('username', 'Jméno', 'trim|required|min_length[3]|max_length[12]');

                $user_data = $this->model_users->getUserData($id);

                if ($user_data['email'] !== $this->input->post('email')) {
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[z_users.email]');
                }

                $password = array_key_exists('password', $_POST) ? trim($_POST['password']) : null;
                $confPassword = array_key_exists('confPassword', $_POST) ? trim($_POST['confPassword']) : null;

                if ($this->form_validation->run() == TRUE) {
                    if (empty($password) && empty($confPassword)) {
                        $data = array(
                            'username' => $this->input->post('username'),
                            'email' => $this->input->post('email'),
                        );

                        $update = $this->model_users->update($data, $id);
                        if ($update == true) {
                            $this->session->set_flashdata('success', 'Informace byly úspěšně změněny');
                            redirect('users/settings/', 'refresh');
                        } else {
                            $this->session->set_flashdata('errors', 'Nastala chyba!');
                            redirect('users/settings/', 'refresh');
                        }
                    } else {
                        $this->form_validation->set_rules('password', 'Heslo', 'trim|required|min_length[3]|max_length[20]');
                        $this->form_validation->set_rules('confPassword', 'Potvrzení hesla', 'trim|required|matches[password]');

                        if ($this->form_validation->run() == TRUE) {

                            $password = $this->password_hash($this->input->post('password'));

                            $data = array(
                                'username' => $this->input->post('username'),
                                'password' => $password,
                                'email' => $this->input->post('email'),
                            );

                            $update = $this->model_users->update($data, $id, $this->input->post('groups'));
                            if ($update == true) {
                                $this->session->set_flashdata('success', 'Informace byly úspěšně změněny');
                                redirect('users/settings/', 'refresh');
                            } else {
                                $this->session->set_flashdata('errors', 'Nastala chyba!');
                                redirect('users/settings/', 'refresh');
                            }
                        } else {
                            $user_data = $this->model_users->getUserData($id);
                            $groups = $this->model_users->getUserGroup($id);

                            $this->data['user_data'] = $user_data;
                            $this->data['user_group'] = $groups;

                            $group_data = $this->model_groups->getGroupData();
                            $this->data['group_data'] = $group_data;

                            $this->render_template('users/settings', $this->data);
                        }

                    }
                } else {
                    $user_data = $this->model_users->getUserData($id);
                    $groups = $this->model_users->getUserGroup($id);

                    $this->data['user_data'] = $user_data;
                    $this->data['user_group'] = $groups;

                    $group_data = $this->model_groups->getGroupData();
                    $this->data['group_data'] = $group_data;

                    $this->render_template('users/settings', $this->data);
                }
            }
        }
    }

}