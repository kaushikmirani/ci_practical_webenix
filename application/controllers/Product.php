<?php

class Product extends CI_Controller {

    public function __construct(){

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('product_model');
        $this->load->library('session');
    }

    public function index(){
        $this->load->view("product_category_list.php");
    }

    public function product_category_list(){
        $whereCond = $totalRow = NULL;
        $result = $row_data = array();

        $sEcho = isset($_POST['sEcho']) ? $_POST['sEcho'] : 1;

        $data = $this->product_model->product_category_list("web");

        foreach ($data['categories'] as $fetchRes) {
            $operation = '';
            $operation .= '<span><a href="product/product_category_form?id='.$fetchRes["id"].'" class="btn default btn-xs black btnEdit"><i class="fa fa-edit"></i>&nbsp;Edit</a></span>';
            $operation .= '<span><a href="product/delete_product_category?id='.$fetchRes["id"].'" class="btn default btn-xs red btn-delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</a></span>';

            $final_array = array($fetchRes["id"]);
            $final_array = array_merge($final_array, array($fetchRes["name"]));
            $final_array = array_merge($final_array, array($fetchRes["description"]));
            $final_array = array_merge($final_array, array($fetchRes["added_on"]));
            $final_array = array_merge($final_array, array($operation));
            $row_data[] = $final_array;
        }

        $result["sEcho"] = $sEcho;
        $result["iTotalRecords"] = (int) $data['totalRow'];
        $result["iTotalDisplayRecords"] = (int) $data['totalRow'];
        $result["aaData"] = $row_data;

        echo json_encode($result);
    }

    public function product_list_view(){
        $this->load->view("product_list.php");
    }

    public function product_list(){
        $whereCond = $totalRow = NULL;
        $result = $row_data = array();

        $sEcho = isset($_POST['sEcho']) ? $_POST['sEcho'] : 1;

        $data = $this->product_model->product_list("web");

        foreach ($data['products'] as $fetchRes) {
            $operation = '';
            $operation .= '<span><a href="product_form?id='.$fetchRes["id"].'" class="btn default btn-xs black btnEdit"><i class="fa fa-edit"></i>&nbsp;Edit</a></span>';
            $operation .= '<span><a href="delete_product?id='.$fetchRes["id"].'" class="btn default btn-xs red btn-delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</a></span>';

            $product_image = '<img src="'.base_url('upload/').$fetchRes["image"].'" width="150px" height="150px">';

            $final_array = array($fetchRes["id"]);
            $final_array = array_merge($final_array, array($fetchRes["name"]));
            $final_array = array_merge($final_array, array($product_image));
            $final_array = array_merge($final_array, array($fetchRes["description"]));
            $final_array = array_merge($final_array, array($fetchRes["price"]));
            $final_array = array_merge($final_array, array($fetchRes["category_name"]));
            $final_array = array_merge($final_array, array($fetchRes["added_on"]));
            $final_array = array_merge($final_array, array($operation));
            $row_data[] = $final_array;
        }

        $result["sEcho"] = $sEcho;
        $result["iTotalRecords"] = (int) $data['totalRow'];
        $result["iTotalDisplayRecords"] = (int) $data['totalRow'];
        $result["aaData"] = $row_data;

        echo json_encode($result);
    }

    public function product_form(){
        if($this->input->get('id')>0){
            $product_id = $this->input->get('id');
        }else{
            $product_id = 0;
        }
        $data = $this->product_model->product_form($product_id);

        if(count($data)>0){
            $return_data = $data[0];
        }else{
            $return_data['id'] = '';
            $return_data['name'] = '';
            $return_data['image'] = '';
            $return_data['description'] = '';
            $return_data['price'] = '';
            $return_data['category_id'] = '';
        }

        $return_data['category_dd'] = $this->product_model->product_category_dd();

        $this->load->view("product_form.php",$return_data);
    }

    public function submit_product_form(){

        $ins_array=array(
            "name" => $this->input->post('name'),
            "description" => $this->input->post('description'),
            "price" => round($this->input->post('price'),2),
            "category_id" => $this->input->post('category_id')
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

        if($this->input->post('product_id')>0){
            $ins_array['updated_on'] = date('Y-m-d H:i:s');
            $status = "update";
        }else{
            $ins_array['added_on'] = date('Y-m-d H:i:s');
            $status = "insert";
        }

        $data = $this->product_model->submit_product_form($ins_array,$status);

        if(isset($data['insert_id']) && $data['insert_id']>0){
            $this->session->set_flashdata('success_msg', 'Product form submited successfully.');
            redirect('product/product_list_view');
        }else{
            $this->session->set_flashdata('error_msg', 'Something went wrong.');
            redirect('product/product_list_view');
        }
    }

    public function product_category_form(){
        if($this->input->get('id')>0){
            $product_category_id = $this->input->get('id');
        }else{
            $product_category_id = 0;
        }
        $data = $this->product_model->product_category_form($product_category_id);

        if(count($data)>0){
            $return_data = $data[0];
        }else{
            $return_data['id'] = '';
            $return_data['name'] = '';
            $return_data['description'] = '';
        }

        $this->load->view("product_category_form.php",$return_data);
    }

    public function submit_product_category_form(){

        $ins_array=array(
            "name" => $this->input->post('name'),
            "description" => $this->input->post('description')
        );

        if($this->input->post('product_category_id')>0){
            $ins_array['updated_on'] = date('Y-m-d H:i:s');
            $status = "update";
        }else{
            $ins_array['added_on'] = date('Y-m-d H:i:s');
            $status = "insert";
        }

        $data = $this->product_model->submit_product_category_form($ins_array,$status);

        if(isset($data['insert_id']) && $data['insert_id']>0){
            $this->session->set_flashdata('success_msg', 'Product category form submited successfully.');
            redirect();
        }else{
            $this->session->set_flashdata('error_msg', 'Something went wrong.');
            redirect();
        }
    }

    public function delete_product_category(){
        if($this->input->get('id')>0){
            $product_category_id = $this->input->get('id');
            $data = $this->product_model->delete_product_category($product_category_id);

            if(isset($data['affected_id']) && $data['affected_id']>0){
                $this->session->set_flashdata('success_msg', 'Product category has been de;eted successfully.');
                redirect();
            }else{
                $this->session->set_flashdata('error_msg', 'Something went wrong.');
                redirect();
            }
        }else{
            $this->session->set_flashdata('error_msg', "Something went wrong.");
            redirect();
        }
    }

    public function delete_product(){
        if($this->input->get('id')>0){
            $product_id = $this->input->get('id');
            $data = $this->product_model->delete_product($product_id);

            if(isset($data['affected_id']) && $data['affected_id']>0){
                $this->session->set_flashdata('success_msg', 'Product has been de;eted successfully.');
                redirect('product/product_list_view');
            }else{
                $this->session->set_flashdata('error_msg', 'Something went wrong.');
                redirect('product/product_list_view');
            }
        }else{
            $this->session->set_flashdata('error_msg', "Something went wrong.");
            redirect('product/product_list_view');
        }
    }

}

?>