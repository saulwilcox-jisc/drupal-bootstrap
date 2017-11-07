# drupal-bootstrap
Quick-start for Drupal sites: bootstrap and provision a development VM with Ansible and Vagrant, using a Debian 8 box. Includes SOLR.

You will need:
- Ansible (2.3.0.0)
- Virtualbox (5.1)
- Vagrant (1.9.5)

First get a vagrant base box:
vagrant box add --name debian-jessie https://github.com/kraksoft/vagrant-box-debian/releases/download/8.1.0/debian-8.1.0-amd64.box

Navigate to your home folder and try the following:

$ vagrant init

$ vagrant up --provision

This will take a moment while all the relevant packages are installed.

For a terminal inside the VM:

$ vagrant ssh

Then try:

$ php -f bootstrap-drupal.php

This will help with the final steps to clone + configure the site.

In the Vagrantfile you'll see that the VM has a fixed IP of 77.77.77.7.
Typically this would be mapped to something more meaningful in your /etc/hosts file.

You'll still need to run the drupal install script, clone sites & modules and import a database.

# Search

You can create a SOLR core from a configuration file, for example:

$ /opt/solr-6.5.1/bin/solr create_core -c jisc -d /var/www/jisc-ac-uk/sites/all/modules/contrib/search_api_solr/solr-conf/6.x

Make sure all the Search indexes are activated and present on the Solr core - note that 'drush searchapi-index 0 0 100' probably won't index everything - it's better to index them in the admin interface.

When that's all done, the usual 'drush cc all' command should give you a working site.

Troubleshooting shared folders:
- Try using the rsync folder type in the Vagrantfile instead of VFS:
  config.vm.synced_folder "~/project", "/var/www", type: 'rsync'
  Then use 'vagrant rsync auto' to watch the files and sync as they change.
- You can keep your VirtualBox Guest additions up to date automatically using the following plugin:
  vagrant plugin install vagrant-vbguest

Known isssues / TODOs:
- Currently only drupal 7
- Solr port is set to 8080 by default, should be 8983 (change it here: /admin/config/search/search_api/server/[server]/edit)
