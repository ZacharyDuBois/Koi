# Change Log

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

