<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogLivewireUploads
{
    public function handle(Request $request, Closure $next)
    {
        // Log all Livewire upload attempts
        if (str_contains($request->path(), 'upload-file')) {
            Log::info('Livewire upload attempt', [
                'path' => $request->path(),
                'method' => $request->method(),
                'content_type' => $request->header('Content-Type'),
                'content_length' => $request->header('Content-Length'),
                'has_file' => $request->hasFile('file'),
                'files' => array_keys($request->allFiles()),
                'ip' => $request->ip(),
                'user_agent' => substr($request->userAgent(), 0, 100),
            ]);
        }

        try {
            $response = $next($request);
            
            // Log failed upload responses  
            if (str_contains($request->path(), 'upload-file') && $response->getStatusCode() >= 400) {
                Log::error('Livewire upload failed', [
                    'status' => $response->getStatusCode(),
                    'body' => substr($response->getContent(), 0, 500),
                ]);
            }
            
            return $response;
        } catch (\Throwable $e) {
            if (str_contains($request->path(), 'upload-file')) {
                Log::error('Livewire upload exception', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile() . ':' . $e->getLine(),
                    'trace' => collect($e->getTrace())->take(5)->map(fn($t) => ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?'))->toArray(),
                ]);
            }
            throw $e;
        }
    }
}
