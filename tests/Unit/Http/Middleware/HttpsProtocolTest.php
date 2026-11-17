<?php

namespace Tests\Unit\Http\Middleware;

use PHPUnit\Framework\Attributes\DataProvider;
use App\Http\Middleware\HttpsProtocol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

final class HttpsProtocolTest extends TestCase
{
    public function test_it_redirects_to_https_in_production_environment(): void
    {
        config(['app.env' => 'production']);
        $_SERVER['HTTPS'] = false;

        /** @var Request $request */
        $request = app(Request::class);
        $middleware = new HttpsProtocol;

        $this->assertFalse($request->isSecure());

        /** @var RedirectResponse $response */
        $response = $middleware->handle(app(Request::class), function () {});

        $this->assertTrue(
            $response->isRedirect(URL::to('/', [], true)),
            'Failed asserting that non-secure request is redirected in production environment.'
        );
    }

    #[DataProvider('provideNonProductionEnvironments')]
    public function test_it_does_not_redirect_to_https_outside_production_environment(string $environment): void
    {
        config(['app.env' => $environment]);
        $_SERVER['HTTPS'] = false;

        /** @var Request $request */
        $request = app(Request::class);
        $middleware = new HttpsProtocol;

        $this->assertFalse($request->isSecure());

        // A real next middleware always returns a response; the request is not
        // redirected when that same response is passed straight back.
        $nextMiddlewareCalled = false;
        $nextResponse = new Response;
        $response = $middleware->handle(app(Request::class), function () use (&$nextMiddlewareCalled, $nextResponse) {
            $nextMiddlewareCalled = true;

            return $nextResponse;
        });

        $this->assertTrue(
            $nextMiddlewareCalled === true && $response === $nextResponse,
            "Failed asserting that non-secure request is not redirected in $environment environment."
        );
    }

    /** $_SERVER is shared by every test in the run, so the HTTPS flag set above must not leak out. */
    protected function tearDown(): void
    {
        unset($_SERVER['HTTPS']);
        parent::tearDown();
    }

    public static function provideNonProductionEnvironments(): array
    {
        return [
            'local' => ['environment' => 'local'],
            'development' => ['environment' => 'development'],
            'testing' => ['environment' => 'testing'],
        ];
    }
}
