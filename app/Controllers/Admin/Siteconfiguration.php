<?php namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\MyCustomBackup;
use App\Libraries\Slug; 

class Siteconfiguration extends BaseController
{

   
    public function index()
    {
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Settings';
	    $data['record'] = $this->db->query("select * from settings_siteconfiguration")->getRow();
	    return view('admin/pages/settings/add',$data);
	    
        
    }

   public function importFile(){
	  $this->db->table('products')->where('1','1')->delete();
       // print_r(FCPATH);
        // Reading file
        $file = fopen("/home/u347356813/domains/brighthardwaremart.com/public_html/dev/public/list.csv","r");
        
	 $config = array(
                    'field' => 'alias',
                    'title' => 'title',
                    'table' => 'products',
                    'id' => 'id',
                );
	$Slug = new Slug($config);
        $i = 0;
        $numberOfFields = 11; // Total number of fields
        $importData_arr = array();
        // Initialize $importData_arr Array
        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            
            // Skip first row & check number of fields
            if($i > 0 && $num == $numberOfFields){ 
               
                // Key names are the insert table field names - name, email, city, and status
                $cat=explode(',',$filedata[0]);
                $cat_id=array();
                foreach($cat as $c){
                   
                    $category= $this->db->query("select * from categories where title='".trim($c)."'")->getRowArray();
                    $cat_id[]=$category['id'];
                }
                
                $brand=$this->db->query("select * from brands where title='".$filedata[1]."'")->getRowArray();
               
                
                $alias=$Slug->create_uri(['title' => $filedata[2]]);
                if(!empty($category) && !empty($brand)){
                $importData_arr[$i]['category_id'] = implode(',',$cat_id);
                $importData_arr[$i]['brand_id'] = $brand['id'];
                $importData_arr[$i]['title'] = $filedata[2];
                $importData_arr[$i]['alias'] = $Slug->create_uri(['title' => $filedata[2]]);
                $importData_arr[$i]['description'] = $filedata[3];
                $importData_arr[$i]['image'] = $filedata[4];
                $importData_arr[$i]['style_no'] = $filedata[5];
                $importData_arr[$i]['pack_size'] = $filedata[6];
                $importData_arr[$i]['video'] = $filedata[7];
                $importData_arr[$i]['meta_title'] = $filedata[8];
                $importData_arr[$i]['meta_tag'] = $filedata[8];
                $importData_arr[$i]['meta_description'] = $filedata[9];
                $importData_arr[$i]['pdf'] = $filedata[10];

		$data = [
                        'category_id' => implode(',',$cat_id),
                        'brand_id' => $brand['id'],
                        'title' => $filedata[2],
                        'alias' => $Slug->create_uri(['title' => $filedata[2]]),
                        'image'  => $filedata[4],
                        'style_no'  => $filedata[5],
                        'pack_size'  => $filedata[6],
                        'description'  => $filedata[3],
                        'video'  => $filedata[7],
                        'meta_description'  => $filedata[9],
                        'meta_tag'  => $filedata[8],
                        'meta_title'  => $filedata[8],
                        'pdf'  => $filedata[10],
                        'created_at'  => date('Y-m-d H:i:s')
                ];
		$this->db->table('products')->insert($data);
                }
            }
            $i++;
        }
        fclose($file);
        // Insert data
        $count = 0;
        foreach($importData_arr as $userdata){
            
            //$this->db->table('products')->insert($userdata);
                
            
        }

    }

    public function add()
    {   
        
        
			helper('form');
			if($this->validate(['site_name'  => 'required']))
			{
            $site_name = $this->request->getPost('site_name');
            $site_logo=$this->request->getPost('site_logo');
            $site_brochure=$this->request->getPost('site_brochure');
            $site_email=$this->request->getPost('site_email');
            $email1=$this->request->getPost('email1');
            $email2=$this->request->getPost('email2');
            $email3=$this->request->getPost('email3');
            $site_mobile = $this->request->getPost('site_mobile');
            $mobile1=$this->request->getPost('mobile1');
            $site_website=$this->request->getPost('site_website');
            $site_address=$this->request->getPost('site_address');
            $showroom_address=$this->request->getPost('showroom_address');
            $site_timings = $this->request->getPost('site_timings');
            $site_fb=$this->request->getPost('site_fb');
            $site_twitter=$this->request->getPost('site_twitter');
            $site_insta = $this->request->getPost('site_insta');
            $site_linked=$this->request->getPost('site_linked');
            $privacy_policy=$this->request->getPost('privacy_policy');
            $exchange_return=$this->request->getPost('exchange_return');
            $products=$this->request->getPost('products');
            $categories=$this->request->getPost('categories');
            $enquiry=$this->request->getPost('enquiry');
            $id=1;
                  
            $data = [
                    'site_title' => $site_name,
                    'site_logo'  => $site_logo,
                    //'site_brochure'  => $site_brochure,
                    'site_email'  => $site_email,
                    //'site_email'  => $email1,
                    //'email2'  => $email2,
                    //'email3'  => $email3,
                    'site_contact_number' => $site_mobile,
                    //'mobile1' => $mobile1,
                    //'site_website'  => $site_website,
                    //'site_address'  => $site_address,
                    //'showroom_address'  => $showroom_address,
                    //'site_timings' => $site_timings,
                    'site_facebook_url'  => $site_fb,
                    'site_twitter_url'  => $site_twitter,
                    'site_instagram_url' => $site_insta,
                    //'site_linked'  => $site_linked,
                    'privacy_policy'  => $privacy_policy,
                    'exchange_return'  => $exchange_return,
                    //'brands'  => $brands,
                    //'products'  => $products,
                    //'categories'  => $categories,
                    //'enquiry'  => $enquiry
            ];
            $this->db->table('settings_siteconfiguration')->where('id',$id)->update($data);
            echo json_encode(array('status'=>1,'message'=>'Record has been updated successfully.'));
            
           
            
            
        }
        else
        {
          echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }
    }
    
    public function backup()
    {
        $prefs = array(
            'format' => 'zip',
            'filename' => 'my_db_backup.sql',
        );

        $util = new MyCustomBackup($this->db);
        $backup = $util->backup_zip($prefs);

        $zipname = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$zipname");
        header("Content-length: " . filesize($zipname));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile($zipname);
    }
    
    
    public function changepassword()
    {
        $session = session();
	    if(empty($session->has('email'))){
            return redirect()->to('login');
        }
        if($this->validate(['password'  => 'required']))
		{
		    $password=$this->request->getPost('password');
		    $cpassword=$this->request->getPost('cpassword');
		    if($password==$cpassword){
		     $data = [
                    'password' => $password,
                    ];
		    $this->db->table('users')->where('id','1')->update($data);
		        echo json_encode(array('status'=>1,'message'=>'Password Change Successfully'));
		    }else{
		        echo json_encode(array('status'=>0,'message'=>'Password and Confirm password not Matched'));
		    }
		}else{
	    $data['title'] = 'Change Password';
	    return view('admin/pages/changepassword',$data);
		}
    }
}