# jisc-drupal-bootstrap
Quick-start for Jisc Drupal sites: bootstrap and provision a development VM with Ansible and Vagrant.

You will need:
- Ansible (2.3.0.0)
- Virtualbox (5.1)
- Vagrant (1.9.5)

Navigate to your home folder and try the following:
$ vagrant init
$ vagrant up --provision

For a terminal inside the VM:
$ vagrant ssh

In the Vagrantfile you'll see that the VM has a hardcoded IP of 77.77.77.7.
Typically this would be mapped to something more meaningful in your /etc/hosts file.
