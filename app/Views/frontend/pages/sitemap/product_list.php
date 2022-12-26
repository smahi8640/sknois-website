<?php echo'<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <?php foreach($products as $product) { 
        //$productdetails=$this->db->query("select * from product_details where product_id='".$product->id."'")->result();
        //foreach($productdetails as $productdetail) {
    ?>
    <url>
        <loc><?php echo base_url()."/products/".$product->alias.'-'.$product->style_no; ?></loc>
        <priority>0.5</priority>
        <changefreq>daily</changefreq>
    </url>
    <?php }//} ?>


</urlset>