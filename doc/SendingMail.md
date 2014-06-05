## Sending mail

A Mail Transfer Agent (MTA) running on localhost:25 is assumed

Mac OS X comes installed with postfix for this use case,
but it is disabled by default.



## Mavericks MTA config

  sudo vi /System/Library/LaunchDaemons/org.postfix.master.plist

add following line before the closing </dict> tag:

  <key>RunAtLoad</key> <true/> <key>KeepAlive</key> <true/>

Start postfix with

  sudo launchctl start org.postfix.master