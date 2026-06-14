<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Nilai
 */
class NilaiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'siswa' => new SiswaResource($this->whenLoaded('siswa')),
            'guru' => new GuruResource($this->whenLoaded('guru')),
            'mata_pelajaran' => $this->mata_pelajaran,
            'nilai_tugas' => $this->nilai_tugas,
            'nilai_uts' => $this->nilai_uts,
            'nilai_uas' => $this->nilai_uas,
            'nilai_akhir' => $this->nilai_akhir,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
