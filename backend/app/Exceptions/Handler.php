<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle API requests with JSON responses
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle API exceptions and return user-friendly JSON responses.
     */
    protected function handleApiException($request, Throwable $exception)
    {
        $statusCode = 500;
        $message = 'Something went wrong. Please try again later.';
        $errors = null;

        // Handle specific exception types
        if ($exception instanceof ValidationException) {
            $statusCode = 422;
            $message = 'Please check your input and try again.';
            $errors = $this->formatValidationErrors($exception->errors());
            $message = $this->getFirstValidationError($exception->errors());
        } elseif ($exception instanceof ModelNotFoundException) {
            $statusCode = 404;
            $message = 'The requested resource was not found.';
        } elseif ($exception instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'The page you are looking for could not be found.';
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            $statusCode = 405;
            $message = 'This action is not allowed.';
        } elseif ($exception instanceof AuthenticationException) {
            $statusCode = 401;
            $message = 'Please log in to continue.';
        } elseif ($exception instanceof TooManyRequestsHttpException) {
            $statusCode = 429;
            $message = 'Too many requests. Please wait a moment and try again.';
        } elseif (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
            $message = $this->getHttpErrorMessage($statusCode);
        }

        // In debug mode, include more details
        if (config('app.debug')) {
            return response()->json([
                'message' => $message,
                'error' => class_basename($exception),
                'errors' => $errors,
                'debug' => [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                ],
            ], $statusCode);
        }

        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    /**
     * Format validation errors into human-readable messages.
     */
    protected function formatValidationErrors(array $errors): array
    {
        $formatted = [];
        
        foreach ($errors as $field => $messages) {
            $fieldName = $this->humanizeFieldName($field);
            
            foreach ($messages as $message) {
                $formatted[$field] = $this->humanizeErrorMessage($message, $fieldName);
            }
        }
        
        return $formatted;
    }

    /**
     * Get the first validation error message.
     */
    protected function getFirstValidationError(array $errors): string
    {
        foreach ($errors as $field => $messages) {
            if (!empty($messages[0])) {
                $fieldName = $this->humanizeFieldName($field);
                return $this->humanizeErrorMessage($messages[0], $fieldName);
            }
        }
        
        return 'Please check your input and try again.';
    }

    /**
     * Convert field names to human-readable format.
     */
    protected function humanizeFieldName(string $field): string
    {
        $replacements = [
            'email' => 'email address',
            'password' => 'password',
            'name' => 'name',
            'message' => 'message',
            'title' => 'title',
            'images' => 'images',
            'avatar' => 'avatar',
            'resume' => 'resume',
        ];

        return $replacements[$field] ?? str_replace('_', ' ', $field);
    }

    /**
     * Convert technical error messages to human-readable format.
     */
    protected function humanizeErrorMessage(string $message, string $fieldName): string
    {
        $replacements = [
            'The :attribute field is required.' => "Please provide your {$fieldName}.",
            'The :attribute must be a valid email address.' => "Please enter a valid email address.",
            'The :attribute must be at least :min characters.' => "Your {$fieldName} must be at least :min characters long.",
            'The :attribute may not be greater than :max characters.' => "Your {$fieldName} cannot be longer than :max characters.",
            'The :attribute must be at least :min.' => "Please select at least :min {$fieldName}.",
            'The :attribute may not be greater than :max.' => "You can only select up to :max {$fieldName}.",
            'The :attribute must be an image.' => "Please upload a valid image file.",
            'The :attribute must be a file of type: :values.' => "Please upload a file of the correct type.",
            'The :attribute failed to upload.' => "The file upload failed. Please try again.",
            'The :attribute may not be greater than :max kilobytes.' => "The file is too large. Maximum size is :max KB.",
            'The :attribute may not be greater than :max megabytes.' => "The file is too large. Maximum size is :max MB.",
            'The selected :attribute is invalid.' => "Please select a valid {$fieldName}.",
            'The :attribute has already been taken.' => "This {$fieldName} is already in use. Please choose another.",
            'The :attribute format is invalid.' => "Please enter a valid {$fieldName}.",
        ];

        // Replace :attribute placeholder
        $message = str_replace(':attribute', $fieldName, $message);

        // Try to match and replace common patterns
        foreach ($replacements as $pattern => $replacement) {
            $pattern = str_replace(':attribute', $fieldName, $pattern);
            if (str_contains($message, $pattern) || preg_match('/' . preg_quote($pattern, '/') . '/', $message)) {
                return str_replace(':attribute', $fieldName, $replacement);
            }
        }

        // Extract numbers from message for dynamic replacements
        if (preg_match('/(\d+)/', $message, $matches)) {
            $number = $matches[1];
            $message = str_replace($number, $number, $message);
        }

        // Fallback: clean up common technical terms
        $message = str_replace([
            'validation.',
            'failed',
            'required',
            'invalid',
        ], [
            '',
            'not accepted',
            'needed',
            'not valid',
        ], strtolower($message));

        return ucfirst($message);
    }

    /**
     * Get human-readable HTTP error messages.
     */
    protected function getHttpErrorMessage(int $statusCode): string
    {
        $messages = [
            400 => 'Your request was invalid. Please check your input and try again.',
            401 => 'Please log in to continue.',
            403 => 'You do not have permission to perform this action.',
            404 => 'The requested resource was not found.',
            405 => 'This action is not allowed.',
            422 => 'Please check your input and try again.',
            429 => 'Too many requests. Please wait a moment and try again.',
            500 => 'Something went wrong on our end. Please try again later.',
            503 => 'The service is temporarily unavailable. Please try again later.',
        ];

        return $messages[$statusCode] ?? 'An error occurred. Please try again.';
    }
}

