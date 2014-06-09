## Sending mail

A Mail Transfer Agent (MTA) running on localhost:25 is assumed

Mac OS X comes installed with postfix for this use case,
but it is disabled by default.



## Templates

In template/mail exists default templates.

The .txt and .html files are templates for the text and html version
of the mail. If a .inc file exists, it will be included in order to
configure the mailer object with reusable settings, such as From-address
and Subject.



## Mavericks MTA config

  sudo vi /System/Library/LaunchDaemons/org.postfix.master.plist

add following line before the closing </dict> tag:

  <key>RunAtLoad</key> <true/> <key>KeepAlive</key> <true/>

Start postfix with

  sudo launchctl start org.postfix.master