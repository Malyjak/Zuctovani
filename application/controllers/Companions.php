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

class Companions extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $user_id = $this->session->userdata('id');

        $this->data['page_title'] = 'Společníci';
        $this->data['user_id'] = $user_id;

        $this->load->model('model_companions');
        $this->load->model('model_skills');
        $this->load->model('model_items');
        $this->load->model('model_piles');
    }

    public function index()
    {
        if (!in_array('viewCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('companions/index', $this->data);
    }

    public function fetchCompData()
    {
        $result = array('data' => array());

        $data = $this->model_companions->getCompData($this->session->userdata('id'));

        foreach ($data as $key => $value) {

            $buttons = '';
            if (in_array('updateCompanion', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="addQtyFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#addQty"><i class="fa fa-plus"></i></button>';
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeQtyFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeQty"><i class="fa fa-minus"></i></button>';
                $buttons .= '<a href="' . base_url('companions/view/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
            }

            if (in_array('deleteCompanion', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $skills = unserialize($value['skills']);
            $s = array();
            if ($skills != null) {
                foreach ($skills as &$skill) {
                    $skillData = $this->model_skills->getSkillData($skill);
                    $name = $skillData['name'];
                    switch ($skillData['attribute']) {
                        case 1:
                            $name = "<span class=\"label label-success\">" . $name . "</span>";
                            break;
                        case 2:
                            $name = "<span class=\"label label-primary\">" . $name . "</span>";
                            break;
                        case 3:
                            $name = "<span class=\"label label-warning\">" . $name . "</span>";
                            break;
                    }
                    array_push($s, $name);
                }
            }

            $items = unserialize($value['inventory']);
            $i = array();
            if ($items != null) {
                foreach ($items as &$item) {
                    $itemData = $this->model_items->getItemData($item);
                    $name = $itemData['name'];
                    switch ($itemData['quality']) {
                        case 1:
                            $name = "<span class=\"label label-danger\">" . $name . "</span>";
                            break;
                        case 2:
                            $name = "<span class=\"label label-warning\">" . $name . "</span>";
                            break;
                        case 3:
                            $name = "<span class=\"label label-success\">" . $name . "</span>";
                            break;
                        case 4:
                            $name = "<span class=\"label label-primary\">" . $name . "</span>";
                            break;
                    }
                    array_push($i, $name);
                }
            }

            $result['data'][$key] = array(
                $value['name'],
                $value['magic'],
                implode(" ", $s),
                implode(" ", $i),
                $value['comp_qty'] . "x",
                $buttons
            );
        }

        echo json_encode($result);
    }

    public function fetchSkillsData($comp_id)
    {
        $result = array('data' => array());

        $data = $this->model_companions->getCompDataById($comp_id);

        $skills = unserialize($data['skills']);

        $skills_lvl = unserialize($data['skills_lvl']);

        if ($skills != null) {
            foreach ($skills as $key => $value) {
                $skill = $this->model_skills->getSkillData($value);

                $buttons = ' <button type="button" class="btn btn-default" onclick="addSkillLvlFunc(' . ($key + 1) . ')" data-toggle="modal" data-target="#addSkillLvl"><i class="fa fa-plus"></i></button>';
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeSkillLvlFunc(' . ($key + 1) . ')" data-toggle="modal" data-target="#removeSkillLvl"><i class="fa fa-minus"></i></button>';
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeSkillFunc(' . $skill['id'] . ')" data-toggle="modal" data-target="#removeSkillModal"><i class="fa fa-trash"></i></button>';

                $attribute = '';
                switch ($skill['attribute']) {
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

                $result['data'][$key] = array(
                    $skill['name'],
                    $skills_lvl[$key],
                    $attribute,
                    $skill['description'],
                    $buttons
                );
            }
        }

        echo json_encode($result);
    }

    public function fetchItemsData($comp_id)
    {
        $result = array('data' => array());

        $data = $this->model_companions->getCompDataById($comp_id);

        $items = unserialize($data['inventory']);

        $items_qty = unserialize($data['inventory_qty']);

        if ($items != null) {
            foreach ($items as $key => $value) {
                $item = $this->model_items->getItemData($value);

                $buttons = ' <button type="button" class="btn btn-default" onclick="addItemQtyFunc(' . ($key + 1) . ')" data-toggle="modal" data-target="#addItemQty"><i class="fa fa-plus"></i></button>';
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeItemQtyFunc(' . ($key + 1) . ')" data-toggle="modal" data-target="#removeItemQty"><i class="fa fa-minus"></i></button>';
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeItemFunc(' . $item['id'] . ')" data-toggle="modal" data-target="#removeItemModal"><i class="fa fa-trash"></i></button>';

                $quality = '';
                switch ($item['quality']) {
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
                switch ($item['purpose']) {
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
                switch ($item['type']) {
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

                $result['data'][$key] = array(
                    $item['name'],
                    $quality,
                    $purpose,
                    $type,
                    $item['description'],
                    $items_qty[$key] . "x",
                    $buttons
                );
            }
        }

        echo json_encode($result);
    }

    public function updatePile()
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if ($user_id) {
            $this->form_validation->set_rules('pile', 'Společný inventář/Odkladiště/Poznámky', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'text' => $this->input->post('pile'),
                );

                $update = $this->model_piles->update($data, $this->model_piles->getPileData($user_id)['id']);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně změněno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function updateName($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($comp_id) {
            $this->form_validation->set_rules('name', 'Jméno', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně změněno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function updateMagic($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($comp_id) {
            $this->form_validation->set_rules('magic', 'Kouzla/Specializace', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'magic' => $this->input->post('magic'),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně změněno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function addSkill($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($comp_id) {
            $this->form_validation->set_rules('skill', 'Dovednost', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $comp_data = $this->model_companions->getCompDataById($comp_id);
                $skills = unserialize($comp_data['skills']);
                $skills[] = $this->input->post('skill');

                $skills_lvl = unserialize($comp_data['skills_lvl']);
                $skills_lvl[] = 6;

                $data = array(
                    'skills' => serialize($skills),
                    'skills_lvl' => serialize($skills_lvl),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně přidáno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function addItem($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($comp_id) {
            $this->form_validation->set_rules('item', 'Předmět', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $comp_data = $this->model_companions->getCompDataById($comp_id);
                $items = unserialize($comp_data['inventory']);
                $items_qty = unserialize($comp_data['inventory_qty']);

                $item = $this->input->post('item');
                if (($items !== null) && (false !== $key = array_search($item, $items))) {
                    $items_qty[$key] = $items_qty[$key] + 1;
                } else {
                    $items[] = $item;
                    $items_qty[] = 1;
                }

                $data = array(
                    'inventory' => serialize($items),
                    'inventory_qty' => serialize($items_qty),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně přidáno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function create()
    {
        if (!in_array('createCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'Jméno', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $skills = $this->input->post('skills');
            if (is_null($skills)) {
                $skills_lvl = null;
            } else {
                $skills_lvl = array_fill(0, count($skills), 6);
            }

            $inventory = $this->input->post('inventory');
            if (is_null($inventory)) {
                $inventory_qty = null;
            } else {
                $inventory_qty = array_fill(0, count($inventory), 1);
            }

            $data = array(
                'user_id' => $this->input->post('user_id'),
                'name' => $this->input->post('name'),
                'magic' => $this->input->post('magic'),
                'skills' => serialize($skills),
                'skills_lvl' => serialize($skills_lvl),
                'inventory' => serialize($inventory),
                'inventory_qty' => serialize($inventory_qty),
                'comp_qty' => 1,
            );

            $create = $this->model_companions->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Společník byl úspěšně vytvořen');
                redirect('companions/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('companions/create', 'refresh');
            }
        } else {
            $this->data['skills'] = $this->model_skills->getSkillData();
            $this->data['items'] = $this->model_items->getItemData();
            $this->render_template('companions/create', $this->data);
        }
    }

    public function view($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$comp_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
            );

            $update = $this->model_companions->update($data, $comp_id);
            if ($update == true) {
                $this->session->set_flashdata('success', 'Společník byl úspěšně upraven');
                redirect('companions/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('companions/view/' . $comp_id, 'refresh');
            }
        } else {
            $this->render_template('companions/view', $this->data);
        }
    }

    public function addQty()
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $comp_id = $this->input->post('comp_id');

        $response = array();
        if ($comp_id) {
            $comp_data = $this->model_companions->getCompDataByID($comp_id);

            $data = array(
                'comp_qty' => $comp_data['comp_qty'] + 1,
            );

            $update = $this->model_companions->update($data, $comp_id);
            if ($update == true) {
                $response['success'] = true;
                $response['messages'] = 'Úspěšně přidáno';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Nastala chyba!';
            }

        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeQty()
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $comp_id = $this->input->post('comp_id');

        $response = array();
        if ($comp_id) {
            $comp_data = $this->model_companions->getCompDataByID($comp_id);

            if ($comp_data['comp_qty'] > 1) {
                $data = array(
                    'comp_qty' => $comp_data['comp_qty'] - 1,
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně odebráno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            } else {
                $response['success'] = false;
                $response['messages'] = 'Kvantita je již na minimu! Pro odstranění společníka prosím použijte k tomu určené tlačítko';
            }

        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function remove()
    {
        if (!in_array('deleteCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $comp_id = $this->input->post('comp_id');

        $response = array();
        if ($comp_id) {
            $delete = $this->model_companions->remove($comp_id);
            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Společník byl úspěšně odstraněn";
            } else {
                $response['success'] = false;
                $response['messages'] = "Nastala chyba!";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function addSkillLvl($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $skill_pos = $this->input->post('skill_pos');

        $response = array();
        if ($skill_pos) {
            $comp_data = $this->model_companions->getCompDataById($comp_id);
            $skills_lvl = unserialize($comp_data['skills_lvl']);

            if (!empty($skills_lvl)) {
                foreach ($skills_lvl as $key => $value) {
                    if ($key == ($skill_pos - 1)) {
                        $skills_lvl[$key] = $value + 2;
                        break;
                    }
                }

                $data = array(
                    'skills_lvl' => serialize(array_values($skills_lvl)),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně přidáno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeSkillLvl($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $skill_pos = $this->input->post('skill_pos');

        $response = array();
        if ($skill_pos) {
            $comp_data = $this->model_companions->getCompDataById($comp_id);
            $skills_lvl = unserialize($comp_data['skills_lvl']);

            if (!empty($skills_lvl)) {
                $change = true;
                foreach ($skills_lvl as $key => $value) {
                    if ($key == ($skill_pos - 1)) {
                        if ($value > 6) {
                            $skills_lvl[$key] = $value - 2;
                            break;
                        } else {
                            $change = false;
                            break;
                        }
                    }
                }

                if ($change) {
                    $data = array(
                        'skills_lvl' => serialize(array_values($skills_lvl)),
                    );

                    $update = $this->model_companions->update($data, $comp_id);
                    if ($update == true) {
                        $response['success'] = true;
                        $response['messages'] = 'Úspěšně odebráno';
                    } else {
                        $response['success'] = false;
                        $response['messages'] = 'Nastala chyba!';
                    }
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Počet kostek je již na minimu!';
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeSkill($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $skill_id = $this->input->post('skill_id');

        $response = array();
        if ($skill_id) {
            $comp_data = $this->model_companions->getCompDataById($comp_id);
            $skills = unserialize($comp_data['skills']);
            $skills_lvl = unserialize($comp_data['skills_lvl']);

            if (!empty($skills)) {
                foreach ($skills as $key => $value) {
                    if ($value == $skill_id) {
                        unset($skills[$key]);
                        unset($skills_lvl[$key]);
                        break;
                    }
                }

                $data = array(
                    'skills' => serialize(array_values($skills)),
                    'skills_lvl' => serialize(array_values($skills_lvl)),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně odebráno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function addItemQty($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $item_pos = $this->input->post('item_pos');

        $response = array();
        if ($item_pos) {
            $comp_data = $this->model_companions->getCompDataById($comp_id);
            $items_qty = unserialize($comp_data['inventory_qty']);

            if (!empty($items_qty)) {
                foreach ($items_qty as $key => $value) {
                    if ($key == ($item_pos - 1)) {
                        $items_qty[$key] = $value + 1;
                        break;
                    }
                }

                $data = array(
                    'inventory_qty' => serialize(array_values($items_qty)),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně přidáno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeItemQty($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $item_pos = $this->input->post('item_pos');

        $response = array();
        if ($item_pos) {
            $comp_data = $this->model_companions->getCompDataById($comp_id);
            $items_qty = unserialize($comp_data['inventory_qty']);

            if (!empty($items_qty)) {
                $change = true;
                foreach ($items_qty as $key => $value) {
                    if ($key == ($item_pos - 1)) {
                        if ($value > 1) {
                            $items_qty[$key] = $value - 1;
                            break;
                        } else {
                            $change = false;
                            break;
                        }
                    }
                }

                if ($change) {
                    $data = array(
                        'inventory_qty' => serialize(array_values($items_qty)),
                    );

                    $update = $this->model_companions->update($data, $comp_id);
                    if ($update == true) {
                        $response['success'] = true;
                        $response['messages'] = 'Úspěšně odebráno';
                    } else {
                        $response['success'] = false;
                        $response['messages'] = 'Nastala chyba!';
                    }
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Kvantita je již na minimu! Pro odstranění předmětu prosím použijte k tomu určené tlačítko';
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeItem($comp_id)
    {
        if (!in_array('updateCompanion', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $item_id = $this->input->post('item_id');

        $response = array();
        if ($item_id) {
            $comp_data = $this->model_companions->getCompDataById($comp_id);
            $items = unserialize($comp_data['inventory']);
            $items_qty = unserialize($comp_data['inventory_qty']);

            if (!empty($items)) {
                foreach ($items as $key => $value) {
                    if ($value == $item_id) {
                        unset($items[$key]);
                        unset($items_qty[$key]);
                        break;
                    }
                }

                $data = array(
                    'inventory' => serialize(array_values($items)),
                    'inventory_qty' => serialize(array_values($items_qty)),
                );

                $update = $this->model_companions->update($data, $comp_id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Úspěšně odebráno';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Nastala chyba!';
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

}