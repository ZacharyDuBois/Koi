# Installation

*v0.2.3*

#### 1)

Download the script and fill out the information in the variables block.

#### 2)

Save the file into your users home directory (Maybe a directory higher than the folder for uploads or done?).

#### 3)

Set the file to permissions of `700`.

    chmod 700 /path/to/night-updater

#### 4)

Add a cronjob in your crontab.

    crontab -e
    0 3 * * * /path/to/night-updater

#### 5)

Add a test file and let it run over night. Check in the morning to see if it's in S3 and the done folder.

Copyright (c) Zachary DuBois, 2014. All Rights Reserved.
