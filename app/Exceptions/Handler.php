<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isHttpException($exception)) {
            $code = $exception->getCode();

            if ($code == 403) {
                return response()->view('errors.403');
            } else if ($code == 404) {
                return response()->view('errors.404');
            } else if ($code == 500) {
                return response()->view('errors.505');
            }
        }

        // guard(세션)에 따른 로그인 경로 설정한다
        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
            case 'admin':
                $login = 'admin.auth.login.form';
                break;

            case 'vender':
                $login = 'vender.auth.login.form';
                break;

            default:
                $login = 'user.auth.login.form';
                break;
        }

        // 로그인 페이지로 이동한다
        return redirect()->guest(route($login));
    }
}
