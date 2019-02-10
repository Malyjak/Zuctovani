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

class Groups extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Skupiny';


        $this->load->model('model_groups');
    }

    public function index()
    {
        if (!in_array('viewGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $groups_data = $this->model_groups->getGroupData();
        $this->data['groups_data'] = $groups_data;

        $this->render_template('groups/index', $this->data);
    }

    public function create()
    {
        if (!in_array('createGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('group_name', 'Group name', 'required');

        if ($this->form_validation->run() == TRUE) {
            $permission = serialize($this->input->post('permission'));

            $data = array(
                'group_name' => $this->input->post('group_name'),
                'permission' => $permission
            );

            $create = $this->model_groups->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Skupina byla úspěšně vytvořena');
                redirect('groups/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('groups/create', 'refresh');
            }
        } else {
            $this->render_template('groups/create', $this->data);
        }
    }

    public function update($id = null)
    {
        if (!in_array('updateGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if ($id) {
            $this->form_validation->set_rules('group_name', 'Group name', 'required');
            if ($this->model_groups->existInGroups($id) == FALSE) {
                $this->session->set_flashdata('error', 'Skupina neexistuje!');
                redirect('groups/', 'refresh');
            } else {
                if ($this->form_validation->run() == TRUE) {
                    $permission = serialize($this->input->post('permission'));

                    $data = array(
                        'group_name' => $this->input->post('group_name'),
                        'permission' => $permission
                    );

                    $update = $this->model_groups->update($data, $id);
                    if ($update == true) {
                        $this->session->set_flashdata('success', 'Skupina byla úspěšně upravena');
                        redirect('groups/', 'refresh');
                    } else {
                        $this->session->set_flashdata('errors', 'Nastala chyba!');
                        redirect('groups/update/' . $id, 'refresh');
                    }
                } else {
                    $group_data = $this->model_groups->getGroupData($id);
                    $this->data['group_data'] = $group_data;
                    $this->render_template('groups/update', $this->data);
                }
            }
        }
    }

    public function delete($id)
    {
        if (!in_array('deleteGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if ($id) {
            if ($this->input->post('confirm')) {
                if ($this->model_groups->existInUserGroup($id)) {
                    $this->session->set_flashdata('error', 'Skupina je používaná!');
                    redirect('groups/', 'refresh');
                } else if ($this->model_groups->existInGroups($id)) {
                    $delete = $this->model_groups->delete($id);
                    if ($delete == true) {
                        $this->session->set_flashdata('success', 'Skupina byla úspěšně odstraněna');
                        redirect('groups/', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Nastala chyba!');
                        redirect('groups/delete/' . $id, 'refresh');
                    }
                }
            } else {
                $this->data['id'] = $id;
                $this->render_template('groups/delete', $this->data);
            }
        }
    }

}