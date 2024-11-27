<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::with('client_phone')->get();
    }

    public function headings(): array
    {
        return [
            'الاسم',
            'الرقم المدني',
            'رقم الهاتف',
            'رقم هاتف العمل',
            'رقم الهاتف الارضي',
            'هاتف اقرب شخص',
        ];
    }

    public function map($client): array
    {
        return [
            $client->name_ar,
            $client->id_number,  // Adjust if `id_number` is not the correct field
            $client->client_phone->pluck('phone')->join(', ') ?? 'N/A',
            $client->client_phone->pluck('phone_work')->join(', ') ?? 'N/A',
            $client->client_phone->pluck('phone_land')->join(', ') ?? 'N/A',
            $client->client_phone->pluck('nearist_phone')->join(', ') ?? 'N/A',
        ];
    }
}
