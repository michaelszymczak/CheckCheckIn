# -*- mode: ruby -*-
# vi: set ft=ruby :

# this file shows that all the configuration is ignored when you launch vagrant up from the directory above

Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/trusty32"
  config.vm.provision :shell, :path => "provisioning/provisioning/manifests/bootstrap.sh"
  config.vm.hostname = "localdev"

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "provisioning/provisioning/manifests"
    puppet.manifest_file  = "site.pp"
    puppet.module_path = ["provisioning/provisioning/manifests/modules"]
  end

  config.vm.provider "virtualbox" do |v|
    v.memory = 512
  end

end
