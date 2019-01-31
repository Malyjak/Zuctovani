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

class Character extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $user_id = $this->session->userdata('id');

        $this->data['page_title'] = 'Postava';
        $this->data['user_id'] = $user_id;

        $this->load->model('model_character');
        $this->load->model('model_skills');
        $this->load->model('model_items');
        $this->load->model('model_races');
    }

    public function index()
    {
        if (!in_array('viewCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $user_id = $this->session->userdata('id');
        if ($this->model_character->haveNoCharacter($user_id)) {
            redirect('character/create', 'refresh');
        } else {
            $this->render_template('character/index', $this->data);
        }
    }

    public function fetchSkillsData()
    {
        $result = array('data' => array());

        $data = $this->model_character->getCharacterData($this->session->userdata('id'));

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

    public function fetchItemsData()
    {
        $result = array('data' => array());

        $user_id = $this->session->userdata('id');
        $data = $this->model_character->getCharacterData($user_id);

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
                    $items_qty[$key]."x",
                    $buttons
                );
            }
        }

        echo json_encode($result);
    }

    public function updateName()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if (!$this->model_character->haveNoCharacter($user_id)) {
            $this->form_validation->set_rules('name', 'Jméno', 'trim|required');
            $this->form_validation->set_rules('lvl', 'Lvl', 'trim|required|numeric');
            $this->form_validation->set_rules('xp', 'XP', 'trim|required|numeric');
            $this->form_validation->set_rules('money', 'Stříbrňáky', 'trim|required|numeric');
            $this->form_validation->set_rules('race', 'Rasa', 'trim|required|numeric');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'lvl' => $this->input->post('lvl'),
                    'xp' => $this->input->post('xp'),
                    'money' => $this->input->post('money'),
                    'race' => $this->input->post('race'),
                    'gift' => $this->input->post('gift'),
                    'origin' => $this->input->post('origin'),
                );

                $update = $this->model_character->update($data, $user_id);
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

    public function updateHp()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if (!$this->model_character->haveNoCharacter($user_id)) {
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

                $update = $this->model_character->update($data, $user_id);
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

    public function updateReflexes()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if (!$this->model_character->haveNoCharacter($user_id)) {
            $this->form_validation->set_rules('reflexes', 'Reflexy', 'trim|required|numeric');
            $this->form_validation->set_rules('initiative', 'Iniciativa', 'trim|required|numeric');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'reflexes' => $this->input->post('reflexes'),
                    'initiative' => $this->input->post('initiative'),
                );

                $update = $this->model_character->update($data, $user_id);
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

    public function updateMagic()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if (!$this->model_character->haveNoCharacter($user_id)) {
            $this->form_validation->set_rules('magic', 'Kouzla/Specializace', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'magic' => $this->input->post('magic'),
                );

                $update = $this->model_character->update($data, $user_id);
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

    public function updatePerks()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if (!$this->model_character->haveNoCharacter($user_id)) {
            $this->form_validation->set_rules('perks', 'Perky', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'perks' => $this->input->post('perks'),
                );

                $update = $this->model_character->update($data, $user_id);
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

    public function addSkill()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if (!$this->model_character->haveNoCharacter($user_id)) {
            $this->form_validation->set_rules('skill', 'Dovednost', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $char_data = $this->model_character->getCharacterData($user_id);
                $skills = unserialize($char_data['skills']);
                $skills[] = $this->input->post('skill');

                $skills_lvl = unserialize($char_data['skills_lvl']);
                $skills_lvl[] = 6;

                $data = array(
                    'skills' => serialize($skills),
                    'skills_lvl' => serialize($skills_lvl),
                );

                $update = $this->model_character->update($data, $user_id);
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

    public function addItem()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');
        if (!$this->model_character->haveNoCharacter($user_id)) {
            $this->form_validation->set_rules('item', 'Předmět', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $char_data = $this->model_character->getCharacterData($user_id);
                $items = unserialize($char_data['inventory']);
                $items_qty = unserialize($char_data['inventory_qty']);

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

                $update = $this->model_character->update($data, $user_id);
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
        if (!in_array('createCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'Jméno', 'trim|required');
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
                'user_id' => $this->input->post('user_id'),
                'name' => $this->input->post('name'),
                'race' => $this->input->post('race'),
                'gift' => $this->input->post('gift'),
                'origin' => $this->input->post('origin'),
                'money' => $this->input->post('money'),
                'magic' => $this->input->post('magic'),
                'perks' => $this->input->post('perks'),
                'skills' => serialize($skills),
                'skills_lvl' => serialize($skills_lvl),
                'inventory' => serialize($inventory),
                'inventory_qty' => serialize($inventory_qty),
            );

            $create = $this->model_character->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Postava byla úspěšně vytvořena');
                redirect('character/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Nastala chyba!');
                redirect('character/create', 'refresh');
            }
        } else {
            $this->data['races'] = $this->model_races->getRaceData();
            $this->data['skills'] = $this->model_skills->getSkillData();
            $this->data['items'] = $this->model_items->getPlayerItemData();

            $user_id = $this->session->userdata('id');
            if ($this->model_character->haveNoCharacter($user_id)) {
                $this->render_template('character/create', $this->data);
            } else {
                redirect('character', 'refresh');
            }
        }
    }

    public function addSkillLvl()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');

        $skill_pos = $this->input->post('skill_pos');
        if ((!$this->model_character->haveNoCharacter($user_id)) && $skill_pos) {
            $skills_lvl = unserialize($this->model_character->getCharacterData($user_id)['skills_lvl']);

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

                $update = $this->model_character->update($data, $user_id);
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

    public function removeSkillLvl()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');

        $skill_pos = $this->input->post('skill_pos');
        if ((!$this->model_character->haveNoCharacter($user_id)) && $skill_pos) {
            $skills_lvl = unserialize($this->model_character->getCharacterData($user_id)['skills_lvl']);

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

                    $update = $this->model_character->update($data, $user_id);
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

    public function removeSkill()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');

        $skill_id = $this->input->post('skill_id');
        if ((!$this->model_character->haveNoCharacter($user_id)) && $skill_id) {
            $char_data = $this->model_character->getCharacterData($user_id);
            $skills = unserialize($char_data['skills']);
            $skills_lvl = unserialize($char_data['skills_lvl']);

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

                $update = $this->model_character->update($data, $user_id);
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

    public function addItemQty()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');

        $item_pos = $this->input->post('item_pos');
        if ((!$this->model_character->haveNoCharacter($user_id)) && $item_pos) {
            $item_qty = unserialize($this->model_character->getCharacterData($user_id)['inventory_qty']);

            if (!empty($item_qty)) {
                foreach ($item_qty as $key => $value) {
                    if ($key == ($item_pos - 1)) {
                        $item_qty[$key] = $value + 1;
                        break;
                    }
                }

                $data = array(
                    'inventory_qty' => serialize(array_values($item_qty)),
                );

                $update = $this->model_character->update($data, $user_id);
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

    public function removeItemQty()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');

        $item_pos = $this->input->post('item_pos');
        if ((!$this->model_character->haveNoCharacter($user_id)) && $item_pos) {
            $item_qty = unserialize($this->model_character->getCharacterData($user_id)['inventory_qty']);

            if (!empty($item_pos)) {
                $change = true;
                foreach ($item_qty as $key => $value) {
                    if ($key == ($item_pos - 1)) {
                        if ($value > 1) {
                            $item_qty[$key] = $value - 1;
                            break;
                        } else {
                            $change = false;
                            break;
                        }
                    }
                }

                if ($change) {
                    $data = array(
                        'inventory_qty' => serialize(array_values($item_qty)),
                    );

                    $update = $this->model_character->update($data, $user_id);
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

    public function removeItem()
    {
        if (!in_array('updateCharacter', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $user_id = $this->session->userdata('id');

        $item_id = $this->input->post('item_id');
        if ((!$this->model_character->haveNoCharacter($user_id)) && $item_id) {
            $char_data = $this->model_character->getCharacterData($user_id);
            $items = unserialize($char_data['inventory']);
            $items_qty = unserialize($char_data['inventory_qty']);

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

                $update = $this->model_character->update($data, $user_id);
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