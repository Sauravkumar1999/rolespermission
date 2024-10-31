<?php
namespace App\Traits;
use Illuminate\Http\JsonResponse;
use Exception;

trait ApiResponseTrait
{
    public function errorHandler(int $code = 500, string $message = null): JsonResponse
    {
        $error = [
            'message' => $message,
            'code' => $code,
        ];

        return response()->json($error, $code);
    }

    public function unauthorizedHandler(string $message = 'Your credentials are incorrect or your account has been blocked by the server administrator.'): JsonResponse
    {
        $response = [
            'version' => 'v1',
            'code' => 401,
            'message' => $message,
        ];
        return response()->json($response, 401);
    }

    public function successHandler($data, int $code = 200, string $message = null): JsonResponse
    {
        $response = [
            'data' => $data,
            'version' => 'v1',
            'code' => $code,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    public function okHandler(int $code = 200, string $message = null): JsonResponse
    {
        $error = [
            'version' => 'v1',
            'message' => $message,
            'code' => $code,
        ];

        return response()->json($error, $code);
    }

    public function serverErrorHandler(\Exception $e, bool $isStripe = false): JsonResponse
    {

        $error = [
            'debug' => (config('app.env') !== 'production') ? [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
            ] : null,
            'message' => (!$isStripe) ? "Unable to process your request at this time because the server encountered an unexpected condition." : $e->getMessage(),
            'version' => 'v1',
            'code' => 500,
        ];

        // Log the debug message for debugging purposes
        logger('Debug message: ' . $e->getMessage());

        return response()->json($error, 500);
    }

    public function validationErrorHandler(object $validationErrors = null): JsonResponse
    {
        $error = [
            "validation_error" => $validationErrors,
            'message' => 'Validation failed. Please check your input.',
            'version' => 'v1',
            'code' => 422,
        ];

        return response()->json($error, 422);
    }

    public function notFoundHandler(string $message = 'Resource not found. Please check back later or try a different search.'): JsonResponse
    {
        $response = [
            'data' =>[],
            'version' => 'v1',
            'code' =>404,
            'message' => $message,
        ];
        return response()->json($response,404);
    }
}
