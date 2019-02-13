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

class Npcs extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'NPC';

        $this->load->model('model_npcs');
        $this->load->model('model_skills');
        $this->load->model('model_items');
        $this->load->model('model_races');
    }

    public function index()
    {
        if (!in_array('viewNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('npcs/index', $this->data);
    }

    public function fetchNpcData()
    {
        if (!in_array('viewNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_npcs->getNpcData();

        foreach ($data as $key => $value) {

            $buttons = '';
            if (in_array('updateNpc', $this->permission)) {
                $buttons .= '<a href="' . base_url('npcs/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
            }

            if (in_array('deleteNpc', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="deleteFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>';
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
                $value['lvl'],
                $value['money'],
                $value['magic'],
                implode(" ", $s),
                implode(" ", $i),
                $buttons
            );
        }

        echo json_encode($result);
    }

    public function fetchSkillsData($npc_id)
    {
        if (!in_array('viewNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_npcs->getNpcData($npc_id);

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

    public function fetchItemsData($npc_id)
    {
        if (!in_array('viewNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_npcs->getNpcData($npc_id);

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

    public function updateName($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $this->form_validation->set_rules('name', 'Jméno', 'trim|required');
                $this->form_validation->set_rules('lvl', 'Lvl', 'trim|required|numeric');
                $this->form_validation->set_rules('race', 'Rasa', 'trim|required|numeric');
                $this->form_validation->set_rules('money', 'Stříbrňáky', 'trim|required|numeric');

                $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

                if ($this->form_validation->run() == TRUE) {
                    $data = array(
                        'name' => $this->input->post('name'),
                        'lvl' => $this->input->post('lvl'),
                        'race' => $this->input->post('race'),
                        'gift' => $this->input->post('gift'),
                        'origin' => $this->input->post('origin'),
                        'money' => $this->input->post('money'),
                    );

                    $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function updateHp($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $this->form_validation->set_rules('hp', 'HP', 'trim|required|numeric');
                $this->form_validation->set_rules('mp', 'MP', 'trim|required|numeric');
                $this->form_validation->set_rules('sp', 'SP', 'trim|required|numeric');
                $this->form_validation->set_rules('hp_max', 'Max HP', 'trim|required|numeric');
                $this->form_validation->set_rules('mp_max', 'Max MP', 'trim|required|numeric');
                $this->form_validation->set_rules('sp_max', 'Max SP', 'trim|required|numeric');

                $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

                if ($this->form_validation->run() == TRUE) {
                    $data = array(
                        'hp' => $this->input->post('hp'),
                        'mp' => $this->input->post('mp'),
                        'sp' => $this->input->post('sp'),
                        'hp_max' => $this->input->post('hp_max'),
                        'mp_max' => $this->input->post('mp_max'),
                        'sp_max' => $this->input->post('sp_max'),
                    );

                    $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function updateReflexes($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $this->form_validation->set_rules('reflexes', 'Reflexy', 'trim|required|numeric');
                $this->form_validation->set_rules('initiative', 'Iniciativa', 'trim|required|numeric');

                $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

                if ($this->form_validation->run() == TRUE) {
                    $data = array(
                        'reflexes' => $this->input->post('reflexes'),
                        'initiative' => $this->input->post('initiative'),
                    );

                    $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function updateMagic($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $this->form_validation->set_rules('magic', 'Kouzla/Specializace', 'trim|required');

                $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

                if ($this->form_validation->run() == TRUE) {
                    $data = array(
                        'magic' => $this->input->post('magic'),
                    );

                    $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function addSkill($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $this->form_validation->set_rules('skill', 'Dovednost', 'trim|required');

                $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

                if ($this->form_validation->run() == TRUE) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $skills = unserialize($npc_data['skills']);
                    $skills[] = $this->input->post('skill');

                    $skills_lvl = unserialize($npc_data['skills_lvl']);
                    $skills_lvl[] = 6;

                    $data = array(
                        'skills' => serialize($skills),
                        'skills_lvl' => serialize($skills_lvl),
                    );

                    $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function addSkillLvl($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $skill_pos = $this->input->post('skill_pos');
                if ($skill_pos) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $skills_lvl = unserialize($npc_data['skills_lvl']);

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

                        $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeSkillLvl($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $skill_pos = $this->input->post('skill_pos');
                if ($skill_pos) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $skills_lvl = unserialize($npc_data['skills_lvl']);

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

                            $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeSkill($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $skill_id = $this->input->post('skill_id');
                if ($skill_id) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $skills = unserialize($npc_data['skills']);
                    $skills_lvl = unserialize($npc_data['skills_lvl']);

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

                        $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function addItem($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $this->form_validation->set_rules('item', 'Předmět', 'trim|required');

                $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

                if ($this->form_validation->run() == TRUE) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $items = unserialize($npc_data['inventory']);
                    $items_qty = unserialize($npc_data['inventory_qty']);

                    $item = $this->input->post('item');
                    if (($items !== null) && (false !== $key = array_search($item, $items))) {
                        $items_qty[$key] = $items_qty[$key] + 1;
                    } else {
                        $items[] = $this->input->post('item');
                        $items_qty[] = 1;
                    }

                    $data = array(
                        'inventory' => serialize($items),
                        'inventory_qty' => serialize($items_qty),
                    );

                    $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Obnovte prosím stránku';
        }

        echo json_encode($response);
    }

    public function addItemQty($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $item_pos = $this->input->post('item_pos');
                if ($item_pos) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $items_qty = unserialize($npc_data['inventory_qty']);

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

                        $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeItemQty($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $item_pos = $this->input->post('item_pos');
                if ($item_pos) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $items_qty = unserialize($npc_data['inventory_qty']);

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

                            $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function removeItem($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $item_id = $this->input->post('item_id');
                if ($item_id) {
                    $npc_data = $this->model_npcs->getNpcData($npc_id);
                    $items = unserialize($npc_data['inventory']);
                    $items_qty = unserialize($npc_data['inventory_qty']);

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

                        $update = $this->model_npcs->update($data, $npc_id);
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
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Obnovte prosím stránku";
        }

        echo json_encode($response);
    }

    public function create()
    {
        if (!in_array('createNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'Jméno', 'trim|required');
        $this->form_validation->set_rules('lvl', 'Level', 'trim|numeric');
        $this->form_validation->set_rules('race', 'Rasa', 'trim|numeric');
        $this->form_validation->set_rules('money', 'Peníze', 'trim|numeric');

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
                'name' => $this->input->post('name'),
                'lvl' => $this->input->post('lvl'),
                'race' => $this->input->post('race'),
                'gift' => $this->input->post('gift'),
                'origin' => $this->input->post('origin'),
                'money' => $this->input->post('money'),
                'magic' => $this->input->post('magic'),
                'skills' => serialize($skills),
                'skills_lvl' => serialize($skills_lvl),
                'inventory' => serialize($inventory),
                'inventory_qty' => serialize($inventory_qty),
            );

            $create = $this->model_npcs->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'NPC bylo úspěšně vytvořeno');
                redirect('npcs', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('npcs/create', 'refresh');
            }
        } else {
            $this->data['races'] = $this->model_races->getRaceData();
            $this->data['skills'] = $this->model_skills->getSkillData();
            $this->data['items'] = $this->model_items->getItemData();
            $this->render_template('npcs/create', $this->data);
        }
    }

    public function update($npc_id)
    {
        if (!in_array('updateNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$npc_id) {
            redirect('npcs', 'refresh');
        }

        if ($this->model_npcs->existInNpcs($npc_id)) {
            $this->render_template('npcs/update', $this->data);
        } else {
            $this->session->set_flashdata('error', 'NPC neexistuje!');
            redirect('npcs', 'refresh');
        }
    }

    public function delete()
    {
        if (!in_array('deleteNpc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $npc_id = $this->input->post('npc_id');

        $response = array();
        if ($npc_id) {
            if ($this->model_npcs->existInNpcs($npc_id) == FALSE) {
                $response['success'] = false;
                $response['messages'] = 'NPC neexistuje!';
            } else {
                $delete = $this->model_npcs->delete($npc_id);
                if ($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = "NPC bylo úspěšně odstraněno";
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