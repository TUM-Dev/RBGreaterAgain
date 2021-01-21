# RBGreaterAgain

This project was created to redesign the Livestream and VoD website of the [RBG-Multimedia](https://www.in.tum.de/rbg) group ([live.rbg.tum.de](https://live.rbg.tum.de/)).
This project is available at [live.tum.sexy](https://live.tum.sexy) or [stream.tum.sexy](https://stream.tum.sexy).  
It uses HTML-Scraping to get the necessary information from the original page and then wraps it into a modern, dark-themed UI.
Currently, you can watch live streams and VoDs via the custom UI. Archives are not covered yet.

## Features, that are not yet implemented
- Download Button
- Custom Window Management (Drag and Drop Windows)


## Contribution
If you want to contribute, please create a pull request and just wait for it to be reviewed ;)

## Getting started

### Dependency management
All the dependencies can be installed by running (assuming npm and composer are installed): 
```bash
npm install --unsafe-perm
composer install
```

### PHP-Development
**TODO** for someone with a good Development setup should add this

### Docker 
Why? Testing if the Dockerfile will work if tried to deploy the Image it generates.  
Recommended if you did non-trivial change.
#### Building the docker Image (for local testing)
```bash
docker build -t rgbreateragain .
```
#### Running the Image
```bash
 docker run -dp 80:7000 rgbreateragain
```
you can now go to http://127.0.0.1:7000/ and test, if the server works.