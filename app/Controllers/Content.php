<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Content extends BaseController
{

   
    public function about()
    {
	    $data['title'] = 'About Us';
	    
	    return view('frontend/pages/content/about',$data);
	    
        
    }
    public function advantages()
    {
	    $data['title'] = 'Advantages';
	    
	    return view('frontend/pages/content/advantages',$data);
	    
        
    }
    
    
    public function privacy()
    {
	    $data['title'] = 'Privacy Policy';
	    $data['siteconfiguration'] = $this->db->query("select * from settings_siteconfiguration")->getRow();
	    return view('frontend/pages/content/privacy',$data);
	    
        
    }
    
    public function exchange()
    {
	    $data['title'] = 'Exchange and Return';
	    $data['siteconfiguration'] = $this->db->query("select * from settings_siteconfiguration")->getRow();
	    return view('frontend/pages/content/exchange',$data);
	    
        
    }
    
    public function faqs()
    {
	    $data['title'] = 'Faqs';
	    
	    return view('frontend/pages/content/faq',$data);
	    
        
    }
    
    public function blog()
    {
	    $data['title'] = 'Blogs';
	    $data['blogarticles'] = $this->db->query("select * from articles")->getResult();
	    return view('frontend/pages/blog',$data);
	    
        
    }
    
    public function blogdetails($alias = NULL)
    {
	    $data['title'] = 'Blogs';
	    $data['blogarticles'] = $this->db->query("select * from articles where alias='".$alias."'")->getResult();
	    return view('frontend/pages/blogdetails',$data);
	    
        
    }
    
    

}