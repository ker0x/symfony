<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Christian Flothmann <christian.flothmann@sensiolabs.de>
 */
class ValidValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Valid) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Valid');
        }

        $violations = $this->context->getValidator()->validate($value, null, array($this->context->getGroup()));

        foreach ($violations as $violation) {
            $this->context->buildViolation($violation->getMessage(), $violation->getParameters())
                ->atPath($violation->getPropertyPath())
                ->addViolation();
        }
    }
}