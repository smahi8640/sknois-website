<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';

    protected $primaryKey = 'id';

    protected $allowedFields = [
                                'user_id',
                                'session_id', 
                                'cart_row_id', 
                                'product_id',
                                'title',
                                'qty',
                                'style_no',
                                'created_by',
                                'created_at',
                                'updated_by',
                                'updated_at',
                               ];
}