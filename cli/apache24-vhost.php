<?php
/**
 * Prints a useable apache 2.4 vhost entry
 */

$appDir = getcwd();

$appName = basename($appDir);
$appHostName = $appName.'.dev';

$logDir = '/var/log/apache2';
$accessLogName = $logDir.'/access-'.$appName.'.log';
$errorLogName = $logDir.'/error-'.$appName.'.log';

echo "# apache22-vhost: generated at ".date('r')." by core3\n";
?>

<VirtualHost *:80>

    ServerName <?=$appHostName?>

    ServerSignature Off

    DocumentRoot <?=$appDir?>/
    <Directory <?=$appDir?>/>
        Options FollowSymLinks
        AllowOverride All

        Require all granted
    </Directory>

    <FilesMatch "\.(js|gif|jpg|png|ico|txt|css|svg|eot|ttf|woff|swf|flv)$">
        # ask browser to cache content for 30 days
        Header set Cache-Control "max-age=2592000, public"
    </FilesMatch>

    CustomLog <?=$accessLogName?> combined
    ErrorLog <?=$errorLogName?>

    LogLevel warn

</VirtualHost>
