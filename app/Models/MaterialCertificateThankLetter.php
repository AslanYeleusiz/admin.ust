<?php

namespace App\Models;

use App\Models\Material\Material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialCertificateThankLetter extends Model
{
    /** old table algis_xat */

    use SoftDeletes;

    public function material(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
