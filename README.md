# jisc-drupal-bootstrap
Quick-start for Jisc Drupal sites: bootstrap and provision a development VM with Ansible and Vagrant, using a Debian 8 box.

You will need:
- Ansible (2.3.0.0)
- Virtualbox (5.1)
- Vagrant (1.9.5)

Navigate to your home folder and try the following:

$ vagrant init

$ vagrant up --provision

This will take a moment while all the relevant packages are installed.

For a terminal inside the VM:

$ vagrant ssh

Then try:

php -f bootstrap-drupal.php

This will help with the final steps to clone + configure the site.

In the Vagrantfile you'll see that the VM has a fixed IP of 77.77.77.7.
Typically this would be mapped to something more meaningful in your /etc/hosts file.

Known isssues / TODOs:
- Currently only drupal 7 sites
- When configured as described only some search indexes are working
- Automation for the final steps in the bootstrapper is blocked by access credentials and working directory issues
- Solr port is set to 8080 by default, should be 8983 (set here: /admin/config/search/search_api/server/jisc_solr/edit)
