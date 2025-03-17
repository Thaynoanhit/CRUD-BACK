<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
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
            $produto->imagem_url = base_url($produto->imagem_url);
        }
        return $produtos;
    }

    public function get_produto($id) {
        $this->db->where('deleted_at IS NULL');
        $produto = $this->db->get_where('produtos', array('id' => $id))->row();
        $produto->imagem_url = base_url($produto->imagem_url);
        return $produto;
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