<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SameKelas implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $cabangAwal = Cabang::with('kelases')->find($request->lokasi_awal_id);
        // $cabangTujuan = Cabang::with('kelases')->find($request->lokasi_tujuan_id);
    }
}
