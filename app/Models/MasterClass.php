<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['instructor_id', 'activity_id', 'title', 'description', 'date', 'time_slot', 'capacity', 'cost'])]
class MasterClass extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<User, $this>
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * @return BelongsTo<CreativeActivity, $this>
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(CreativeActivity::class, 'activity_id');
    }

    /**
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getAvailableSpotsAttribute(): int
    {
        return $this->capacity - $this->enrollments()->count();
    }
}
