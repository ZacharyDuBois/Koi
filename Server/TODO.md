# TODO

### For v1

- More file type icons (and custom ones).
- Update checks.
- No database or complex configs.
- Very nice UI.
- Easy setup.
- CDNify/CloudFront/CDN integration.
- Robots.txt.
- New upload script (Max & Linux for now).
- Upload notifications (Pushover).
- AWS S3 and B2 storage backend (Requires file cache and wait page for large files [user configurable]).
- Json cache of index.
- Tmp uploads (screenshot service, etc)

### For v2

- Pastebin.
- API w/ keys.
- Tracking.
- OSX file share/service.
- Add more push notification services.
- Add video/media pages.
- i18n.

### For v2.1

- System information tracking (Opt-in when/if I make something for it).
- Plugin system.

### For v3

- Multi file upload.
- Upload progress indication.
- User permission system.

## Side notes

- If using a CDN in front of it, prompt for a read-only domain to prevent the caching of the administration login.
- I have no idea how much value statistical links will be since the CDN will cache it and not send a request for each hit.
- Fix installer
- Tie users to files.
- Subdomain or URI setup for different secions.
