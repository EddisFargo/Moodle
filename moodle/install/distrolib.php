<?php 

function distro_get_config() {

    $config = new stdClass();

    $config->installername = 'Moodle Windows Installer';
    $config->installerversion = '2020061500';
    $config->packname = 'Xampp Portable';
    $config->packversion = '7.3.11-0 Portable (x64)';
    $config->webname = 'Apache';
    $config->webversion = '2.4.41';
    $config->phpname = 'PHP';
    $config->phpversion = '7.3.11 (VC15 X86 64bit thread safe) + PEAR';
    $config->dbname = 'MariaDB';
    $config->dbversion = '10.4.8';
    $config->moodlerelease = '4.0dev (Build: 20210430)';
    $config->moodleversion = '2021052500.89';
    $config->dbtype='mariadb';
    $config->dbhost='localhost';
    $config->dbuser='root';

    return $config;
}

function distro_pre_create_db($database, $dbhost, $dbuser, $dbpass, $dbname, $prefix, $dboptions, $distro) {

/// We need to change the database password in windows installer, only if != ''
    if ($dbpass !== '') {
        try {
            if ($database->connect($dbhost, $dbuser, '', 'mysql', $prefix, $dboptions)) {
                $sql = "UPDATE user SET password=password(?) WHERE user='root'";
                $params = array($dbpass);
                $database->execute($sql, $params);
                $sql = "flush privileges";
                $database->execute($sql);
            }
        } catch (Exception $ignore) {
        }
    }
}
?>
