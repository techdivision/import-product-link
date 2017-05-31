# M2IF - Product Link Import

[![Latest Stable Version](https://img.shields.io/packagist/v/techdivision/import-product-link.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-link) 
 [![Total Downloads](https://img.shields.io/packagist/dt/techdivision/import-product-link.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-link)
 [![License](https://img.shields.io/packagist/l/techdivision/import-product-link.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-link)
 [![Build Status](https://img.shields.io/travis/techdivision/import-product-link/master.svg?style=flat-square)](http://travis-ci.org/techdivision/import-product-link)
 [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/techdivision/import-product-link/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/techdivision/import-product-link/?branch=master) [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/techdivision/import-product-link/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/techdivision/import-product-link/?branch=master)

## Introduction

This module provides the functionality to import the product links as well as the link positions, 
defined in the CSV file. Actually Related, Upsell + Crosssell links are supported.

## Configuration

In case that the [M2IF - Simple Console Tool](https://github.com/techdivision/import-cli-simple) 
is used, the funcationality can be enabled by adding the following snippets to the configuration 
file

```json
{
  "magento-edition": "CE",
  "magento-version": "2.1.2",
  "operation-name" : "add-update",
  "installation-dir" : "/var/www/magento",
  "database": { ... },
  "operations": [
    {
      "name": "replace",
      "subjects": [
        { ... },
        {
          "id": "import_product_link.subject.link",
          "prefix": "links",
          "observers": [
            {
              "import": [
                "import_product_link.observer.link",
                "import_product_link.observer.link.attribute.position"
              ]
            }
          ]
        }
      ]
    },
    {
      "name" : "add-update",
      "subjects": [
        { ... },
        {
          "id": "import_product_link.subject.link",
          "prefix": "links",
          "observers": [
            {
              "import": [
                "import_product_link.observer.link.update",
                "import_product_link.observer.link.attribute.position.update"
              ]
            }
          ]
        }
      ]
    }
  ]
}
```

## Product Link Positions (CE)

Magento 2 CE supports positions for product links, as well as Magento 2 EE. By default, up to 
version 2.1.6, importing product positions is **NOT** possible in the CE, because the database 
of the CE lack's of missing rows in the `catalog_product_link_attribute` table.

In case, that the rows are not available, the positions, defined in the CSV file's columns 

* `related_position`
* `crosssell_position`
* `upsell_position`

will be ignored.

To enable importing positions, add the following rows the Magento 2 CE database

```sql
INSERT INTO 
        `catalog_product_link_attribute` (
            `link_type_id`, 
            `product_link_attribute_code`, 
            `data_type`
        ) 
    VALUES
        (1,'position','int'),
        (4,'position','int'),
        (5,'position','int');
```

> Make sure, that the values are **NOT** already available, before adding them!