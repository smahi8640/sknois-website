<?php 

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library
use App\Models\CategoriesModel;

class Categories extends BaseController
{

   
    public function index()
    {
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Categories';
        $CategoriesModel = new CategoriesModel();
	    // $data['records'] = $this->db->query("select * from categories")->getResultArray();
        $data['records'] = $CategoriesModel->fetchCategoryTreeAdmin();
	    return view('admin/pages/categories/index',$data);
	    
        
    }

    public function edit($id=NULL)
    {
        
        $data['title'] = 'Categories';
        
        if($id)
        {
            $data['record'] = $this->db->query("select * from categories where id='".$id."'")->getRow();
        }
        $data['parent_category'] = $this->db->query("select * from categories where parent_id='0'")->getResultArray();
        return view('admin/pages/categories/add', $data);
        
        
    }

    public function add()
    {   

        $session = session();

        $config = array(
            'field' => 'alias',
            'title' => 'title',
            'table' => 'categories',
            'id' => 'id',
        );
        $Slug = new Slug($config);

        $id = $this->request->getPost('id');
                
        /*helper('form');
        if($this->validate(['title'  => 'required']))
        {*/

            $title = $this->request->getPost('title');
            $image = $this->request->getPost('image');
            $description = $this->request->getPost('description');
            $meta_tag = $this->request->getPost('meta_tag');
            $meta_description = $this->request->getPost('meta_description');
            $meta_title = $this->request->getPost('meta_title');
            $display_order = $this->request->getPost('display_order');
            $parent_category = $this->request->getPost('parent_category');
            $status = $this->request->getPost('status');

            if($id) {
            
                $data = [
                        'title' => $title,
                        'alias' => $Slug->create_uri(['title' => $title], $id),
                        'description'  => $description,
                        'image'  => $image,
                        'meta_description'  => $meta_description,
                        'meta_tags'  => $meta_tag,
                        'meta_title'  => $meta_title,
			            'display_order'  => $display_order,
			            'status' => $status,
                        'parent_id' => $parent_category,
                        'updated_date'  => date('Y-m-d H:i:s')
                ];
                $this->db->table('categories')->where('id',$id)->update($data);
                echo json_encode(array('status'=>1,'message'=>'Record has been updated successfully.'));
            
            } else {
            
                $data = [
                        'title' => $title,
                        'alias' => $Slug->create_uri(['title' => $title]),
                        'description'  => $description,
                        'image'  => $image,
                        'meta_description'  => $meta_description,
                        'meta_tags'  => $meta_tag,
                        'meta_title'  => $meta_title,
    		            'display_order'  => $display_order,
    		            'status' => $status,
                        'parent_id' => $parent_category,
                        'created_date'  => date('Y-m-d H:i:s')
                ];
                $this->db->table('categories')->insert($data);

                echo json_encode(array('status'=>2,'message'=>'Record has been added successfully.'));

            }
                        
        /*}
        else
        {
          echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }*/
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
                $this->db->table('categories')->where('id',$id)->delete();
            }

            echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
        }

        
    }

    
}