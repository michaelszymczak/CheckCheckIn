# How to contribute

If you think that some esential feature is missing or there is some bug in the codebase, please submit a ticket on github. You can then fork and make a pull request.
Keep in mind that pull request will be accepted subject to my approval (code review) and CI build status.
Changes increasing technical debt like untested code or poor design will be rejected.


## Setting up a development environment

Install the newest [Vagrant](http://www.vagrantup.com/downloads.html) and [Virtualbox](https://www.virtualbox.org/wiki/Downloads).
Install them **from the official site**, not from the system repository, so that you can have the newest versions.

Change directory to the just cloned repository fork and provision the guest virtual machine:

    cd PATH/TO/MY/REPO
    git clone https://github.com/michaelszymczak/independentfrontend.git -b symfony provisioning
    vagrant up

After some time the guest machine will be provisioned. Ssh to it, go to project directory and build the app.

    vagrant ssh
    cd /vagrant
    ant

If the tests pass, you can start (hopefully test driven) development. Enjoy.