<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'description', 'image_path'])]
class CreativeActivity extends Model
{
    use HasFactory;

    /**
     * @return HasMany<MasterClass, $this>
     */
    public function masterClasses(): HasMany
    {
        return $this->hasMany(MasterClass::class, 'activity_id');
    }
}
