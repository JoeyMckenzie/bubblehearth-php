<?php

namespace Joeymckenzie\Bubblehearth;

use Exception;

/**
 * A result type akin to the monadic `Result<T, E>` structure in Rust.
 */
final readonly class Result
{
    /**
     * @var mixed contained nullable data of the result.
     */
    public mixed $data;

    /**
     * @var Exception|null error context of a failed result type.
     */
    public ?Exception $error;

    public function __construct(mixed $data = null, Exception $error = null)
    {
        $this->data = $data;
        $this->error = $error;
    }

    /**
     * Constructs a result instance assuming successful execution.
     *
     * @param  mixed  $data resulting response data.
     */
    public static function Ok(mixed $data): self
    {
        return new self($data);
    }

    /**
     * Constructs a result instance assuming failed execution.
     *
     * @param  Exception  $exception exception context for the failure.
     */
    public static function Err(Exception $exception): self
    {
        return new self(error: $exception);
    }
}
