<?php

namespace App\Console\Commands;

use App\Models\ReferralLink;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateReferralLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referral:create {stripe_account_id} {trainer_name} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a referral link for a trainer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stripeAccountId = $this->argument('stripe_account_id');
        $trainerName = $this->argument('trainer_name');
        $email = $this->option('email');
        
        $code = Str::random(8);
        
        ReferralLink::create([
            'code' => $code,
            'stripe_account_id' => $stripeAccountId,
            'trainer_name' => $trainerName,
            'trainer_email' => $email
        ]);

        $this->info("Referral link created for {$trainerName}: " . route('referral.handle', $code));
    }
}
