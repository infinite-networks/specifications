Infinite Specifications Library
===============================

This library is a base set of objects following the Specification pattern and based on
a blog post about taming Doctrines EntityRepository classes.

http://www.whitewashing.de/2013/03/04/doctrine_repositories.html

How to use this library
=======================

This library adds 2 methods to the base EntityRepository class, `match` and `matchOne`,
which both accept a specification that will build a query builder. Developers need to
implement specifications that meet their domain requirements, and each specification must
implement the `Infinite\Specification\ORM\Specification` interface.

An example of what using this library could look like:

```php

    use Infinite\Specification\ORM as Spec;

    $repository = $managerRegistry->getRepository('Entity\User');

    // Retrieve any enabled users, ordered by username
    $enabledUsersSpec = new Spec\Sort(array('username' => 'ASC'), new Spec\AndX(array(
        new Spec\Equals('enabled', 1)
    ));
    $enabledUsers = $repository->match($enabledUsersSpec);

    // Count enabled users
    $countEnabledUsersSpec = new Spec\SingleScalar(new Spec\Count(new Spec\Equals('enabled', 1)));
    $enabledUsersCount = $repository->matchOne($countEnabledUsersSpec);
```

Doctrine must be configured to use a different base EntityRepository class, and any
EntityRepositories implemented in your application must use the EntityRepository class
defined in this library as their base class.

To define a different EntityRepository base class in Symfony2, add the following
configuration:

```yaml
doctrine:
    orm:
        default_repository_class: Infinite\Specification\ORM\EntityRepository
```
