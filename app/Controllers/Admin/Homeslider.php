<?php 

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library

class Homeslider extends BaseController
{

   
    public function index()
    {
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Home slider';
	    $data['records'] = $this->db->query("select * from settings_homeslider order by display_order asc")->getResultArray();
	    return view('admin/pages/homeslider/index',$data);
    }

    public function edit($id=NULL)
    {
        $data['title'] = 'Home slider';
        if($id)
        {
            $data['record'] = $this->db->query("select * from settings_homeslider where id='".$id."'")->getRow();
        }
        return view('admin/pages/homeslider/add', $data);   
    }

    public function add()
    {   
        $this->currentuser = $this->ionAuth->user()->row();
        $id = $this->request->getPost('id');
        $image = $this->request->getPost('image');
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $display_order = $this->request->getPost('display_order');
        if($id) {
            $data = [
                'image' => $image,
                'title' => $title,
                'description' => $description,
                'display_order' => $display_order,
                'updated_at'  => date('Y-m-d H:i:s')
            ];
            $this->db->table('settings_homeslider')->where('id',$id)->update($data);
            echo json_encode(array('status'=>1,'message'=>'Record has been updated successfully.'));
        } else {
            $data = [
                'image' => $image,
                'title' => $title,
                'description' => $description,
                'display_order' => $display_order,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $this->db->table('settings_homeslider')->insert($data);
            echo json_encode(array('status'=>2,'message'=>'Record has been added successfully.'));
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
                $this->db->table('settings_homeslider')->where('id',$id)->delete();
            }
            echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
        }

        
    }

    
}