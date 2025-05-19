<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class SurveiAlumniModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survei_alumni';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'survei_alumni_id';

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
        'nim',
        'no_telepon',
        'email',
        'tahun_lulus',
        'tanggal_pertama_kerja',
        'masa_tunggu',
        'tanggal_pertama_kerja_instansi_saat_ini',
        'jenis_instansi',
        'nama_instansi',
        'skala',
        'lokasi_instansi',
        'profesi_id',
        'pendapatan',
        'alamat_kantor',
        'kabupaten',
        'kategori_id',
        'nama_atasan',
        'jabatan_atasan',
        'no_telepon_atasan',
        'email_atasan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_pertama_kerja' => 'datetime',
        'tanggal_pertama_kerja_instansi_saat_ini' => 'datetime',
        'tahun_lulus' => 'integer',
        'masa_tunggu' => 'integer',
        'profesi_id' => 'integer',
        'pendapatan' => 'integer',
        'kategori_id' => 'integer',
    ];

    /**
     * Define the relationship with the Alumni model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(AlumniModel::class, 'nim', 'nim');
    }

    /**
     * Define the relationship with the Profesi model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profesi(): BelongsTo
    {
        return $this->belongsTo(ProfesiModel::class, 'profesi_id', 'profesi_id');
    }

    /**
     * Define the relationship with the KategoriProfesi model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategoriProfesi(): BelongsTo
    {
        return $this->belongsTo(KategoriProfesiModel::class, 'kategori_id', 'kategori_id');
    }
    
    public function perusahaan(): HasOne
    {
        return $this->hasOne(PerusahaanModel::class, 'survei_alumni_id', 'survei_alumni_id');
    }
}
