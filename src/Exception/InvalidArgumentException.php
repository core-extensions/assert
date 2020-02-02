<?php

declare(strict_types=1);

namespace CoreExtensions\Assert\Exception;

final class InvalidArgumentException extends \InvalidArgumentException implements AssertionFailedException
{
}
