<?php

namespace Bancario;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use View;
use Config;
use Request;
use Session;
use ReflectionClass;

use Crypto;

class Bancario
{
    protected $version;
    protected $filesystem;

    public function __construct()
    {
        $this->filesystem = app(Filesystem::class);

        $this->findVersion();
    }

    /**
     * @return void
     */
    protected function findVersion()
    {
        if (!is_null($this->version)) {
            return;
        }

        if ($this->filesystem->exists(base_path('composer.lock'))) {
            // Get the composer.lock file
            $file = json_decode(
                $this->filesystem->get(base_path('composer.lock'))
            );

            // Loop through all the packages and get the version of bancario
            foreach ($file->packages as $package) {
                if ($package->name == 'sierratecnologia/bancario') {
                    $this->version = $package->version;
                    break;
                }
            }
        }
    }
}
