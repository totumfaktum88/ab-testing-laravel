<?php

namespace App\Http\Middleware;

use App\Contracts\ABTest\TestServiceContract;
use App\Enums\Session\EventTypeEnum;
use App\Models\Session;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Session\Session as SessionContract;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StartSession
{
    private const DB_SESSION_ID_KEY = 'db_session_id';

    public function __construct(
        private readonly Application $app,
        private readonly SessionContract $sessionManager,
        private readonly TestServiceContract $testService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = null;

        if ($this->sessionManager->has(self::DB_SESSION_ID_KEY)) {
            $sessionIdForDb = $this->sessionManager->get(self::DB_SESSION_ID_KEY);
            $session = Session::query()->find($sessionIdForDb);
        }

        if ($session === null) {
            $session = new Session();
            $session->save();
            $this->sessionManager->put(self::DB_SESSION_ID_KEY, $session->id);
        }

        $this->testService->loadTestsToStore($session);

        $this->app->instance(Session::class, $session);

        if ($request->getMethod() === 'GET' && ! $request->isXmlHttpRequest()) {
            $session->events()->create([
                'url' => url($request->path()),
                'type' => EventTypeEnum::PAGEVIEW->name,
            ]);
        }

        return $next($request);
    }
}
