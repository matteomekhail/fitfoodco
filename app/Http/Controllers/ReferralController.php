<?php

namespace App\Http\Controllers;

use App\Models\ReferralLink;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function handleReferral($code)
    {
        $referralLink = ReferralLink::where('code', $code)->firstOrFail();
        session(['referral_code' => $code]);
        
        return redirect()->route('home');
    }
}
