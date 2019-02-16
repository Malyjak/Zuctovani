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

class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Přehledy';

        $this->load->model('model_items');
        $this->load->model('model_npcs');
        $this->load->model('model_users');
        $this->load->model('model_locations');
        $this->load->model('model_skills');
        $this->load->model('model_races');
        $this->load->model('model_character');
        $this->load->model('model_companions');
    }

    public function index()
    {
        $this->data['total_items'] = $this->model_items->countTotalItems();
        $this->data['total_npcs'] = $this->model_npcs->countTotalNpcs();
        $this->data['total_users'] = $this->model_users->countTotalUsers();
        $this->data['total_locations'] = $this->model_locations->countTotalLocations();
        $this->data['total_skills'] = $this->model_skills->countTotalSkills();
        $this->data['total_races'] = $this->model_races->countTotalRaces();
        $this->data['total_characters'] = $this->model_character->countTotalCharacters();
        $this->data['total_companions'] = $this->model_companions->countTotalCompanions();

        $user_id = $this->session->userdata('id');
        $is_admin = ($user_id == 1);
        $group = $this->model_users->getUserGroup($user_id);
        // Change your storyteller group id here!
        $is_storyteller = ($group['id'] == 2);

        $this->data['is_admin'] = $is_admin;
        $this->data['is_storyteller'] = $is_storyteller;
        $this->render_template('Dashboard', $this->data);
    }

}