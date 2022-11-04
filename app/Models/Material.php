<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    const FILE_PATH = 'files/materials/';
    const CERTIFICATE_PATH = 'images/certificates/';
    protected $guarded = [];
    protected $table = 'doc';
    protected $attributes = [
        'ssilka_video' => '',
        'view' => 0,
        'download' => 0,
        'likes' => 0,
        'dislikes' => 0,
        'chec' => 0,
        'converted' => 0,
        'moved' => 0,
        'deleteorder' => 0,
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function certificateThankLetter(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MaterialCertificateThankLetter::class, 'material_id', 'id');
    }

    public function certificateHonor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MaterialCertificateHonor::class, 'material_id', 'id');
    }

    public function certificate(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MaterialCertificate::class, 'material_id', 'id');
    }

    public function scopeNotDeletes($query)
    {
        return $query->where('deleteorder', '!=', 2);
    }
}
