<?php namespace Anomaly\FilesModule\File\Command;

use Anomaly\FilesModule\File\Contract\FileInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use League\Flysystem\File;
use League\Flysystem\MountManager;

/**
 * Class GetResource
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\FilesModule\File\Command
 */
class GetResource implements SelfHandling
{

    /**
     * The file instance.
     *
     * @var FileInterface
     */
    protected $file;

    /**
     * Create a new GetResource instance.
     *
     * @param FileInterface $file
     */
    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    /**
     * Handle the command.
     *
     * @param MountManager $manager
     * @return File
     */
    public function handle(MountManager $manager)
    {
        return $manager->get($this->file->location());
    }
}
