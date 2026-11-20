<?php

namespace App\Support;

use Composer\InstalledVersions;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Describes the server kOS is running on: operating system, PHP, database, Laravel, git commit and
 * key package versions. Shown on the login page outside production, and at /devinfo for superusers.
 *
 * Every probe is wrapped so a failure shows "unavailable" instead of an error. The login page must
 * keep working even when, for example, the database is down.
 */
class EnvironmentInfo
{
    public const UNAVAILABLE = 'unavailable';

    /** Packages whose versions are worth seeing at a glance. */
    private const PACKAGES = [
        'laravel/framework',
        'phpunit/phpunit',
        'nesbot/carbon',
        'symfony/http-foundation',
        'jeroennoten/laravel-adminlte',
        'owen-it/laravel-auditing',
        'intervention/image',
        'consoletvs/charts',
        'spatie/laravel-google-calendar',
        'guzzlehttp/guzzle',
        'laravel/tinker',
    ];

    /**
     * @return array<string, string> label => value
     */
    public static function server(): array
    {
        return [
            'Operating system' => self::probe(fn () => self::osName()),
            'PHP' => PHP_VERSION,
            'Web server' => self::probe(fn () => $_SERVER['SERVER_SOFTWARE'] ?? PHP_SAPI),
            'Database' => self::probe(fn () => self::databaseVersion()),
            'Laravel' => self::probe(fn () => app()->version()),
            'Environment' => (string) config('app.env'),
            'Debug mode' => config('app.debug') ? 'on' : 'off',
            'Git' => self::probe(fn () => self::gitRevision()),
        ];
    }

    /**
     * @return array<string, string> package => version, or "not installed"
     */
    public static function packages(): array
    {
        $versions = [];
        foreach (self::PACKAGES as $package) {
            $versions[$package] = self::probe(fn () => InstalledVersions::isInstalled($package)
                ? (InstalledVersions::getPrettyVersion($package) ?? self::UNAVAILABLE)
                : 'not installed');
        }

        return $versions;
    }

    public static function phpExtensions(): string
    {
        return self::probe(function () {
            $extensions = get_loaded_extensions();
            sort($extensions, SORT_FLAG_CASE | SORT_STRING);

            return implode(', ', $extensions);
        });
    }

    private static function probe(callable $read): string
    {
        try {
            $value = $read();

            return ($value === null || $value === '' || $value === false) ? self::UNAVAILABLE : (string) $value;
        } catch (Throwable) {
            return self::UNAVAILABLE;
        }
    }

    private static function osName(): ?string
    {
        if (is_readable('/etc/os-release')) {
            $release = parse_ini_file('/etc/os-release');
            if (! empty($release['PRETTY_NAME'])) {
                return $release['PRETTY_NAME'];
            }
        }

        return php_uname('s').' '.php_uname('r');
    }

    private static function databaseVersion(): string
    {
        $connection = DB::connection();

        return $connection->getDriverName().' '.$connection->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
    }

    /** Reads .git directly (no shell), so it works without git installed. */
    private static function gitRevision(): ?string
    {
        $git = base_path('.git');
        if (! is_readable($git.'/HEAD')) {
            return null;
        }

        $head = trim(file_get_contents($git.'/HEAD'));
        if (! str_starts_with($head, 'ref: ')) {
            return 'detached at '.substr($head, 0, 7);
        }

        $ref = substr($head, 5);
        $branch = preg_replace('#^refs/heads/#', '', $ref);
        $commit = is_readable($git.'/'.$ref) ? trim(file_get_contents($git.'/'.$ref)) : self::packedRef($git, $ref);

        return $branch.($commit ? ' @ '.substr($commit, 0, 7) : '');
    }

    private static function packedRef(string $git, string $ref): ?string
    {
        if (! is_readable($git.'/packed-refs')) {
            return null;
        }
        foreach (file($git.'/packed-refs', FILE_IGNORE_NEW_LINES) as $line) {
            if (str_ends_with($line, ' '.$ref)) {
                return strtok($line, ' ');
            }
        }

        return null;
    }
}
