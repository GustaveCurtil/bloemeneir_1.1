<?php

namespace App\Repositories;

use App\Models\TurnVoucher;

/**
 * Voordeel repository: 1 plek in de code waarbij je alle queries & extra DB logica kunt toevoegen 
 * rondom een bepaald model
 */
class TurnVoucherRepository
{
    public function retrieveTurnVouchersByIdsAndName(array $ids, string $name)
    {
        return TurnVoucher::whereIn('id', $ids)
            ->where('name', $name)
            ->orderBy('valid_date', 'asc') // zodat eerst de kaarten worden opgebruikt die nog het minst lang geldig zijn.
            ->get();
    }
}