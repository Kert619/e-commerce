<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeCategory extends Model
{
    use HasFactory;

    public function attributeGroups(): HasMany
    {
        return $this->hasMany(AttributeGroup::class, 'attribute_group_id');
    }

    public function attributeDefinitions(): HasMany
    {
        return $this->hasMany(AttributeDefinition::class, 'attribute_group_id');
    }
}
