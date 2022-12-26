<?php 

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
//use App\Libraries\Upload;   // use the Slug Library

class Media extends BaseController {

	public function index()
    {
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('login');
        }
        
	    $data['title'] = 'Media';
        
	    return view('admin/pages/media',$data);
	    
        
    }
	
	function upload(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}

   
   function charms(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/CHARMS";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}
	
	function rings(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/RINGS";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}
	
	function bracelets(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/BRACELETS";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}
	
	function earrings(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/EARRINGS";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}
	
	function pendants(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/PENDANTS";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}
	
	function necklaces(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/NECKLACES";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}
	
	function misc(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/MISC";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}
	
	function category(){
	    
		if($this->request->getFileMultiple("image")) {
		    $filepath = "../public/media/source/category";
		    //$intro_image = $this->request->getFileMultiple("image");
		    
 
         foreach($this->request->getFileMultiple('image') as $intro_image)
         {   
		    if($intro_image->move($filepath,$intro_image->getName())){
		        
		    }
		    else{
	        	    
	        	}
         }
         echo json_encode(array('status'=>1,'message'=>'File uploaded successfully'));
		}else{
		    echo json_encode(array('status'=>1,'message'=>'File not found'));	
		
		}
	}

}