<?php

namespace App;

use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class User extends Model {
    use HasSoftDelete;

    protected $table = "users";
    protected $fillable = ['email', 'first_name', 'last_name', 'avatar', 'status', 'is_active', 'password', 'verify_token', 'user_type', 'remember_token', 'remember_token_expire'];
    protected $casts = ['avatar' => 'array'];
    protected $deletedAt = 'deleted_at';

    public function posts() {
        return $this->hasMany('\App\Post', 'user_id', 'id');
    }

    public function ads() {
        return $this->hasMany('\App\Ads', 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany('\App\Comment', 'user_id', 'id');
    }

    public function author() {
        return $this->first_name . ' ' . $this->last_name;
    }
}