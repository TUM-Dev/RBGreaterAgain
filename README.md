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
There are two main ways of developing for this Project. Native has the advantage of speed and Docker the advantage of how easy it is to get started.
Doing the final tests in Docker is recommended, because we use Docker in production.
### Native Development
#### Windows
Install 
- [npm](https://www.npmjs.com/get-npm)
- [composer](https://getcomposer.org/)
- [PHP](https://www.php.net/)
- [Apache](https://sourceforge.net/projects/wampserver/)
- [apcu](http://pecl.php.net/package/APCu) (choose the version that is compatible with your PHP-version and system)

#### Linux
##### Hard dependencies
Install dev-dependencies using
```bash
sudo apt install apache php libapache2-mod-php php-apcu npm composer
```

#### Configure Apache
Add inside `VirtualHost`
```apacheconf
<Directory /var/www/html>
AllowOverride All
Require all granted
</Directory>
```
to the configuration-file at `/etc/apache2/sites-available/000-default.conf`

#### Let PHP know about apcu
Create a file `/etc/php/PHPVERSION/apache2/conf.d/apcu.ini` where `PHPVERSION` is your current PHP-Release. The content of this file should be
```apacheconf
extension=apcu.so
```

#### Enable apache rewriteengine and php
```bash
sudo a2enmod rewrite php[7.4]
sudo systemctl restart apache2.service
```

#### Clone to `/var/www/html`
```bash
sudo chown $USER /var/www/html
git clone https://github.com/TUM-Dev/RBGreaterAgain.git /var/www/html
```
##### Dependency management
All the dependencies can be installed by running in `/var/www/html`: 
```bash
npm install
composer install
```

### Docker
Install  [Docker](https://docs.docker.com/get-docker/)
#### Building the docker Image (for local testing)
```bash
docker build -t rgbreateragain .
```

#### Running the Image
```bash
docker run -p 7000:80 rgbreateragain
```
You can now go to [localhost:7000](http://localhost:7000/) and test, if the server works.