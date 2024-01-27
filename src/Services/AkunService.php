<?php

namespace BangLipai\UserAkses\Services;


use App\Models\User;
use BangLipai\UserAkses\Models\GrupAkses;
use BangLipai\UserAkses\Models\GrupAnggota;
use Illuminate\Support\Collection;

class AkunService
{
    public function getGrupAkses(User $user): Collection
    {
        $groups = $this->getGroups($user);

        return GrupAkses::query()
            ->whereIn('k_grup', $groups)
            ->get();
    }

    protected function getGroups(User $user): Collection
    {
        $grupAnggota = GrupAnggota::query()
            ->distinct()
            ->join('user_grup', 'user_grup.k_grup', '=', 'grup_anggota.k_grup')
            ->where('user_grup.user_id', '=', $user->id)
            ->pluck('grup_anggota.k_grup_anggota');

        $userGrup = $user->userGrups()->pluck('k_grup');
        return $grupAnggota->merge($userGrup)->unique();
    }
}