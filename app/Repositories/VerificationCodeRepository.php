<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class VerificationCodeRepository
{
    public function retrieveByTelNum($telNum)
    {
        if (!$this->isValidTelNum($telNum))
            return null;
        return Cache::get($telNum);
    }

    public function create(array $data)
    {
        $term_of_validity = config('alidayu.term_of_validity');
        $minutes = $term_of_validity ? $term_of_validity / 60 : 5;
        $expiresAt = Carbon::now()->addMinutes($minutes);
        $data['created_at'] = Carbon::now();

        Cache::put($data['tel_num'], $data, $expiresAt);
    }

    protected function isValidTelNum($telNum)
    {
        return preg_match('/^\d{11}$/', $telNum) > 0;
    }

    public function delete($telNum)
    {
        if (!$this->isValidTelNum($telNum))
            return;
        return Cache::pull($telNum);
    }
}
