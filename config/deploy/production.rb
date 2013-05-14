server "biff.silverstripe.com", :app, :web, :db, :primary => true
set :deploy_to, "/sites/userhelp.silverstripe.org"
set :user, "sites"
set :webserver_group, "sites"
set :port, 2222