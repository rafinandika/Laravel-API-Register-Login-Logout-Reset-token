<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdDetail extends JsonResource
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
            'akun' => $this->akun,
            'idakun' => $this->akun_id,
            'pertanyaan' => json_decode($this->pertanyaan),
            'topup' => $this->top_up . 'B',
            'kirim' => ($this->kirim == 1 ? 'Bisa Kirim' : 'Belum bisa kirim')
        ];
    }
}