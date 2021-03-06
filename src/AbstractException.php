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
     * @param  Throwable  $exception
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

        if (!$this->shouldReport($original)) {
            return;
        }

        Log::error(
            $this->getMessage(),
            array_merge($this->context(), ['exception' => $original])
        );
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Throwable  $exception
     *
     * @return bool
     */
    public function shouldReport(Throwable $exception)
    {
        if (Config::get('app.debug')) {
            return true;
        }

        $foundInReportList = Arr::first($this->dontReport, function ($class) use ($exception) {
            return $exception instanceof $class;
        });

        return is_null($foundInReportList);
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
            ]);
        } catch (Throwable $e) {
            return [];
        }
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    abstract function render($request);
}
