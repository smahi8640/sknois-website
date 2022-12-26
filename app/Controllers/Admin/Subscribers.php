<?php namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Subscribers extends BaseController
{

   
    public function index()
    {
        $session = session();
	    if(empty($session->has('email'))){
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Subscribers';
	    $data['records'] = $this->db->query("select * from subscribers")->getResultArray();
	    return view('admin/pages/contact/subscribers',$data);
	    
        
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
                $this->db->table('subscribers')->where('id',$id)->delete();
            }
             echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
        }

        
    }

    
}