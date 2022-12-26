<?php 

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library

class Brands extends BaseController
{

   
    public function index()
    {
       if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Brands';
	    $data['records'] = $this->db->query("select * from brands")->getResultArray();
	    return view('admin/pages/brands/index',$data);
	    
        
    }

    public function edit($id=NULL)
    {
        $data['title'] = 'Brands';
        
        if($id)
        {
            $data['record'] = $this->db->query("select * from brands where id='".$id."'")->getRow();
        }
        
        return view('admin/pages/brands/add', $data);
        
        
    }

    public function add()
    {   

        $session = session();

        $config = array(
            'field' => 'alias',
            'title' => 'title',
            'table' => 'brands',
            'id' => 'id',
        );
        $Slug = new Slug($config);

        $id = $this->request->getPost('id');
                
        helper('form');
        if($this->validate(['title'  => 'required']))
        {

            $title = $this->request->getPost('title');
            $image = $this->request->getPost('image');
	    $brochure = $this->request->getPost('brochure');
            $description = $this->request->getPost('description');
            $meta_tag = $this->request->getPost('meta_tag');
            $meta_description = $this->request->getPost('meta_description');
            $meta_title = $this->request->getPost('meta_title');
            $display_order = $this->request->getPost('display_order');

            if($id) {
            
                $data = [
                        'title' => $title,
                        'alias' => $Slug->create_uri(['title' => $title], $id),
                        'description'  => $description,
                        'image'  => $image,
			'brochure'  => $brochure,
                        'meta_description'  => $meta_description,
                        'meta_tag'  => $meta_tag,
                        'meta_title'  => $meta_title,
			'display_order'  => $display_order,
                        'updated_at'  => date('Y-m-d H:i:s')
                ];
                $this->db->table('brands')->where('id',$id)->update($data);
                echo json_encode(array('status'=>1,'message'=>'Record has been updated successfully.'));
            
            } else {
            
                $data = [
                        'title' => $title,
                        'alias' => $Slug->create_uri(['title' => $title]),
                        'description'  => $description,
                        'image'  => $image,
			'brochure'  => $brochure,
                        'meta_description'  => $meta_description,
                        'meta_tag'  => $meta_tag,
                        'meta_title'  => $meta_title,
			'display_order'  => $display_order,
                        'created_at'  => date('Y-m-d H:i:s')
                ];
                $this->db->table('brands')->insert($data);

                echo json_encode(array('status'=>2,'message'=>'Record has been added successfully.'));

            }
                        
        }
        else
        {
          echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }
    }


    public function delete()
    {
        $id = $this->request->getPost('id');

        if(is_null($id) || empty($id)) {
            
            echo json_encode(array('status'=>0,'message'=>'There is no data to delete'));

        } else {

            if(!is_array($id)) {
                $id = array($id);
            }

            foreach ($id AS $i) {
                $this->db->table('brands')->where('id',$id)->delete();
            }

            echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
        }

        
    }

    
}