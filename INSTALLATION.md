# Installation

*v0.4.2*

#### 1)

Install and completely configure the AWS CLI.

`pip install awscli`

Documentation on configuring the AWS CLI can be found [here](http://aws.amazon.com/cli/).

If you need an example AWS config file, you can look in `examples/awsconfig`.

#### 2)

Night Uploader needs four directories:

- An upload directory.
- An dump directory.
- A template directory.
- And a temporary files directory.

Make these and take note of the locations.

#### 3)

Set the file to permissions of `700`.

    chmod 700 /path/to/night-updater

#### 5)

Open the `night-uploader` file and look at the variables block.

Set `loc` to the directory where files will be put for pending upload.

Set `s3bucket` to the name of the S3 bucket you would like Night Uploader to upload to.

Set `endLoc` to where the files are moved after the have been uploaded.

Set `templateLoc` to where the place where you put the template files that came in the `templates` directory of the download (You were told to take a note of it!). This directory must not be located in the `endLocation` or `location` directories and must be accessible to the script.

Set `temporaryDirLoc` to where you want Night Uploader to put temporary files it generates.

Now, you need to upload everything in the `upload/` folder that comes with Night Uploader to your S3 bucket @ `s3://yourbucketname/assets/`. Otherwise, the Index page will not load the required CSS and JS to work.


#### 7) [Optional]

##### Pushover

Setup [Pushover](https://pushover.net) support for sending of notifications about uploads and statuses.

Set `pushoverAppKey` to your private application key on Pushover.

Set `pushoverUserKey` to your user key (or a group key).

Set `pushoverTitle` for what you want the title of the notifications to be.

Set `pushoverURL` to the URL you want Pushover to have a link for.

Set `pushoverURLTitle` for a title to the URL above.

##### Fail Time

Set `failTime` to how many seconds you want Night Uploader to wait for a running AWS process to complete.

##### Set File Types

Preset, there are regular expressions to match file extensions. These can be modified to whatever file types you want.

*Warning: Editing the audio and video types will mess with the `transcodeMedia` function. Make sure you know what AWS ETC supports when editing.*

- `formatVideo`
- `formatAudio`
- `formatCode`
- `formatPDF`
- `formatImage`
- `formatArchive`

#### 8) Workflows

By default, when Night Uploader runs, it runs the workflow ID `1`. To make NightUploader run others, you can run Night Uploader by passing an argument for it (In this case, a workflow ID number). Since Night Uploader comes with two handy workflows, you can run `./nightuploader 1` (or `./nightuploader`) to run the first and `./nightuploader 2` to run the second. You can edit how the workflows run by editing the bottom of the Night Uploader script to your liking.

Currently, the following functions work:

- `makeNewFilesList`
- `uploadFiles`
- `cleanUp`
- `moveFiles`
- `transcodeMedia`
- `makeIndex`

#### 9) CronJob

Add a cronjob in your crontab to run the script one a day at 3am. Make sure to include a workflow ID if you have a specific one you want it to run.

    crontab -e
    0 3 * * * /path/to/night-updater

#### 10)

Add a test file and let it run over night. Check in the morning to see if it's in S3 and the done folder.

# Customization

If you want to be able to use your own index theme or HTML, you can! Open up the template files and edit away! Just make sure not to change the file names. Below is how these files are loaded by the script.

    head.html
    [List Items]
    afterlist.html
    [Number of files]
    [Timestamp]
    [Project info]
    footer.html

Items in brackets `[]` are added by the script and items not in brackets are added directly from that named template file.

For an easy color or CSS/JS tweak, you can also edit the `assets/night/*` with whatever you want because it is already loaded on the page.
