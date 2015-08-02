# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Render filters, titles, pagination at any location...

# Introduction #
You may need to render each part from the grid on different locations of your page.

You can achieve this by calling the render() method in your view.

```
$this->grid->render('pagination');
//Will display:
//<tr><td>_content_</td></tr>
```

The render method accepts a second argument which intention is to surround the rendered part with the global start and end (<table></table>);

```
$this->grid->render('pagination',true);
//Will display:
//<table><tr><td>_content_</td></tr></table>
```

## Available Parts ##
  * detail
  * message
  * form
  * start
  * extra
  * header
  * titles
  * filters
  * grid
  * pagination
  * end