cloud-managment
===============

Console PHP app that interacts with open cloud PHP API to manage a RS cloud environment. 

usage
=====
Run src/app.sh from the command line - you may have to chmod +x the file so that it's executable. This is built on the assumption that you're operating against a Rackspace Cloud account, but it's dependent on the open cloud PHP API so it may work for other providers.

To get things running you must first configure your Rackspace Cloud account settings. Rename the **config/rackspace.env.sample** file to "rackspace.env" and fill in your **username** and **api key**.

There are currently two supported operations:

* list images: lists the images from a particular server<br/><code>./app.sh list-images --server=abcde-1234-fghi-4678 (--data-center=DFW)</code>
* update scaling group's server image - this changes the image ID to use when the scaling group builds up new servers.<br/><code>./app.sh update-scale-group-image --scale-group=scale-group-id --server=server-id</code>

dependencies
===
* [rackspace/php-opencloud](https://github.com/rackspace/php-opencloud)
* [symfony/console](https://github.com/symfony/Console)
* [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)

inspiration
===
Usage of symfony's console library and the commands inspired by Cal Evans: [https://github.com/calevans/phpfromthecli](https://github.com/calevans/phpfromthecli)
