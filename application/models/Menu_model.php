<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function get_menus() {
        // Fetch headers
        $this->db->where('parent_id', 0);
        $this->db->where('is_header', 1);
        $this->db->order_by('sort_order', 'ASC');
        $headers = $this->db->get('menus')->result();

        foreach ($headers as $header) {
            // Fetch menus for each header
            $this->db->where('parent_id', $header->id);
            $this->db->order_by('sort_order', 'ASC');
            $header->menu = $this->db->get('menus')->result();

            foreach ($header->menu as $menu) {
                // Fetch submenus for each menu
                $this->db->where('parent_id', $menu->id);
                $this->db->order_by('sort_order', 'ASC');
                $menu->submenu = $this->db->get('menus')->result();
            }
        }

        // Add Logout at the end
        $this->db->where('id', 99);
        $logout = $this->db->get('menus')->row();
        if ($logout) {
            $headers[] = $logout;
        }

        return $headers;
    }
}
