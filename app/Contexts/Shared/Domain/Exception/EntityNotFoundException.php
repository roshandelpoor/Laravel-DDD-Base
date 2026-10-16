<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Domain\Exception;

/**
 * Base class for "aggregate not found" domain exceptions.
 * Mapped once to a 404 response in bootstrap/app.php, so every
 * context gets the behavior for free.
 */
abstract class EntityNotFoundException extends DomainException {}
