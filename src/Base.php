<?php

namespace LaravelExceptions\Stripe;

use Illuminate\Support\Facades\Auth;
use Throwable;

abstract class Base extends \Exception
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

        if ($this->shouldntReport($original)) {
            return;
        }

        logger()->error(
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
    protected function shouldntReport(Throwable $exception)
    {
        return !config('app.debug') &&
            !is_null(array_first($this->dontReport, function ($type) use ($exception) {
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
