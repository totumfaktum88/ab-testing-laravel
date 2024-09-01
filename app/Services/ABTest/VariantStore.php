<?php

namespace App\Services\ABTest;

use App\Contracts\ABTest\VariantStoreContract;
use Illuminate\Contracts\Session\Session as SessionContract;

class VariantStore implements VariantStoreContract
{

    public function __construct(
        protected readonly SessionContract $sessionManager,
    ) {

    }

    public function getSessionKey(): string {
        return 'ab_tests';
    }

    public function get(string $key): string | null
    {
        $data = $this->sessionManager->get($this->getSessionKey());

        return $data[$key] ?? null;
    }

    public function getAll(): array {
        return $this->sessionManager->get($this->getSessionKey()) ?? [];
    }

    public function put($key, $value = null): void
    {
        $data = $this->getAll();

        $data[$key] = $value;

        $this->sessionManager->put(
            $this->getSessionKey(),
            $data
        );
    }

    public function forget(string | array $elements): void {
        $data = $this->getAll();

        if (is_string($elements)) {
            $elements = explode(" ", $elements);
        }

        $data = array_filter($data, fn($item, $key) => !in_array($key, $elements), ARRAY_FILTER_USE_BOTH);

        $this->sessionManager->put($this->getSessionKey(), $data);
    }

    public function has($key): bool
    {
        return isset(($this->sessionManager->get($this->getSessionKey()) ?? [])[$key]);
    }
}
