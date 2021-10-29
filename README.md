# live.glpa.org repository
[live.glpa.org](http://live.glpa.org) is the public facing web site used by delegates of the [Great Lakes Planetarium Association (GLPA)](https://www.glpa.org) to watch live stream content from the annual GLPA conference.

## Getting Started
The live.glpa.org site uses a number of Node.js and JavaScript modules.  To ensure consistent reproduction of the site public files, the gulp automation task runner is used.

### Prerequisites
**Building**
* Node.js -- used to run JS build processes
* npm -- used to acquire Node.js modules

**Running**
* Web server (Apache, Lighttpd, etc)
* PHP (7+) -- 

### Building
To build the site download the Node.js modules and have gulp run the automation tasks.

    npm install
    ./node_modules/gulp/bin/gulp.js

# Installing
The instructions below assume the repository will be downloaded to the server used to host the site.  However, if you wish to build the site locally and then upload you may.  Note that only the `public` and `private` folder need to be hosted on the server. 
> Note: Your `DocumentRoot` should point to the `public` folder.  `public` and `private` should be at the same file system level.


# Built with
* Foundation Sites -- front end framework used to generate the responsive site which is mobile-friendly.
* gulp -- task runner that generates [public](./public) from [src](./src)
* Video.JS -- HTML5-based video player
* Video.JS - HLS Contribution -- Module for Video.JS to play back HLS streams



# Authors
* [PxO Ink LLC](https://pxo.ink) - Architect and original design
* Tom Dobes
* Steve Sumichrast