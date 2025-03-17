<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Produto extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('produto_model');
        $this->load->helper(array('form', 'url'));
    }
    
    public function index_get($id = NULL) {
        if ($id === NULL) {
            $produtos = $this->produto_model->get_produtos();
            if ($produtos) {
                $this->response($produtos, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Nenhum produto encontrado'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $produto = $this->produto_model->get_produto($id);
            if ($produto) {
                $this->response($produto, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Produto não encontrado'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
    
    
    public function index_post() {
        $config['upload_path'] = './uploads/produtos/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; 
        $config['encrypt_name'] = TRUE; 
       
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        
        $this->load->library('upload', $config);
        
        
        $data = [
            'nome' => $this->post('nome'),
            'descricao' => $this->post('descricao'),
            'preco' => $this->post('preco'),
            'quantidade' => $this->post('quantidade'),
            'imagem_url' => NULL 
        ];
        
        
        if (!empty($_FILES['imagem']['name'])) {
            if (!$this->upload->do_upload('imagem')) {
                // Erro no upload
                $error = $this->upload->display_errors('', '');
                $this->response([
                    'status' => FALSE,
                    'message' => $error
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            } else {
                $upload_data = $this->upload->data();
                $image_path = 'uploads/produtos/' . $upload_data['file_name'];
                $data['imagem_url'] = $image_path;
            }
        }
        
        
        $produto_id = $this->produto_model->criar_produto($data);
        
        if ($produto_id) {
            $produto = $this->produto_model->get_produto($produto_id);
            $this->response($produto, REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Erro ao criar produto'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
   
    public function index_put($id) {
        $produto_atual = $this->produto_model->get_produto($id);
        if (!$produto_atual) {
            $this->response([
                'status' => FALSE,
                'message' => 'Produto não encontrado'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }
        
        $data = [];
        
        if ($this->put('nome') !== NULL) {
            $data['nome'] = $this->put('nome');
        }
        
        if ($this->put('descricao') !== NULL) {
            $data['descricao'] = $this->put('descricao');
        }
        
        if ($this->put('preco') !== NULL) {
            $data['preco'] = $this->put('preco');
        }
        
        if ($this->put('quantidade') !== NULL) {
            $data['quantidade'] = $this->put('quantidade');
        }
        
        if (empty($data)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Nenhum dado fornecido para atualização'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        
        if ($this->produto_model->atualizar_produto($id, $data)) {
            $produto = $this->produto_model->get_produto($id);
            $this->response([
                'status' => TRUE,
                'message' => 'Produto atualizado com sucesso',
                'produto' => $produto
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Erro ao atualizar produto'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function index_delete($id) {
        if ($this->produto_model->deletar_produto($id)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Produto deletado com sucesso'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Erro ao deletar produto'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function atualizar_imagem_post($id) {
        $produto = $this->produto_model->get_produto($id);
        if (!$produto) {
            $this->response([
                'status' => FALSE,
                'message' => 'Produto não encontrado'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }
        
        $config['upload_path'] = './uploads/produtos/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
       
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        
        $this->load->library('upload', $config);
        
        if (!empty($_FILES['imagem']['name'])) {
            if (!$this->upload->do_upload('imagem')) {
                $error = $this->upload->display_errors('', '');
                $this->response([
                    'status' => FALSE,
                    'message' => $error
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            } else {
                // Remove a imagem antiga se existir
                if (!empty($produto->imagem_url)) {
                    $old_image = str_replace(base_url(), '', $produto->imagem_url);
                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }
                
                $upload_data = $this->upload->data();
                $image_path = 'uploads/produtos/' . $upload_data['file_name'];
                
                // Atualiza apenas o campo imagem_url
                $data = ['imagem_url' => $image_path];
                
                if ($this->produto_model->atualizar_produto($id, $data)) {
                    $produto_atualizado = $this->produto_model->get_produto($id);
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Imagem do produto atualizada com sucesso',
                        'produto' => $produto_atualizado
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Erro ao atualizar imagem do produto'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Nenhuma imagem foi enviada'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}