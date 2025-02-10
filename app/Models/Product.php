<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @var array<string> $fillable
     */
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
    public $timestamps = false;
}
