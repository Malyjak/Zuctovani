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

class Locations extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Lokace';

        $this->load->model('model_locations');
    }

    public function index()
    {
        if (!in_array('viewLocation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('locations/index', $this->data);
    }

    public function fetchLocationData()
    {
        if (!in_array('viewLocation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_locations->getLocationData();

        foreach ($data as $key => $value) {
            $buttons = '';
            if (in_array('updateLocation', $this->permission)) {
                $buttons .= '<a href="' . base_url('locations/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteLocation', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="deleteFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>';
            }

            $terrain = '';
            switch ($value['terrain']) {
                case 1:
                    $terrain = '<span class="label label-primary">Triviální</span>';
                    break;
                case 2:
                    $terrain = '<span class="label label-success">Mírný</span>';
                    break;
                case 3:
                    $terrain = '<span class="label label-warning">Středně těžký</span>';
                    break;
                case 4:
                    $terrain = '<span class="label label-danger">Těžký</span>';
                    break;
            }

            $result['data'][$key] = array(
                $value['name'],
                $terrain,
                $value['hidden'],
                $value['traps'],
                $value['description'],
                $buttons
            );
        }

        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createLocation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'terrain' => $this->input->post('terrain'),
                'hidden' => $this->input->post('hidden'),
                'traps' => $this->input->post('traps'),
                'description' => $this->input->post('description'),
            );

            $create = $this->model_locations->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Lokace byla úspěšně vytvořena');
                redirect('locations/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('locations/create', 'refresh');
            }
        } else {
            $this->render_template('locations/create', $this->data);
        }
    }

    public function update($location_id)
    {
        if (!in_array('updateLocation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$location_id) {
            redirect('dashboard', 'refresh');
        }

        if ($this->model_locations->existInLocations($location_id)) {
            $this->form_validation->set_rules('name', 'name', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'terrain' => $this->input->post('terrain'),
                    'hidden' => $this->input->post('hidden'),
                    'traps' => $this->input->post('traps'),
                    'description' => $this->input->post('description'),
                );

                $update = $this->model_locations->update($data, $location_id);
                if ($update == true) {
                    $this->session->set_flashdata('success', 'Lokace byla úspěšně upravena');
                    redirect('locations/', 'refresh');
                } else {
                    $this->session->set_flashdata('errors', 'Nastala chyba!');
                    redirect('locations/update/' . $location_id, 'refresh');
                }
            } else {
                $this->render_template('locations/update', $this->data);
            }
        } else {
            $this->session->set_flashdata('error', 'Lokace neexistuje!');
            redirect('locations/', 'refresh');
        }
    }

    public function delete()
    {
        if (!in_array('deleteLocation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $location_id = $this->input->post('location_id');

        $response = array();
        if ($location_id) {
            if ($this->model_locations->existInLocations($location_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'Lokace neexistuje!';
            } else {
                $delete = $this->model_locations->delete($location_id);
                if ($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = "Lokace byla úspěšně odstraněna";
                } else {
                    $response['success'] = false;
                    $response['messages'] = "Nastala chyba!";
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

}