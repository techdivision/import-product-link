# Version 9.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-product 8.0.* version as dependency
* Make Actions and ActionInterfaces deprecated, replace DI configuration with GenericAction + GenericIdentifierAction

# Version 8.0.0

## Bugfixes

* Fixed invalid replace mode for product links and grouped products

## Features

* None

# Version 7.0.0

## Bugfixes

* None

## Features

* Added techdivision/import-cli-simple#198

# Version 6.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-product 6.0.* version as dependency

# Version 5.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-product 5.0.* version as dependency

# Version 4.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 5.0.* version as dependency

# Version 3.0.0

## Bugfixes

* None

## Features

* Compatibility for Magento 2.3.x

# Version 2.0.0

## Bugfixes

* None

## Features

* Compatibility for Magento 2.2.x

# Version 1.0.0

## Bugfixes

* None

## Features

* Move PHPUnit test from tests to tests/unit folder for integration test compatibility reasons

# Version 1.0.0-beta9

## Bugfixes

* None

## Features

* Add missing interfaces for actions and repositories
* Replace class type hints for ProductLinkProcessor with interfaces

# Version 1.0.0-beta8

## Bugfixes

* None

## Features

* Configure DI to pass event emitter to subjects constructor

# Version 1.0.0-beta7

## Bugfixes

* None

## Features

* Refactored DI + switch to new SqlStatementRepositories instead of SqlStatements

# Version 1.0.0-beta6

## Bugfixes

* None

## Features

* Fixed typos and remove unnecessary use statements

# Version 1.0.0-beta5

## Bugfixes

* None

## Features

* Refactor to optimize DI integration

# Version 1.0.0-beta4

## Bugfixes

* None

## Features

* Switch to new plugin + subject factory implementations

# Version 1.0.0-beta3

## Bugfixes

* None

## Features

* Use Robo for Travis-CI build process 
* Refactoring for new ConnectionInterface + SqlStatementsInterface

# Version 1.0.0-beta2

## Bugfixes

* None

## Features

* Update configuration examples in README.md file

# Version 1.0.0-beta1

## Bugfixes

* None

## Features

* Integrate Symfony DI functionality

# Version 1.0.0-alpha12

## Bugfixes

* None

## Features

* Refactoring for DI integration

# Version 1.0.0-alpha11

## Bugfixes

* Fixed invalid PHPCS check in RoboFile.php
* Remove unnecessary use statement in LinkSubject

## Features

* None

# Version 1.0.0-alpha10

## Bugfixes

* None

## Features

* Optimise error messages

# Version 1.0.0-alpha9

## Bugfixes

* None

## Features

* Make product link creation more generic to map link types to CSV file columns

# Version 1.0.0-alpha8

## Bugfixes

* None

## Features

* Ignore missing SKUs in product relations in debug mode
* Add CSV filename/line number to exceptions to improve error handling/debugging

# Version 1.0.0-alpha7

## Bugfixes

* None

## Features

* Refactor + generalize observers

# Version 1.0.0-alpha6

## Bugfixes

* Fixed invalid SKU mapping for linked product ID

## Features

* None

# Version 1.0.0-alpha5

## Bugfixes

* None

## Features

* Implement add/update operation

# Version 1.0.0-alpha4

## Bugfixes

* None

## Features

* Switch to new create/delete naming convention

# Version 1.0.0-alpha3

## Bugfixes

* None

## Features

* LinkSubject now extends AbstractProductSubject
* Add Robo.li composer dependeny + task configuration
* ProductLinkProcessorInterface now extends ProductProcessorInterface

# Version 1.0.0-alpha2

## Bugfixes

* None

## Features

* Refactoring to allow multiple prepared statements per CRUD processor instance

# Version 1.0.0-alpha1

## Bugfixes

* None

## Features

* Refactoring + Documentation to prepare for Github release