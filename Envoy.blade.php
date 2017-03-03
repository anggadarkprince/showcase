@servers(['web' => ['sandbox.dev']])

@setup
    $environment = isset($env) ? $env : "testing";
    $repo = 'git@github.com:anggadarkprince/showcase.git';
    $release_dir = '/home/angga/web/showcase/releases';
    $app_dir = '/home/angga/web/showcase/app';
    $release = 'release_' . date('YmdHis');
@endsetup

@macro('deploy', ['on' => 'web'])
    fetch_repo
    run_composer
    update_permissions
    update_symlinks
    completion
@endmacro

@task('fetch_repo')
    echo "----";
    echo "Preparing deploy {{ $release }}"

    echo "----";
    echo "Fetching repo latest source";

    [ -d {{ $release_dir }} ] || mkdir -p {{ $release_dir }};
    cd {{ $release_dir }};
    git clone {{ $repo }} {{ $release }};
@endtask

@task('run_composer')
    echo "----";
    echo "Run composer dependencies";

    cd {{ $release_dir }}/{{ $release }};
    composer install --prefer-dist;
@endtask

@task('update_permissions')
    echo "----";
    echo "Change permission for new release folder";

    cd {{ $release_dir }};
    echo anggaari | sudo -S chgrp -R www-data {{ $release }};
    echo anggaari | sudo -S chmod -R ug+rwx {{ $release }};
@endtask

@task('update_symlinks')
    echo "----";
    echo "Update symlinks to application";

    echo anggaari | sudo -S ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }};
    echo anggaari | sudo -S chgrp -h www-data {{ $app_dir }};
@endtask

@task('completion')
    echo "----";
    echo "Complete!";
@endtask