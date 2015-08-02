# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary A simple way to render specific fields to specific renders



# Introduction #

If you render your data in several formats you probably want to render different fields based on format render.


# How? #

Let's suppose you have a query with 5 fields.

```
Name, City, Country, Id, Sex
```

Those fields will appear in every format you render. But if you want the table to have the Id field but the PDF not?

```
$grid->setPdfGridColumns(array('Name', 'City', 'Country', 'Sex'));
```
The code above will make that the PDF won't render the Id field.

You can do this to every deploy format. You only need to use this method

```
$grid->set[Deploy]GridColumns(array());
```

Examples:
```
$grid->setTableGridColumns(array());
$grid->setJsonGridColumns(array());
$grid->setCsvGridColumns(array());
$grid->setXmlGridColumns(array());
```