<?php

   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class product_categories extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('product_model');
    }

	public function index_get()
	{
        $data = $this->product_model->product_category_list("api");
        $this->response($data, REST_Controller::HTTP_OK);
	}

    public function index_post()
    {
        $ins_array=array(
            "name" => $this->input->post('name'),
            "description" => $this->input->post('description'),
            "added_on" => date('Y-m-d H:i:s'),
        );

        $data = $this->product_model->submit_product_category_form($ins_array,"insert");

        if(isset($data['insert_id']) && $data['insert_id']>0){
            $this->response(['Category added successfully.'], REST_Controller::HTTP_OK);
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
            "updated_on" => date('Y-m-d H:i:s'),
        );

        $data = $this->product_model->submit_product_category_form($ins_array,"update",$_REQUEST['product_category_id']);

        if(isset($data['insert_id']) && $data['insert_id']>0){
            $this->response(['Category updated successfully.'], REST_Controller::HTTP_OK);
        }else{
            $this->response(['Something went wrong.'], REST_Controller::HTTP_OK);
        }

    }

    public function index_delete()
    {
        $data = $this->product_model->delete_product_category($_REQUEST['id']);

        if(isset($data['affected_id']) && $data['affected_id']>0){
            $this->response(['Product category deleted successfully..'], REST_Controller::HTTP_OK);
        }else{
            $this->response(['Something went wrong.'], REST_Controller::HTTP_OK);
        }
    }

}