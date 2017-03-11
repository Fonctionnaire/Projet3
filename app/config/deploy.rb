set :application, "Projet_3"
set :domain,      "projet4.mes-siteweb-formation-oc.fr"
set :deploy_to,   "/var/www/projet4.mes-siteweb-formation-oc.fr"
set :app_path,    "app"

set :repository,  "#git@github.com:Fonctionnaire/Projet3.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL