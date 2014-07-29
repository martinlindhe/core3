## Getting started, first app

in dev root dir:

```
git clone core3 https://github.com/martinlindhe/core3
cd core3
composer install
cd ..

mkdir my_core3_app
cd my_core3_app
ln -s ../core3
core3/console init-app
```

app skeleton files and directorires will be created





# Apache setup


From your application root,
the following commands will output a suitable vhost entry:

  core3/console apache22-vhost      # for Apache 2.2

or

  core3/console apache24-vhost      # for Apache 2.4
