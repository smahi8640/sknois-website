<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library

class Articles extends BaseController
{

    

    public function index()
    {

         if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('admin');
        }
        
	    $data['title'] = 'Blogs';
	    $data['records'] = $this->db->query("select * from articles")->getResult();
	    return view('admin/pages/articles/index',$data);

    }

    public function view($id = NULL)
    {
        
        $data['title'] = 'Blogs';
        if($id){
	        $data['record'] = $this->db->query("select * from articles where id='".$id."'")->getRow();
        }
	    return view('admin/pages/articles/add',$data);
	    
	   
    }

    public function add()
    {
        $config = array(
            'field' => 'alias',
            'title' => 'title',
            'table' => 'articles',
            'id' => 'id',
        );
        $Slug = new Slug($config);
        $this->currentuser = $this->ionAuth->user()->row();
        $id = $this->request->getPost('id');
        if(empty($id)){
        $title = $this->request->getPost('title');
        $aliasTemp = $this->request->getPost('alias');
        if($aliasTemp == '') {
            $data = array(
                'title' => $title,
            );
        } else {
            $data = array(
                'title' => $aliasTemp,
            );
        }

        $record = array();
        $record['title'] = $title;
        $record['alias'] = $Slug->create_uri($data);;
        $record['description'] = $this->request->getPost('description');
        $record['image'] = $this->request->getPost('image');
        $record['status'] = $this->request->getPost('status');
        $record['created_by'] = $this->currentuser->id;
        $record['created_date'] = date('Y-m-d H:i:s');
       $this->db->table('articles')->insert($record);
        echo json_encode(array('status'=>1,'message'=>'Record has been added successfully'));    
        }else{
        $title = $this->request->getPost('title');
        $aliasTemp = $this->request->getPost('alias');
        if($aliasTemp == '') {
            $data = array(
                'title' => $title,
            );
        } else {
            $data = array(
                'title' => $aliasTemp,
            );
        }

        $record = array();
        $record['title'] = $title;
        $record['alias'] = $Slug->create_uri($data, $id);;
        $record['description'] = $this->request->getPost('description');
        $record['image'] = $this->request->getPost('image');
        $record['status'] = $this->request->getPost('status');
        $record['created_by'] = $this->request->getPost('created_by');
        $record['updated_by'] = $this->currentuser->id;
        $record['updated_date'] = date('Y-m-d H:i:s');
        $this->db->table('articles')->where('id',$id)->update($record);
        echo json_encode(array('status'=>1,'message'=>'Record has been updated successfully'));
        }
           

        
    }


    public function delete()
    {
        
        
        $id = $this->request->getPost('id');
        if(is_null($id) || empty($id))
        {
            echo json_encode(array('status'=>0,'message'=>'There is no data to delete'));
        }
        else
        {
            if(!is_array($id)) {
                $id = array($id);
            }

            foreach ($id AS $i) {
                $this->db->table('articles')->where('id',$i)->delete();
            }
             echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
        }
        
        
    }




}