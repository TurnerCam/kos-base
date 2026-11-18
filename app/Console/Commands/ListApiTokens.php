<?php

namespace App\Console\Commands;

use App\Models\ApiToken;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('api-token:list {--revoked : Show revoked tokens only} {--active : Show active tokens only}')]
#[Description('List API tokens')]
class ListApiTokens extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $query = ApiToken::query()->orderBy('id');

        if ($this->option('revoked')) {
            $query->whereNotNull('revoked_at');
        } elseif ($this->option('active')) {
            $query->whereNull('revoked_at');
        }

        $tokens = $query->get([
            'id',
            'name',
            'abilities',
            'last_used_at',
            'expires_at',
            'revoked_at',
            'created_at',
        ]);

        if ($tokens->isEmpty()) {
            $this->info('No API tokens found.');

            return self::SUCCESS;
        }

        $this->table(
            ['ID', 'Name', 'Abilities', 'Last Used', 'Expires', 'Revoked', 'Created'],
            $tokens->map(function (ApiToken $token) {

                return [
                    $token->id,
                    $token->name,
                    $token->abilities ? implode(',', $token->abilities) : '',
                    $token->last_used_at?->toDateTimeString(),
                    $token->expires_at?->toDateTimeString(),
                    $token->revoked_at?->toDateTimeString(),
                    $token->created_at?->toDateTimeString(),
                ];
            })->all()
        );

        return self::SUCCESS;
    }
}
