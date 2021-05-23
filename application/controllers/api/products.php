<?php

   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class products extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('product_model');
    }

	public function index_get()
	{
        $data = $this->product_model->product_list("api");
        $this->response($data, REST_Controller::HTTP_OK);
	}

    public function index_post()
    {
        $ins_array=array(
            "name" => $this->input->post('name'),
            "description" => $this->input->post('description'),
            "price" => round($this->input->post('price'),2),
            "category_id" => $this->input->post('category_id'),
            "added_on" => date('Y-m-d H:i:s'),
        );

        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['max_width'] = 15000;
        $config['max_height'] = 15000;

        $this->load->library('upload', $config);

        if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('error_msg', $this->upload->display_errors());
            } else {
                $image_data = array('image_metadata' => $this->upload->data());
                $ins_array['image'] = $image_data['image_metadata']['file_name'];
            }
        }

        $data = $this->product_model->submit_product_form($ins_array,"insert");

        if(isset($data['insert_id']) && $data['insert_id']>0){
            $this->response(['Product added successfully.'], REST_Controller::HTTP_OK);
        }else{
            $this->response(['Something went wrong.'], REST_Controller::HTTP_OK);
        }

    }

    public function index_put()
    {
        parse_str(file_get_contents("php://input"),$post_vars);

        foreach ($post_vars as $key => $value){
            unset($post_vars[$key]);
            $post_vars[str_replace('amp;', '', $key)] = $value;
        }

        $_REQUEST = array_merge($_REQUEST, $post_vars);

        $ins_array=array(
            "name" => $_REQUEST['name'],
            "description" => $_REQUEST['description'],
            "price" => round($_REQUEST['price'],2),
            "category_id" => $_REQUEST['category_id'],
            "updated_on" => date('Y-m-d H:i:s'),
        );

        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['max_width'] = 15000;
        $config['max_height'] = 15000;

        $this->load->library('upload', $config);

        if(isset($_FILES['image']) && (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) ) {
            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('error_msg', $this->upload->display_errors());
            } else {
                $image_data = array('image_metadata' => $this->upload->data());
                $ins_array['image'] = $image_data['image_metadata']['file_name'];
            }
        }

        $data = $this->product_model->submit_product_form($ins_array,"update",$_REQUEST['product_id']);

        if(isset($data['insert_id']) && $data['insert_id']>0){
            $this->response(['Product updated successfully.'], REST_Controller::HTTP_OK);
        }else{
            $this->response(['Something went wrong.'], REST_Controller::HTTP_OK);
        }

    }

    public function index_delete()
    {
        $data = $this->product_model->delete_product($_REQUEST['id']);

        if(isset($data['affected_id']) && $data['affected_id']>0){
            $this->response(['Product deleted successfully..'], REST_Controller::HTTP_OK);
        }else{
            $this->response(['Something went wrong.'], REST_Controller::HTTP_OK);
        }
    }

}