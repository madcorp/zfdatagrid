# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Setting up Paging


# Introduction #

Setting the number of records per page is one simple and easy task. You can make two choices:
  * Limit the amount of records displayed
  * Show all records at once

No matter what choice you made, it's done with the same method.

After your grid is instantiated just use the !setRecordsPerPage() method

```
$grid->setRecordsPerPage(10)//Will show 10 records per page
$grid->setRecordsPerPage(0)//Will show all records in one page
```

<font color='red'><b>Attention:</b></font> Pagination won't take any effect when you explicitly set a limit in your query clause

## Example ##
```
$select = new Zend_Db_Select();
$select->from('table')
$select->limit(19);
```
Using the above code all 19 records will be shown in one page, without giving the user the ability to remove it

## Changing number of records per page ##
You can give users the ability to change the number of records per page by adding this code

```
$grid->setPaginationInterval(array(10 =>10, 20 => 20, 50 => 50, 100 => 100));
```

Or

```
$grid->setPaginationInterval(array(10 =>'ten', 20 => 'twenty'));
```

**The default value for pagination is _20_**