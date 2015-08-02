# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Config options available for each render class



# Introduction #
This page has all options that the deploy class accepts.

# Fields #
How to build
```
fields.FIELD_NAME.option = Value:
```

Full list
```
;fields.Name.title = "Field Title" ;Title to display
fields.Name.remove = false ;Defaults 0 
fields.Name.style = "" ;Defaults "" 
fields.ID.escape = 1 ;
fields.ID.translate = 1 ;
fields.Name.hidden = false ;Defaults 0
fields.Name.decorator = "{{Name}}"
fields.Name.hRow = false ;Defaults 0
;fields.Name.position = 2; Field presentation position
;fields.Name.order = 1 ;If a field can be ordered. Defaults 1
;fields.Name.orderField = "ID" ;Defaults null
fields.Name.class = "width_150"  ;Defaults null
;fields.Name.searchType = "="
;fields.Name.searchField = "";Field where the search will be performed
;fields.Name.searchTypeFixed = (0|1) ;Defaults 0 
;fields.Name.search.fulltext = true
;fields.Name.search.indexes = Name
;fields.Name.search.extra = queryExpansion

;fields.Name.format.function = date
;fields.Name.format.params.locale = "fr_FR"

;fields.Name.callback.function = "my_function"
;fields.Name.callback.class = $this
;fields.Name.callback.params.something = {{Name}}


```

# Deploy Formats #


## CSV ##
```
deploy.csv.dir = "media/temp"; dir to save documents
deploy.csv.save = 1;
deploy.csv.display = 1;
deploy.csv.download = 1;
deploy.csv.memory_limit = "128M";
deploy.csv.set_time_limit = 3600;
```


## Excel ##
```
deploy.excel.dir = "media/temp"; dir to save documents
deploy.excel.name = "barcelos"; dir to save documents
deploy.excel.save = 1;
deploy.excel.download = 1;
```


## JSON ##

The JSON output format takes no arguments.

## ODS (Open Document Format (Text)) ##
```
deploy.ods.dir = "media/temp"; dir to save documents
deploy.ods.name = "my_name"; Document Name
deploy.ods.save = 1;
deploy.ods.download = 1;
```


## ODT (Open Document Format (spreadsheet)) ##
```
deploy.odt.dir = "media/temp"; dir to save documents
deploy.odt.name = "my_name"; Document Name
deploy.odt.save = 1;
deploy.odt.download = 1;
deploy.odt.title = "Document title"
deploy.odt.subtitle = "Document subtitle"
deploy.odt.logo = "PATH_TO_LOGO"
deploy.odt.footer = "Footer message"
```


## OFC (Open Flash Chart) ##
```
deploy.ofc.files.json = "/grid/public/scripts/json/json2.js";
deploy.ofc.files.js = "/grid/public/scripts/swfobject.js";
deploy.ofc.files.flash = "/grid/public/flash/open-flash-chart.swf";
deploy.ofc.options.set_bg_colour = '#FFFFFF';
deploy.ofc.title = 'Chart Title';
deploy.ofc.dimensions.x = 900 
deploy.ofc.dimensions.y = 400
deploy.ofc.type = 'Bar_Glass'
```


## PDF ##
```
deploy.pdf.title = "Page Title"
deploy.pdf.dir = "media/temp";dir to save documents
deploy.pdf.save = 1;
deploy.pdf.download = 1;
deploy.pdf.logo = "public/images/logo.png"
deploy.pdf.title = "DataGrid Zend Framework"
deploy.pdf.subtitle = "Easy and powerfull - (Demo document)"
deploy.pdf.footer = "Downloaded from: http://www.petala-azul.com "
deploy.pdf.size = "a4"; (A4|LETTER) Default- a4
deploy.pdf.orientation = "LANDSCAPE"; (LANDSCAPE|PORTRAIT) DEFAULT- portrait
deploy.pdf.page =" Page N."; Text before page numbers

; PDF COLORS
deploy.pdf.colors.title = #000000
deploy.pdf.colors.subtitle = #111111
deploy.pdf.colors.footer = #111111
deploy.pdf.colors.header = #AAAAAA
deploy.pdf.colors.row1 = #EEEEEE
deploy.pdf.colors.row2 = #FFFFFF
deploy.pdf.colors.sqlexp = #BBBBBB
deploy.pdf.colors.lines = #111111
deploy.pdf.colors.hrow = #E4E4F6
deploy.pdf.colors.text = #000000
deploy.pdf.colors.filters = #F9EDD2
```


## Print ##
```
deploy.print.dir = "media/temp"; dir to save documents
deploy.print.name = "my_name"; Document Name
deploy.print.save = 1;
deploy.print.download = 1;
deploy.print.title = "Document title"
```


## Table ##
```
deploy.table.imagesUrl = "/grid/public/images/"; The url for images 
deploy.table.template = "outside"; The template to be used
deploy.table.templateDir = "My_Template_Table"; Other dir with templates
```


## Word ##
```
deploy.word.dir = "media/temp"; dir to save documents
deploy.word.name = "my_name"; Document Name
deploy.word.save = 1; ;Save the file on disk
deploy.word.download = 1; Download file
```


## Word (.docx) ##
```
deploy.wordx.dir = "media/temp"; dir to save documents
deploy.wordx.name = "my_name"; Document Name
deploy.wordx.save = 1;
deploy.wordx.download = 1;
deploy.wordx.title = "Document title"; Title for document
deploy.wordx.subtitle = "Document subtitle"; Subtitle for document
deploy.wordx.logo = "PATH_TO_LOGO"; PATH to logo 
deploy.wordx.footer = "Footer message"; Footer message
```


## XML ##
```
deploy.xml.dir = "media/temp"; dir to save documents
deploy.xml.save = 1;
deploy.xml.display = 1;
deploy.xml.download = 1;
deploy.xml.name = "The_file_name.xml";
```

# Extra Rows #
```
extra.row.one.position = beforePagination
extra.row.one.colspan=5
extra.row.one.content = My Content
extra.row.one.class = css_class

extra.row.two.position = afterPagination
extra.row.two.colspan=5
extra.row.two.content = This is just an example
extra.row.two.class = my_class
```