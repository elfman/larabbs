<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    protected $hash_prefix = 'larabbs_last_active_at_';
    protected $field_prefix = 'user_';

    public function recordLastActiveAt()
    {
        $date = Carbon::now()->toDateString();

        $hash = $this->getHashFromDateString($date);

        $field = $this->getHashField();

        $now = Carbon::now()->toDateTimeString();

        Redis::hSet($hash, $field, $now);
    }

    public function syncUserActiveAt()
    {
        $yestoday_date = Carbon::now()->subDay()->toDateString();

        $hash = $this->getHashFromDateString($yestoday_date);

        $dates = Redis::hGetAll($hash);

        foreach ($dates as $user_id => $active_at) {
            $user_id = str_replace($this->field_prefix, '', $user_id);
            if ($user = $this->find($user_id)) {
                $user->last_active_at = $active_at;
                $user->save();
            }
        }

        Redis::del($hash);
    }

    public function getLastActiveAtAttribute($value)
    {
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        $field = $this->getHashField();

        $datetime = Redis::hGet($hash, $field) ?: $value;

        if ($datetime) {
            return new Carbon($datetime);
        } else {
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}