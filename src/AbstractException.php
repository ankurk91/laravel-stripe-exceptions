<?php

namespace Ankurk91\StripeExceptions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class AbstractException extends \Exception
{
    /**
     * A list of the exception types that not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Base constructor.
     *
     * @param Throwable $exception
     */
    public function __construct(Throwable $exception)
    {
        parent::__construct($exception->getMessage(), (int) $exception->getCode(), $exception);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        $original = $this->getPrevious();

        if ($this->shouldNotReport($original)) {
            return;
        }

        Log::error(
            $this->getMessage(),
            array_merge($this->context(), ['exception' => $original])
        );
    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param \Throwable $exception
     *
     * @return bool
     */
    protected function shouldNotReport(Throwable $exception)
    {
        return !Config::get('app.debug') &&
            !is_null(Arr::first($this->dontReport, function ($type) use ($exception) {
                return $exception instanceof $type;
            }));
    }

    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        try {
            return array_filter([
                'userId' => Auth::id(),
                'email'  => Auth::user() ? Auth::user()->email : null,
            ]);
        } catch (Throwable $e) {
            return [];
        }
    }
}
