<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Configura o tipo de resposta como JSON
        $this->output->set_content_type('application/json');
    }

    public function index_get() {
        // Exemplo de método GET
        $data = array('message' => 'API funcionando!');
        $this->output->set_output(json_encode($data));
    }

    public function create_post() {
        // Exemplo de método POST
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        // Processa os dados...
        
        $response = array('success' => true, 'message' => 'Dados recebidos');
        $this->output->set_output(json_encode($response));
    }
}