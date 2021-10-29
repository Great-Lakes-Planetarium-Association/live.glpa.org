# live.glpa.org repository
[live.glpa.org](http://live.glpa.org) is the public facing web site used by delegates of the [Great Lakes Planetarium Association (GLPA)](https://www.glpa.org) to watch live stream content from the annual GLPA conference.  The site produces a list of the currently active streams and the content on each stream.  Viewers are able to select from a variety of streaming options.

## Getting Started
The live.glpa.org site uses a number of Node.js and JavaScript modules.  To ensure consistent reproduction of the site public files, the gulp automation task runner is used.

### Prerequisites
* Node.js -- used to run JS build processes
* npm -- used to acquire Node.js modules
* Web server (Apache, Lighttpd, etc)
* PHP (7+) -- 

### Installing
From the root directory of this repository:

    npm install
    ./node_modules/gulp/bin/gulp.js

Point your web server to `/path/to/repo/public` as the Document Root.

# Built with
* Foundation Sites -- front end framework used to generate the responsive site which is mobile-friendly.
* gulp -- task runner that generates [public](./public) from [src](./src)
* Video.JS -- HTML5-based video player
* Video.JS - HLS Contribution -- Module for Video.JS to play back HLS streams



# Authors
* [PxO Ink LLC](https://pxo.ink) - Architect and original design
* Tom Dobes
* Steve Sumichrast