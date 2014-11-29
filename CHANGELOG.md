# Change Log

## v0.4.1

- Tiny HTML fixes.
- Hide output of ETC creations.
- Add Pixelmator extension.

## v0.4

- Moves most tasks into functions.
- Better output logging.
- Adds different `runType`s.
- Changes generation files names and extensions.
- AWS process conflict now has a variable fail time and sends notifications via Pushover.
- Adds workflows so you can create a custom setup easily.
- Adds a separate place for temporary files.
- Changes a lot of the configuration variables.
- Adds automatic Elastic Transcoding of media files.
- Waits for transcoding to fully finish.
- Fixes and/or logic in the variable check.
- Adds file type icons to the listing based on extention.
- More sleek interface made with Bootstrap and Font Awesome.

### v0.3.1

- Re-Licensed the code correctly this time. Now it is correctly under MIT.

### v0.3

- Generates an index.html file from listing of root items.
- Fixes issue #1 where the New-Uploads.txt would contain itself.
- More startup checks to make sure everything runs properly.
- Checks to make sure no more than one AWS command is running at a time. It will wait if there is already an AWS process running.
- Automatically sets read permissions to newly uploaded items.
- Makes use of tmp files.

### v0.2.4

- Cleans up the output of running.
- Gives more information to find a point of failure.
- Checks for both Pushover App and User keys now.

### v0.2.3

- Adds a list of newly added files when files are uploaded.

### v0.2.2

- Adds back most startup checks.
- Adds `$PATH` that caused the AWS and which commands to not work.

### v0.2.1

- Priority should be 0 for Pushover.
- Removes startup checks. They caused issues on some systems.

### v0.2

- Pushover!

### v0.1

- Initial release.
