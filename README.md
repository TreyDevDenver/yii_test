# Check In App
This app was created to play around with the Yii 1.1.x framework.

## Requirements
- VirtualBox
- Vagrant

## Installation
1. Add `192.168.56.101 yii.dev` to your hosts file.
2. Start the VM. Run `vagrant up` from this directory.
3. Migrate the database: 
    1. Enter the VM: `vagrant ssh`
    2. Change to the migration directory: `cd /var/www/checkin`
    3. Run the migration tool: `./protected/yiic migrate up`
4. Visit [http://yii.dev](http://yii.dev) in your browser.

## Test
I haven't written any tests yet, but I did get the VM setup with the requirements for doing so. Running that would go like this:
1. Start the VM. Run `vagrant up` from this directory.
2. Change to the test directory: `cd /var/www/checkin/protected/tests`
3. Run PHPUnit as usual: `phpunit`