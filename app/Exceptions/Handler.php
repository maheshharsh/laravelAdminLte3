<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (PostTooLargeException $e, Request $request) {
            $message = 'The uploaded data is too large. Please upload a smaller file.';

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json(['message' => $message], 413);
            }

            // For normal requests, redirect back with old input and a toaster-friendly flash
            return back()->withInput()->with('toast', [
                'type' => 'error',
                'message' => $message,
            ]);
        });
    }

}
