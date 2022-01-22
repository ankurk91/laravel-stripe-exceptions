<?php
declare(strict_types=1);

namespace Ankurk91\StripeExceptions;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Throwable;

abstract class AbstractException extends \Exception
{
    protected array $dontReport = [
        //
    ];

    public function __construct(Throwable $exception)
    {
        parent::__construct($exception->getMessage(), (int)$exception->getCode(), $exception);
    }

    public function report(): ?bool
    {
        $original = $this->getPrevious();

        if (!$this->shouldReport($original)) {
            return null; // must return null value to skip
        }

        return false; // let Laravel exception handler do the rest
    }

    public function shouldReport(Throwable $exception): bool
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
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    abstract function render(Request $request);
}
