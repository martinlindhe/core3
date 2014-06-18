# Introduction

The system views are default templates,
by using the same names and putting them in your app/view,
the application views are used instead.


The user views can only contain a-z, A-Z, 0-9 and "-",
all other characters are reserved.


Available variables:
    $request  string   web request
    $view     string   name of the view
    $param    array    the parameters passed to this view
    $webRoot  string   application web root, eg "/" or "/app1"


# TODO use default system views for header, footer, css ?



# 404-notfound

The view for invalid url:s

