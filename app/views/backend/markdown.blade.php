@extends('layout.main')

  
@section('content')
<?php $tab = 4; ?>
@include('backend.include.nav')
<?php
$output = <<<MARKDOWN

#Markdown Guide

Markdown is an easy way to write web pages without having to write real code.

Here's the most common things you'll want to do. 


<br />
---
##Headers

Headers care created by putting a "#" at the beginning of the line.

```
##Header 1
###Header 1
####Header 1
#####Header 1
etc...
```

would be output as: 

##Header 1
###Header 1
####Header 1
#####Header 1
  
  
<br />
---
##Quotes
quotes have `>` at the beginning of each line.

```
> This is a block quote
> on multiple lines.
```
output as:
> This is a block quote
> on multiple lines.

  
  
<br />
---
##Bold and Italic

```
this is **bold** this is *italic*
```
output as:

this is **bold** this is *italic*

<br />
---
##Lists
A numbered list has `1.` or whatever number at the beginning. Bulleted lists begin with a minus sign `-`.

```
Numbered List
1. This is item one
1. This is item two (automaticly numbered)
1. This is item three

Bulleted List
- This is item one
- This is item two (automaticly numbered)
    - Sub Item
- This is item three
```

Numbered List
1. This is item one
1. This is item two (automaticly numbered)
1. This is item three

Bulleted List
- This is item one
- This is item two (automaticly numbered)
    - Sub Item
- This is item three

<br />
---
##Links
links are done in this format.
```
[Click here to go to Google.com](https://www.google.com/)
[Space between doesn't work ->] (broken.com)
```
[Click here to go to Google.com](https://www.google.com/)
[Space between doesn't work ->] (broken.com)

MARKDOWN;
?>

{{ Markdown::instance()->set_breaks_enabled(true)->parse($output) }}

@stop
