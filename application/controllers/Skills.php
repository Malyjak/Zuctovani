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

class Skills extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Dovednosti';

        $this->load->model('model_skills');
    }

    public function index()
    {
        if (!in_array('viewSkill', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('skills/index', $this->data);
    }

    public function fetchSkillData()
    {
        if (!in_array('viewSkill', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_skills->getSkillData();

        foreach ($data as $key => $value) {
            $attribute = '';
            switch ($value['attribute']) {
                case 1:
                    $attribute = '<span class="label label-success">Kondice</span>';
                    break;
                case 2:
                    $attribute = '<span class="label label-primary">Mysl</span>';
                    break;
                case 3:
                    $attribute = '<span class="label label-warning">Působivost</span>';
                    break;
            }

            $buttons = '';
            if (in_array('updateSkill', $this->permission)) {
                $buttons .= '<a href="' . base_url('skills/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteSkill', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="deleteFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>';
            }

            $result['data'][$key] = array(
                $value['name'],
                $attribute,
                $value['description'],
                $buttons
            );
        }

        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createSkill', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'attribute' => $this->input->post('attribute'),
                'description' => $this->input->post('description'),
            );

            $create = $this->model_skills->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Dovednost byla úspěšně vytvořena');
                redirect('skills', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('skills/create', 'refresh');
            }
        } else {
            $this->render_template('skills/create', $this->data);
        }
    }

    public function update($skill_id)
    {
        if (!in_array('updateSkill', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$skill_id) {
            redirect('skills', 'refresh');
        }

        if ($this->model_skills->existInSkills($skill_id) == FALSE) {
            $this->session->set_flashdata('error', 'Dovednost neexistuje!');
            redirect('skills', 'refresh');
        } else {
            $this->form_validation->set_rules('name', 'name', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'attribute' => $this->input->post('attribute'),
                    'description' => $this->input->post('description'),
                );

                $update = $this->model_skills->update($data, $skill_id);
                if ($update == true) {
                    $this->session->set_flashdata('success', 'Dovednost byla úspěšně upravena');
                    redirect('skills', 'refresh');
                } else {
                    $this->session->set_flashdata('errors', 'Nastala chyba!');
                    redirect('skills/update/' . $skill_id, 'refresh');
                }
            } else {
                $this->render_template('skills/update', $this->data);
            }
        }
    }

    public function delete()
    {
        if (!in_array('deleteSkill', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $skill_id = $this->input->post('skill_id');

        $response = array();
        if ($skill_id) {
            if ($this->model_skills->existInNpcs($skill_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Dovednost je používána NPC!";
            } else if ($this->model_skills->existInCharacters($skill_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Dovednost je používána postavou!";
            } else if ($this->model_skills->existInCompanions($skill_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Dovednost je používána společníkem!";
            } else if ($this->model_skills->existInSkills($skill_id)) {
                $delete = $this->model_skills->delete($skill_id);
                if ($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = "Dovednost byla úspěšně odstraněna";
                } else {
                    $response['success'] = false;
                    $response['messages'] = "Nastala chyba!";
                }
            } else {
                $response['success'] = false;
                $response['messages'] = "Id nenalezeno!";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

}