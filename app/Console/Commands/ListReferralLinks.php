<?php

namespace App\Console\Commands;

use App\Models\ReferralLink;
use Illuminate\Console\Command;

class ListReferralLinks extends Command
{
    protected $signature = 'referral:list';
    protected $description = 'List all referral links';

    public function handle()
    {
        $links = ReferralLink::all();

        $this->table(
            ['ID', 'Trainer', 'Email', 'Code', 'Link', 'Created'],
            $links->map(function ($link) {
                return [
                    $link->id,
                    $link->trainer_name,
                    $link->trainer_email ?? 'N/A',
                    $link->code,
                    route('referral.handle', $link->code),
                    $link->created_at->format('Y-m-d H:i')
                ];
            })
        );
    }
} 