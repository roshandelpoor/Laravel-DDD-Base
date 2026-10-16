<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Domain\Exception;

/**
 * Base class for all domain exceptions.
 *
 * Domain exceptions represent violations of business rules. They are
 * mapped to HTTP responses at the interface layer (see bootstrap/app.php).
 */
abstract class DomainException extends \DomainException {}
