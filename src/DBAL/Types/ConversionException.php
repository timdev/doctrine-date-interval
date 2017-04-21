<?php

/**
 * DateIntervalType calls conversionFailedInvalidType() which isn't present in 2.5.  So this class extends 2.5's
 * version to provide the method.  Code is a blatant copy/paste of the current upstream master.
 */
namespace TimDev\Doctrine\DBAL\Types;

class ConversionException extends \Doctrine\DBAL\Types\ConversionException
{
    /**
     * Thrown when a Database to Doctrine Type Conversion fails.
     *
     * @param string $value
     * @param string $toType
     *
     * @return \Doctrine\DBAL\Types\ConversionException
     */
    static public function conversionFailed($value, $toType)
    {
        $value = (strlen($value) > 32) ? substr($value, 0, 20) . '...' : $value;

        return new self('Could not convert database value "' . $value . '" to Doctrine Type ' . $toType);
    }

    /**
     * Thrown when a Database to Doctrine Type Conversion fails and we can make a statement
     * about the expected format.
     *
     * @param string          $value
     * @param string          $toType
     * @param string          $expectedFormat
     * @param \Exception|null $previous
     *
     * @return \Doctrine\DBAL\Types\ConversionException
     */
    static public function conversionFailedFormat($value, $toType, $expectedFormat, \Exception $previous = null)
    {
        $value = (strlen($value) > 32) ? substr($value, 0, 20) . '...' : $value;

        return new self(
            'Could not convert database value "' . $value . '" to Doctrine Type ' .
            $toType . '. Expected format: ' . $expectedFormat,
            0,
            $previous
        );
    }

    /**
     * Thrown when the PHP value passed to the converter was not of the expected type.
     *
     * @param mixed    $value
     * @param string   $toType
     * @param string[] $possibleTypes
     *
     * @return \Doctrine\DBAL\Types\ConversionException
     */
    static public function conversionFailedInvalidType($value, $toType, array $possibleTypes)
    {
        $actualType = is_object($value) ? get_class($value) : gettype($value);

        if (is_scalar($value)) {
            return new self(sprintf(
                "Could not convert PHP value '%s' of type '%s' to type '%s'. Expected one of the following types: %s",
                $value,
                $actualType,
                $toType,
                implode(', ', $possibleTypes)
            ));
        }

        return new self(sprintf(
            "Could not convert PHP value of type '%s' to type '%s'. Expected one of the following types: %s",
            $actualType,
            $toType,
            implode(', ', $possibleTypes)
        ));
    }

    static public function conversionFailedSerialization($value, $format, $error)
    {
        $actualType = is_object($value) ? get_class($value) : gettype($value);

        return new self(sprintf(
            "Could not convert PHP type '%s' to '%s', as an '%s' error was triggered by the serialization",
            $actualType,
            $format,
            $error
        ));
    }
}