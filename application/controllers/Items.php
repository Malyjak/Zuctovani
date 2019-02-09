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

class Items extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Předměty';

        $this->load->model('model_items');
    }

    public function index()
    {
        if (!in_array('viewItem', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('items/index', $this->data);
    }

    public function fetchItemData()
    {
        if (!in_array('viewItem', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_items->getItemData();

        foreach ($data as $key => $value) {
            $buttons = '';
            if (in_array('updateItem', $this->permission)) {
                $buttons .= '<a href="' . base_url('items/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteItem', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="deleteFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>';
            }

            $quality = '';
            switch ($value['quality']) {
                case 1:
                    $quality = '<span class="label label-danger">Špatná</span>';
                    break;
                case 2:
                    $quality = '<span class="label label-warning">Průměrná</span>';
                    break;
                case 3:
                    $quality = '<span class="label label-success">Mistrovská</span>';
                    break;
                case 4:
                    $quality = '<span class="label label-primary">Artefakt/Legendární</span>';
                    break;
            }

            $purpose = '';
            switch ($value['purpose']) {
                case 1:
                    $purpose = '<span>Výstroj</span>';
                    break;
                case 2:
                    $purpose = '<span>Nástroje</span>';
                    break;
                case 3:
                    $purpose = '<span>Použitelné</span>';
                    break;
                case 4:
                    $purpose = '<span>Ostatní</span>';
                    break;
            }

            $type = '';
            switch ($value['type']) {
                case 1:
                    $type = '<span>Běžný</span>';
                    break;
                case 2:
                    $type = '<span>Lehký/Rychlý</span>';
                    break;
                case 3:
                    $type = '<span>Těžký</span>';
                    break;
            }

            if ($value['availability'] > 0) {
                $availability = '<span>Ano</span>';
            } else {
                $availability = '<span>Ne</span>';
            }

            $result['data'][$key] = array(
                $value['name'],
                $quality,
                $purpose,
                $type,
                $value['description'],
                $availability,
                $buttons
            );
        }

        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createItem', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'quality' => $this->input->post('quality'),
                'purpose' => $this->input->post('purpose'),
                'type' => $this->input->post('type'),
                'availability' => $this->input->post('availability'),
            );

            $create = $this->model_items->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Předmět byl úspěšně vytvořen');
                redirect('items/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('items/create', 'refresh');
            }
        } else {
            $this->render_template('items/create', $this->data);
        }
    }

    public function update($item_id)
    {
        if (!in_array('updateItem', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$item_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $check = $this->model_items->existInItems($item_id);
        if ($check == false) {
            $this->session->set_flashdata('error', 'Předmět neexistuje!');
            redirect('items/', 'refresh');
        } else {
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'quality' => $this->input->post('quality'),
                    'purpose' => $this->input->post('purpose'),
                    'type' => $this->input->post('type'),
                    'availability' => $this->input->post('availability'),
                );

                $update = $this->model_items->update($data, $item_id);
                if ($update == true) {
                    $this->session->set_flashdata('success', 'Předmět byl úspěšně upraven');
                    redirect('items/', 'refresh');
                } else {
                    $this->session->set_flashdata('errors', 'Nastala chyba!');
                    redirect('items/update/' . $item_id, 'refresh');
                }
            } else {
                $this->render_template('items/edit', $this->data);
            }
        }
    }

    public function delete()
    {
        if (!in_array('deleteItem', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $item_id = $this->input->post('item_id');

        $response = array();
        if ($item_id) {
            if ($this->model_items->existInNpcs($item_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Předmět je používán NPC!";
            } else if ($this->model_items->existInCharacters($item_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Předmět je používán postavou!";
            } else if ($this->model_items->existInCompanions($item_id)) {
                $response['success'] = false;
                $response['messages'] = "Nelze odstranit! Předmět je používán společníkem!";
            } else if ($this->model_items->existInItems($item_id)) {
                $delete = $this->model_items->delete($item_id);
                if ($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = "Předmět byl úspěšně odstraněn";
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