# Night Uploader

*v0.3.1*

## Features

- Uploads files to AWS S3 over night to prevent slow internet during the day.
- Pushover support.
- Uploads a list of the last uploaded files.
- Creates an automatic index file that lists everything (minus folders) located in the root of your S3 bucket.
- Index file is customizable to fit your needs.
- Checks to see if there is already an instance of AWS running.

## Requirements

- Bash
- [AWS CLI](http://aws.amazon.com/cli/) `pip install awscli`
- Curl (If you want Pushover support).
- Cron

## Notices

- Currently running this on my Raspberry Pi to upload files over night so I don't have slow internet during the day or need to leave my computer on over night.
- I recommend this to be run by a cronjob once a day at 3am. Example in the `INSTALLATION.md`.
- Recommended file permissions of `700` due to it containing API keys.
