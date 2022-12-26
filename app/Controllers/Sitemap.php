<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CategoriesModel;

class Sitemap  extends BaseController {


    /**
     * Index Page for this controller.
     *
     */
    public function category()
    {
        
        $data['items'] = $this->db->query("select * from categories where status='1'")->getResult();

        return view('frontend/pages/sitemap/category_list',$data);
    }
    
    public function products()
    {
        $data['products'] = $this->db->query("select * from products where status='1'")->getResult();

        return view('frontend/pages/sitemap/product_list',$data);
    }
}