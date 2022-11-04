<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialCertificate extends Model
{
    /** old table marapattau */

    use SoftDeletes;

    public function scopeCertificate($query, $materialId)
    {
        return $query->where('material_id', $materialId);
    }

    public function material(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
