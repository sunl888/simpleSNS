<?php

use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    public function run()
    {
        $userIDs = \App\Models\User::all()->pluck('id');
        $data = [];
        for ($i = 0, $j = $userIDs->count() - 1; $i < $userIDs->count(); $i++, $j--) {
            if ($i != $j) {
                $data[$i]['user_id'] = $userIDs[$i];
                $data[$i]['follow_user_id'] = $userIDs[$j];
                $data[$i]['created_at'] = \Carbon\Carbon::now();
                $data[$i]['updated_at'] = \Carbon\Carbon::now();
            }
        }
        DB::table('follows')->insert($data);
    }
}
