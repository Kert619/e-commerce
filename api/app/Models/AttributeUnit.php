<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeUnit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attributeDefinitions(): HasMany
    {
        return $this->hasMany(AttributeDefinition::class, 'attribute_unit_id');
    }
}
