<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    // Create
    public function criar_produto($data) {
        return ($this->db->insert('produtos', $data)) ? $this->db->insert_id('public."produtos_id_seq"') : false;
    }

    // Read 
    public function get_produtos() {
        $this->db->where('deleted_at IS NULL');
        $produtos = $this->db->get('produtos')->result();
        foreach($produtos as $produto) {
            if ($produto->imagem_url) {
                $produto->imagem_url = $this->get_full_url($produto->imagem_url);
            }
        }
        return $produtos;
    }

    public function get_produto($id) {
        $this->db->where('deleted_at IS NULL');
        $produto = $this->db->get_where('produtos', array('id' => $id))->row();
        if ($produto && $produto->imagem_url) {
            $produto->imagem_url = $this->get_full_url($produto->imagem_url);
        }
        return $produto;
    }

    private function get_full_url($path) {

        $server_url = 'http://192.168.18.41:8080';
        
        // Garantir o caminho relativo limpo
        $path = ltrim(preg_replace('/^https?:\/\/.*?\//i', '', $path), '/');
        
        // Remover "api/" do início do caminho se existir
        $path = preg_replace('/^api\//', '', $path);
        
        // Retorna a URL completa
        return $server_url . '/' . $path;
    }

    // Update
    public function atualizar_produto($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('produtos', $data, array('id' => $id));
    }
    
    // Soft Delete - Apenas marca o registro como deletado
    public function deletar_produto($id) {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->update('produtos', $data, array('id' => $id));
    }
}