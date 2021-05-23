<?php
class Product_model extends CI_model{

    public function product_category_list($called_from='web'){

        $whereCond = $totalRow = NULL;
        $result = $row_data = array();

        if($called_from=='web'){
            $page = isset($_POST['iDisplayStart']) ? intval($_POST['iDisplayStart']) : 0;
            $rows = isset($_POST['iDisplayLength']) ? intval($_POST['iDisplayLength']) : 25;
            $order = isset($_POST["sSortDir_0"]) ? $_POST["sSortDir_0"] : NULL;
            $chr = isset($_POST["sSearch"]) ? $_POST["sSearch"] : NULL;
            $sEcho = isset($_POST['sEcho']) ? $_POST['sEcho'] : 1;
            $chr = str_replace(array('_', '%'), array('\_', '\%'), $chr);

            $columns = isset($_POST["sColumns"]) ? explode(',', $_POST["sColumns"]) : array();
            $iSortCol = isset($_POST["iSortCol_0"]) ? $_POST["iSortCol_0"] : NULL;
            $sort = isset($iSortCol) ? $columns[$iSortCol] : NULL;
            $offset = $page;
        }else{
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 25;
            $order = isset($_GET["order"]) ? $_GET["order"] : NULL;
            $chr = isset($_GET["keyword"]) ? $_GET["keyword"] : NULL;
            $chr = str_replace(array('_', '%'), array('\_', '\%'), $chr);
            $sort = 'name';
            $offset = ($page-1)*$rows;
        }


        if (isset($chr) && $chr != '') {
            $whereCond = " WHERE name LIKE '%" . $chr . "%' OR description LIKE '%" . $chr . "%' ";
        }

        if (isset($sort))
            $sorting = $sort . ' ' . $order;
        else
            $sorting = ' name ASC';

        $sql= "SELECT id,name,description,added_on FROM tbl_product_category ".$whereCond." ORDER BY ".$sorting;
        $sql_with_limit = $sql . " LIMIT " . $offset . " ," . $rows . " ";

        $totalRow = $this->db->query($sql)->num_rows();
        $qrySel = $this->db->query($sql_with_limit)->result_array();

        $response['categories'] = $qrySel;
        if($called_from=='web'){
            $response['totalRow'] = $totalRow;
        }else{
            $response['total_pages'] = ceil($totalRow/$rows);
        }

        return $response;
    }

    public function product_list($called_from='web'){

        $whereCond = $totalRow = NULL;
        $result = $row_data = array();

        if($called_from=='web'){
            $page = isset($_POST['iDisplayStart']) ? intval($_POST['iDisplayStart']) : 0;
            $rows = isset($_POST['iDisplayLength']) ? intval($_POST['iDisplayLength']) : 25;
            $order = isset($_POST["sSortDir_0"]) ? $_POST["sSortDir_0"] : NULL;
            $chr = isset($_POST["sSearch"]) ? $_POST["sSearch"] : NULL;
            $sEcho = isset($_POST['sEcho']) ? $_POST['sEcho'] : 1;
            $chr = str_replace(array('_', '%'), array('\_', '\%'), $chr);

            $columns = isset($_POST["sColumns"]) ? explode(',', $_POST["sColumns"]) : array();
            $iSortCol = isset($_POST["iSortCol_0"]) ? $_POST["iSortCol_0"] : NULL;
            $sort = isset($iSortCol) ? $columns[$iSortCol] : NULL;
            $offset = $page;
        }else{
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 25;
            $order = isset($_GET["order"]) ? $_GET["order"] : NULL;
            $chr = isset($_GET["keyword"]) ? $_GET["keyword"] : NULL;
            $chr = str_replace(array('_', '%'), array('\_', '\%'), $chr);
            $sort = 'name';
            $offset = ($page-1)*$rows;
        }

        if (isset($chr) && $chr != '') {
            $whereCond = " WHERE p.name LIKE '%" . $chr . "%' OR p.description LIKE '%" . $chr . "%' OR p.price LIKE '%" . $chr . "%' OR pc.name LIKE '%" . $chr . "%' ";
        }

        if (isset($sort))
            $sorting = $sort . ' ' . $order;
        else
            $sorting = ' p.name ASC';

        $sql= "SELECT p.id,p.name,p.image,p.description,p.price,p.added_on,pc.name AS category_name FROM tbl_product AS p LEFT JOIN tbl_product_category AS pc ON pc.id=p.category_id ".$whereCond." ORDER BY ".$sorting;
        $sql_with_limit = $sql . " LIMIT " . $offset . " ," . $rows . " ";

        $totalRow = $this->db->query($sql)->num_rows();
        $qrySel = $this->db->query($sql_with_limit)->result_array();

        $response['products'] = $qrySel;
        if($called_from=='web'){
            $response['totalRow'] = $totalRow;
        }else{
            $response['total_pages'] = ceil($totalRow/$rows);
        }

        return $response;
    }

    public function product_form($product_id=0){
        $response = array();
        if($product_id>0){
            $response= $this->db->query("SELECT id,name,image,description,price,category_id FROM tbl_product WHERE id=?",array($product_id))->result_array();
        }

        return $response;
    }

    public function product_category_dd(){
        $response= $this->db->query("SELECT id,name FROM tbl_product_category ORDER BY name ASC ")->result_array();
        return $response;
    }

    public function submit_product_form($ins_array,$status,$product_id=''){
        $response = array();

        if($status=='insert'){
            $this->db->insert('tbl_product', $ins_array);
            $response['insert_id'] = $this->db->insert_id();
        }else{
            if($product_id>0){
                $update_id = $product_id;
            }else{
                $update_id = $this->input->post('product_id');
            }
            $this->db->update('tbl_product', $ins_array, array('id' => $update_id));
            $response['insert_id'] = $this->db->affected_rows();
        }

        return $response;
    }

    public function product_category_form($product_category_id=0){
        $response = array();
        if($product_category_id>0){
            $response= $this->db->query("SELECT id,name,description FROM tbl_product_category WHERE id=?",array($product_category_id))->result_array();
        }

        return $response;
    }

    public function submit_product_category_form($ins_array,$status,$product_category_id=''){
        $response = array();

        if($status=='insert'){
            $this->db->insert('tbl_product_category', $ins_array);
            $response['insert_id'] = $this->db->insert_id();
        }else{
            if($product_category_id>0){
                $update_id = $product_category_id;
            }else{
                $update_id = $this->input->post('product_category_id');
            }
            $this->db->update('tbl_product_category', $ins_array, array('id' => $update_id));
            $response['insert_id'] = $this->db->affected_rows();
        }

        return $response;
    }

    public function delete_product_category($product_category_id=0){
        $response = array();
        if($product_category_id>0){
            $this->db->delete('tbl_product_category', array("id"=>$product_category_id));
            $response['affected_id'] = $this->db->affected_rows();
        }

        return $response;
    }

    public function delete_product($product_id=0){
        $response = array();
        if($product_id>0){
            $old_image_name = $this->db->query("SELECT image FROM tbl_product WHERE id=?",array($product_id))->result_array();
            $file_path = FCPATH.'upload/'.$old_image_name[0]['image'];

            if($old_image_name[0]['image']!='' && file_exists($file_path)){
                unlink($file_path);
            }
            $this->db->delete('tbl_product', array("id"=>$product_id));
            $response['affected_id'] = $this->db->affected_rows();
        }

        return $response;
    }
}


?>