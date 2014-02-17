set :application,   "TrendVoter"


task :production do
  set :domain,        "grampa2.trendone.com"
  set :deploy_to,     "/var/www/vote.trendone.com/www"
  role :web,        domain                         # Your HTTP server, Apache/etc
  role :app,        domain, :primary => true       # This may be the same as your `Web` server
end


#task :testing do
#  set :domain,        "staging.trendone.com"
#  set :deploy_to,     "/var/www/trendexplorer.com/testing"
#  role :web,        domain                         # Your HTTP server, Apache/etc
#  role :app,        domain, :primary => true       # This may be the same as your `Web` server
#end


set :use_sudo,      false
set :user,          "trendone"
set :app_path,      "app"

set :writable_dirs,       [app_path + "/cache", app_path + "/logs", app_path + "/Resources/assets", web_path + "/media"]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true

set :repository,  "."
set :deploy_via,  :capifony_copy_local
# set :deploy_via,  :rsync_with_remote_cache
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,   [app_path + "/logs", app_path + "/Resources/assets", web_path + "/media"]

set :use_composer,      true
set :use_composer_tmp,  true

set :keep_releases,     3

task :upload_parameters, :roles => :app do
  capifony_pretty_print "--> Copying parameters.yml to temp location"
  
  origin_file = "app/config/parameters.yml"
  destination_file = $temp_destination + "/app/config/parameters.yml"
  
  run_locally "cp #{origin_file} #{destination_file}"
  capifony_puts_ok
end

before "symfony:composer:install", "upload_parameters"

namespace :deploy do
  task :dump_assets_locally, :roles => :web do
    capifony_pretty_print "--> Dumping assets to temp location"
    run_locally "cd #{$temp_destination} && app/console assetic:dump --env=#{symfony_env_prod} --no-debug"
    capifony_puts_ok
  end
end

after "symfony:bootstrap:build", "deploy:dump_assets_locally"

namespace :symfony do
  desc "Clear apc cache"
  task :clear_apc do
    capifony_pretty_print "--> Clear apc cache"
    run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} apc:clear --env=#{symfony_env_prod}'"
    capifony_puts_ok
  end
end

after "deploy", "symfony:clear_apc"

# logger.level = Logger::MAX_LEVEL