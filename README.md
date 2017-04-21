# Doctrine DateInterval Type

Doctrine DBAL 2.6 will introduce a DateInterval type which will map a PHP \DateInterval to a column
in the database.  This will allow mapping DateInterval properties on your entities in the ORM.

At the time of this writing, 2.6 hasn't been released, but I need this for a project.  So, this little 
project provides the type for use in 2.5 (and probably lower).

This is simply a copy/paste job of the DateIntervalType class from the upcoming DBAL 2.6, with a 
composer.json so it's easy to pull into a project using <2.6.

## Installation 

```bash
$ composer require timdev/doctrine-date-interval:0.1.2
```

## Usage

Where ever you initialize your EntityManager:

```php
\Doctrine\DBAL\Types\Type::addType('dateinterval', \TimDev\Doctrine\DBAL\Types\DateIntervalType::class);
$entityManager
    ->getConnection()
    ->getDatabasePlatform()
    ->registerDoctrineTypeMapping('dateinterval', 'dateinterval');
```

