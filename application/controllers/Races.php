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

class Races extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Rasy';

        $this->load->model('model_races');
    }

    public function index()
    {
        if (!in_array('viewRace', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('races/index', $this->data);
    }

    public function fetchRaceData()
    {
        if (!in_array('viewRace', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_races->getRaceData();

        foreach ($data as $key => $value) {
            $buttons = '';
            if (in_array('updateRace', $this->permission)) {
                $buttons .= '<a href="' . base_url('races/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteRace', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="deleteFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>';
            }

            $result['data'][$key] = array(
                $value['name'],
                $value['description'],
                $buttons
            );
        }

        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createRace', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            );

            $create = $this->model_races->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Rasa byla úspěšně vytvořena');
                redirect('races/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('races/create', 'refresh');
            }
        } else {
            $this->render_template('races/create', $this->data);
        }
    }

    public function update($race_id)
    {
        if (!in_array('updateRace', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$race_id) {
            redirect('dashboard', 'refresh');
        }

        if ($this->model_races->existInRaces($race_id) == FALSE) {
            $this->session->set_flashdata('error', 'Rasa neexistuje!');
            redirect('races', 'refresh');
        } else {
            $this->form_validation->set_rules('name', 'name', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                );

                $update = $this->model_races->update($data, $race_id);
                if ($update == true) {
                    $this->session->set_flashdata('success', 'Rasa byla úspěšně upravena');
                    redirect('races/', 'refresh');
                } else {
                    $this->session->set_flashdata('errors', 'Nastala chyba!');
                    redirect('races/update/' . $race_id, 'refresh');
                }
            } else {
                $this->render_template('races/update', $this->data);
            }
        }
    }

    public function delete()
    {
        if (!in_array('deleteRace', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $race_id = $this->input->post('race_id');

        $response = array();
        if ($race_id) {
            if ($this->model_races->existInNpcs($race_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Rasa je používána NPC!";
            } else if ($this->model_races->existInCharacters($race_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Rasa je používána postavou!";
            } else if ($this->model_races->existInRaces($race_id)) {
                $delete = $this->model_races->delete($race_id);
                if ($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = "Rasa byla úspěšně odstraněna";
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