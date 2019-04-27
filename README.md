#ddb
phinx：php vendor/bin/phinx create MyNewMigration
本地环境下 phinx脚本执行：
vendor/bin/phinx migrate -e local

makemodels命令：
cd app
php bin/makemodels.php 表名

rabbit:开启rabbitmq_management