<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenjualanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            // 'id' => $this->id,
            // 'transaction_number' => $this->transaction_number,
            'marketing' => $this->marketings->name ?? 'N/A', 
            'bulan' => \Carbon\Carbon::createFromFormat('Y-m', $this->bulan)
                ->locale('id') // Set bahasa Indonesia
                ->translatedFormat('F'),
            'omzet' => $this->omzet,
            'komisi_persen' => $this->getKomisiPersen($this->omzet),
            'komisi_nominal' => $this->getKomisiNominal($this->omzet),
        ];
    }

        /**
     * Hitung persentase komisi berdasarkan omzet.
     */
    private function getKomisiPersen($omzet)
    {
        if ($omzet >= 500000000) {
            return '10%';
        } elseif ($omzet >= 200000000 && $omzet < 500000000) {
            return '5%';
        } elseif ($omzet >= 100000000 && $omzet < 200000000) {
            return '2.5%';
        } else {
            return '0%';
        }
    }

    /**
     * Hitung nominal komisi berdasarkan omzet.
     */
    private function getKomisiNominal($omzet)
    {
        $persen = str_replace('%', '', $this->getKomisiPersen($omzet)); // Ambil angka dari persentase
        return intval((floatval($persen) / 100) * $omzet);
    }
}
