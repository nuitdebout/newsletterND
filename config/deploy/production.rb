set :stage, :prod
set :symfony_env, "prod"

set :branch, 'master'
set :deploy_to, '/var/www/newsletter'

set :controllers_to_clear, ["app_*.php"]
set :composer_install_flags, '--prefer-dist --no-interaction --optimize-autoloader'

server 'nuitdebout.fr', port: 22, roles: %w{app db web}