<?php
// Drupal sites + version info
$drupal_sites = [
    "jisc-ac-uk" => [
        "drupal_version" => "7.x",
        "repository_url" => "https://github.com/janetuk/jisc-ac-uk"
    ],
    "elevator" => [
        "drupal_version" => "7.x",
        "repository_url" => "https://github.com/janetuk/elevator"
    ],
    "community" => [
        "drupal_version" => "7.x",
        "repository_url" => "https://github.com/janetuk/technetnew"
    ],
    "myjisc" => [
        "drupal_version" => "8",
        "repository_url" => "https://github.com/janetuk/myjisc"
    ]
];

$sitestip = "";
$_i=0;
foreach($drupal_sites as $site => $drupal_version){
    $sitestip .= $_i . ": ";
    $sitestip .= $site . PHP_EOL;
    $_i++;
}

// Prompt for site
reset($drupal_sites);
$first_key = key($drupal_sites);
echo "Which repository / site? (".$first_key.")\n";
echo $sitestip;
$in = fgets(STDIN);
$site_keys = array_keys($drupal_sites);

// Allows entering a number instead of the shortname
if ( intval($in) == $in ){
    $selected_site = $site_keys[intval($in)];
} else if(array_key_exists($in, $site_keys)){
    // Typed directly? Fine, otherwise...
} else {
    die("Site not known.".PHP_EOL);
}

$drupal_version = $drupal_sites[$selected_site]['drupal_version'];

// Download Drupal
$drush_install_command = "drush dl drupal-". $drupal_version ." --destination=/var/www --drupal-project-rename=" . $selected_site;
// shell_exec($drush_install_command);
echo $drush_install_command.PHP_EOL;

// Clone site repo
$git_clone_command = "git clone ".$drupal_sites[$selected_site]['repository_url'] ." git-temp";
// shell_exec($git_clone_command);
echo $git_clone_command.PHP_EOL;

// Copy cloned git repo into drupal install folder
$rsync_command = "rsync -a git-temp/ /var/www/" . $selected_site . "sites";
// shell_exec($rsync_command);
echo $rsync_command.PHP_EOL;

// git init in var/www/[site], add origin and track master
// git init
// git remote add origin https://github.com/janetuk/jisc-ac-uk.git
// git checkout -b master --track origin/master

// Fix facet api by symlinking from patched to contrib
$symlink_command = "ln -s /var/www/jisc-ac-uk/sites/all/modules/patched/facetapi /var/www/jisc-ac-uk/sites/all/modules/contrib/facetapi";
// shell_exec($symlink_command);
echo $symlink_command.PHP_EOL;

// Import recent db dump
$dbimport_command = "mysql -u root -proot drupal7_jisc < web02_jisc_2017-05-31_14-22.sql";
// shell_exec($dbimport_command);
echo $dbimport_command.PHP_EOL;

// Drupal admin password
$drupalpwd_command = "drush upwd --password=\"admin\" \"admin\"";
// shell_exec($drupalpwd_command);
echo $drupalpwd_command.PHP_EOL;

// Create a solr core using config from path (then restart)
$solrconf_command = "/opt/solr-6.5.1/bin/solr create_core -c jisc -d /var/www/jisc-ac-uk/sites/all/modules/contrib/search_api_solr/solr-conf/6.x";
echo $solrconf_command.PHP_EOL;

// Search Indexes
$solrindex_command = "drush sapi-i";
echo $solrindex_command = "drush sapi-i".PHP_EOL;
echo "Change solr port to 8983 if using Jetty".PHP_EOL;