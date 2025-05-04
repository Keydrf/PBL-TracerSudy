<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerusahaanModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perusahaan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'perusahaan_id';

    /**
     * Indicates if the primary key is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_atasan',
        'instansi',
        'nama_instansi',
        'no_telepon',
        'email',
        'nama_alumni',
        'program_studi',
        'tahun_lulus',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_lulus' => 'datetime',
    ];

    public function surveiAlumni()
    {
        return $this->belongsTo(SurveiAlumniModel::class, 'survei_alumni_id');
    }
}
