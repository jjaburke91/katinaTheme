# jordanmuir.co.uk

## Development

`npm run development`

## Deploying

Run the local production script and add the generated files to the repository. Script is run with:

`npm run production`

Commit these files and push onto the `production` branch.

Finally, SSH (private key should be in your local .ssh _jamie_) onto the host server, go the theme's folder and pull in this branch.

---

`dist/dist-app.js` is old but left for any caching issues while phasing in new file. Remove this at a later date.

---

### Documentation to add:

* Custom controller for JSON API
    * Retrieving the Attachments Plugin content.
* Attachments plugin
* Custom Meta Box
* Cloudinary

### Plugins Used
* Cloudinary
* Attachments
* WP-API
