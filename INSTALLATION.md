# Installation

*v0.3.1*

#### 1)

Install and completely configure the AWS CLI.

`pip install awscli`

Documentation on configuring the AWS CLI can be found [here](http://aws.amazon.com/cli/).

#### 2)

Download Night Uploader and make a place for all of the files in the `templates` directory. Take note of the location.

#### 3)

Set the file to permissions of `700`.

    chmod 700 /path/to/night-updater

#### 5)

Open the `night-uploader` file and look at the variables block.

Set `location` to the directory where files will be put for pending upload.

Set `s3bucket` to the name of the S3 bucket you would like Night Uploader to upload to.

Set `endLocation` to where the files are moved after the have been uploaded.

Set `templateLocation` to where the place where you put the template files that came in the `templates` directory of the download (You were told to take a note of it!). This directory must not be located in the `endLocation` or `location` directories and must be accessible to the script.


#### 6) [Optional]

Setup [Pushover](https://pushover.net) support for sending of notifications about uploads and statuses.

Set `pushoverAppKey` to your private application key on Pushover.

Set `pushoverUserKey` to your user key (or a group key).

Set `pushoverTitle` for what you want the title of the notifications to be.

Set `pushoverURL` to the URL you want Pushover to have a link for.

Set `pushoverURLTitle` for a title to the URL above.

#### 7) [Optional]

Add a cronjob in your crontab to run the script one a day at 3am.

    crontab -e
    0 3 * * * /path/to/night-updater

#### 8)

Add a test file and let it run over night. Check in the morning to see if it's in S3 and the done folder.

# Customization

If you want to be able to use your own index theme or HTML, you can! Open up the template files and edit away! Just make sure not to change the file names. Below is how these files are loaded by the script.

    head
    [List Items]
    afterlist
    [Number of files]
    [Timestamp]
    [Project info]
    footer

Items in brackets `[]` are added by the script and items not in brackets are added directly from that named template file.
