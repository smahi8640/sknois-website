<?php namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Forms extends BaseController
{

   
    public function contact()
    {
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Contact';
	    $data['records'] = $this->db->query("select * from contact")->getResult();
	    return view('admin/pages/forms/contact',$data);
	    
        
    }

    public function delete_contact()
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
                $this->db->table('contact')->where('id',$i)->delete();
            }
             echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
        }

        
    }
    
    public function subscribers()
    {
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Subscribers';
	    $data['records'] = $this->db->query("select * from subscribers")->getResultArray();
	    return view('admin/pages/forms/subscribers',$data);
	    
        
    }

    public function delete_subscribers()
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
                $this->db->table('subscribers')->where('id',$i)->delete();
            }
             echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
        }

        
    }

    
}