<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Blog extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'thumbnail', 'author', 'status', 'show_on_home'];
}
