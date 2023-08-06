# Magento 2 Module ExpressShipping

    ``gokhandemirer/module-expressshipping``

- [Main Functionalities](#markdown-header-main-functionalities)
- [Installation](#markdown-header-installation)
- [Configuration](#markdown-header-configuration)
- [Specifications](#markdown-header-specifications)
- [Tests](#markdown-header-tests)


## Main Functionalities
Creates a new custom shipping method

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

- Unzip the zip file in `app/code/Gokhandemirer`
- Enable the module by running `php bin/magento module:enable Gokhandemirer_ExpressShipping`
- Apply database updates by running `php bin/magento setup:upgrade`\*
- Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

- Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
- Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
- Install the module composer by running `composer require gokhandemirer/module-expressshipping`
- enable the module by running `php bin/magento module:enable Gokhandemirer_ExpressShipping`
- apply database updates by running `php bin/magento setup:upgrade`\*
- Flush the cache by running `php bin/magento cache:flush`


## Configuration

- ExpressShipping - carriers/expressshipping/*


## Specifications

- Helper
    - Gokhandemirer\ExpressShipping\Helper\Config
    - Gokhandemirer\ExpressShipping\Helper\Data

- Shipping Method
    - expressshipping


## Tests

- Unit Tests
    - Gokhandemirer\ExpressShipping\Test\Unit\ExpressShippingTest

## License

[MIT License](https://opensource.org/licenses/MIT)