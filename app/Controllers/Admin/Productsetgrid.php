<?php 

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library
use App\Models\CategoriesModel;

class Productsetgrid extends BaseController
{
    
   
    public function index()
    {
        
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('admin');
        }
        
	    $data['title'] = 'List View';
	    $data['records'] = $this->db->query("select * from products_set order by disp_order ASC")->getResultArray();
	    //$data['rel_products'] = $this->db->query("select * from products")->getResultArray();
       
	    return view('admin/pages/products_set/index1',$data);
	    
        
    }

    public function index_grid()
    {
        
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('admin');
        }
        
	    $data['title'] = 'Grid View';
	    $data['records'] = $this->db->query("select * from products_set order by disp_order ASC")->getResultArray();
	    //$data['rel_products'] = $this->db->query("select * from products")->getResultArray();
       
	    return view('admin/pages/products_set/index_grid',$data);
	    
        
    }

    public function product_list()
    {
        $session = session();
        if(empty($session->has('email'))){
            return redirect()->to('login');
        }
        $CategoriesModel = new CategoriesModel();
        $data['title'] = 'Products';
        $data['records'] = $this->db->query("select * from products_set order by disp_order ASC")->getResultArray();
        return view('admin/pages/products/product_list',$data);   
    }

    public function getProductList(){
        $draw = $this->request->getPost('draw');
        $res = $this->db->query("select * from products_set order by disp_order ASC")->getResultArray();
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => count($res),
            "recordsFiltered" => count($res),
            "data" => $res
        );
        echo json_encode($response);
    }


    public function updateordering() {

        $position = $this->request->getPost('position');

        $i=1;
        foreach($position as $k=>$v){

            $record = array();
            $record['disp_order'] = $i;
            $this->db->table('products_set')->where('id',$v)->update($record);
            $i++;
        }       
        
        echo json_encode(array('status'=>1,'message'=>'Your ordering changed successfully.'));
        exit;

    }

    
}