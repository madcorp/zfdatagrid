# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Multiple languages


# Introduction #

Internationalization is almost a must have feature.

ZFDatagrid makes this incredible easy.

You just need to register your Zend\_Translator instance in the Registry like this:

```
Zend_Registry::set('Zend_Translate',Zend_Translate_Instance $translate);
```

## What is translated? ##

  * Pagination
  * Fields Titles
  * Strings like: remove order, remove filters,
  * PDF supporting text: (title, page, subtitle, etc, )
  * Results form CRUD operations (Please note that validation messages are from Zend\_Form)