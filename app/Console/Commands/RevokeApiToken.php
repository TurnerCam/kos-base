<?php

namespace App\Console\Commands;

use App\Models\ApiToken;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('api-token:revoke {id : Token ID to revoke}')]
#[Description('Revoke an API token by ID')]
class RevokeApiToken extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $tokenId = (int) $this->argument('id');
        $token = ApiToken::find($tokenId);

        if ($token === null) {
            $this->error('API token not found.');

            return self::FAILURE;
        }

        if ($token->revoked_at !== null) {
            $this->info('API token is already revoked.');

            return self::SUCCESS;
        }

        $token->fill(['revoked_at' => now()])->save();

        $this->info('API token revoked.');

        return self::SUCCESS;
    }
}
