<?php
namespace App\Traits;

use App\Helpers\TimeHelper;

trait UserMethods
{
    private static $userStates = [
        '7days'      => '7일 정지',
        '30days'     => '30일 정지',
        'permanence' => '영구 정지',
        'emailCert'  => '메일 미인증',
        'normal'     => '정상',
    ];

    public function roleCode()
    {
        return $this->roles()->get()->first()->name;
    }

    public function roleName()
    {
        $result = '';
        switch ($this->roleCode()) {
            case 'administrator':           $result = '최고 관리자'; break;
            case 'manager':                 $result = '관리자'; break;
            case 'operator':                $result = '운영자'; break;
            case 'analyst':                 $result = '분석자'; break;
            case 'vendor_administrator':    $result = '점주 최고 관리자'; break;
            case 'vendor_manager':          $result = '점주 관리자'; break;
            case 'vendor_operator':         $result = '점주 운영자'; break;
            case 'vendor_analyst':          $result = '점주 분석자'; break;
            default:                        $result = '사용자'; break;
        }

        return $result;
    }

    /**
     * 소셜 User 인지 확인함
     * @return boolen
     */
    public function isUserSocial()
    {
        return !!($this->userSocial()->first());
    }

    public function getUserProvider()
    {
        if ($this->userSocial) {
            return $this->userSocial->provider;
        }

        return 'email';
    }

    public function getUserName()
    {
        if (isset($this->users)) {
            if ($this->users->last_name || $this->users->first_name) {
                return $this->users->last_name.' '.$this->users->first_name;
            }

            return $this->users->nick_name;
        }

        if ($this->last_name || $this->first_name) {
            return $this->last_name.' '.$this->first_name;
        }

        return $this->nick_name;
    }

    public function isActivated()
    {
        return $this->activated_at && !$this->activation_code;
    }

    public function getGenderAndAge()
    {
        if ($this->gender && $this->age) {
            return $this->gender.' / '.$this->age;
        }

        return 'N/N';
    }

    public function getAddress()
    {
        $addressColumns = ['country', 'ciry', 'district', 'address_1', 'address_2'];
        $addresses      = [];
        foreach ($addressColumns as $addressColumn) {
            array_push($addresses, $this->$addressColumn ?? '');
        }

        return trim(implode(' ', $addresses));
    }

    public function lastLoginedAt()
    {
        try {
            return TimeHelper::timestampToString($this->userLogs()->latest()->first()->created_at);
        } catch (\Exception $e) {

        }

        return null;
    }

    public function lastLoginedIp()
    {
        try {
            return $this->userLogs()->latest()->first()->ip;
        } catch (\Exception $e) {
            return '127.0.0.1';
        }
    }

    public static function deletedUsers(string $date = '1970-01-01')
    {
        try {
            $deletedDate = \Carbon\Carbon::parse($date)->format('Y-mobile-d');
        } catch (\Exception $e) {
            $deletedDate = \Carbon\Carbon::parse('1970-01-01')->format('Y-mobile-d');
        }

        $deletedUser = static::onlyTrashed()
            ->where('deleted_at', '>=', $deletedDate);

        return $deletedUser;
    }

    public function getAge()
    {
        $now      = \Carbon\Carbon::now();
        if (empty($this->birthday)) {
            $birthday = $now;
        } else {
            $birthday = \Carbon\Carbon::parse($this->birthday);
        }

        $age      = $birthday->diff($now)->y;

        return $age;
    }

    public function getDeletedReason()
    {
        $reason = '';
        if (!is_null($this->deleted_at)) {
            if (strlen($this->deleted_reason) > 0) {
                if (isset(self::$deletedReasons[$this->deleted_reason])) {
                    $reason = $this->deleted_reason;
                } else {
                    $reason = 'etc';
                }
            }
        }

        return $reason;
    }
}
