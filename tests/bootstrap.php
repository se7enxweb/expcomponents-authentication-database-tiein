<?php
if ( ! @include __DIR__ . '/../vendor/autoload.php' )
{
    die(<<<'EOT'
You must set up the project dependencies, run the following commands:
wget http://getcomposer.org/composer.phar
php composer.phar install --dev

You can then run tests by calling:

phpunit
EOT
       );
}

// The database the tests create their tables in: an in-memory SQLite database
// unless ZETA_TESTSUITE_DSN is set in the environment (e.g. mysql://user:pass@host/db).
if ( !defined( 'ZETA_TESTSUITE_DSN' ) )
{
    define( 'ZETA_TESTSUITE_DSN', getenv( 'ZETA_TESTSUITE_DSN' ) ?: 'sqlite://:memory:' );
}

// The OpenID tests reuse the OpenID wrapper of the Authentication component's tests.
if ( !defined( 'EXPCOMPONENTS_AUTHENTICATION_TESTS' ) )
{
    define( 'EXPCOMPONENTS_AUTHENTICATION_TESTS',
        \Composer\InstalledVersions::getInstallPath( 'se7enxweb/expcomponents-authentication' ) . '/tests' );
}
