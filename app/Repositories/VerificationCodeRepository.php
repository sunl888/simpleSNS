<?php

namespace App\Repositories;


use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VerificationCodeRepository extends BaseRepository
{
    public function model()
    {
        return VerificationCode::class;
    }

    public function preCreate(array &$data)
    {
        $data[Model::CREATED_AT] = Carbon::now();
        return $data;
    }

    public function retrieveByTelNum($telNum)
    {
        if (!$this->isValidTelNum($telNum))
            return null;
        return $this->model->where('tel_num', $telNum)->latest()->first();
    }

    protected function isValidTelNum($telNum)
    {
        return preg_match('/^\d{11}$/', $telNum) > 0;
    }

    public function delete($telNum)
    {
        if (!$this->isValidTelNum($telNum))
            return;
        $this->model->where('tel_num', $telNum)->delete();
    }
}
