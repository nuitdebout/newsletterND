set :user, 'root'
set :use_sudo, false

set :application, 'newsletter'
set :repo_url, 'git@github.com:nuitdebout/newsletterND.git'

set :symfony_directory_structure, 2
set :sensio_distribution_version, 5

set :format, :pretty
set :log_level, :info

set :permission_method, "acl"

set :linked_files, ["app/config/parameters.yml"]

# read https://github.com/capistrano/symfony/pull/37
namespace :symfony do
  desc "Fix cache permissions if deploy user is different from apache user"
  task :fix_file_permissions do
    on roles :all do
      paths = absolute_writable_paths
      execute :setfacl, '-R -m u:"www-data":rwX -m u:`whoami`:rwX', *paths
      execute :setfacl, '-dR -m u:"www-data":rwX -m u:`whoami`:rwX', *paths
    end
  end
end

SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"

namespace :deploy do
  after :starting, 'composer:install_executable'
  after :updated, 'symfony:fix_file_permissions'
end
