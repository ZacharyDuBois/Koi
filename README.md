# Night Uploader

*v0.1*

## Features

- Uploads files to AWS S3 over night to prevent slow internet during the day.
- *More Coming*

## Requirements

- Bash
- [AWS CLI](http://aws.amazon.com/cli/) `pip install awscli`
- Cron

## Notices

- I currently run this on my Raspberry Pi to upload files over night so I don't have slow internet during the day or need to leave my computer on over night.
- I recommend this to be run by a cronjob once a day at 3am. Example in the `INSTALLATION.md`.
- I also recommend you set the file permissions to `700` because it contains many API keys that you don't want watching eyes to see.

Copyright (c) Zachary DuBois, 2014. All Rights Reserved.
