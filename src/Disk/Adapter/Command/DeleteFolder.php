<?php namespace Anomaly\FilesModule\Disk\Adapter\Command;

use Anomaly\FilesModule\Disk\Adapter\AdapterFilesystem;
use Anomaly\FilesModule\Folder\Contract\FolderInterface;
use Anomaly\FilesModule\Folder\Contract\FolderRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use League\Flysystem\Directory;

/**
 * Class DeleteFolder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\FilesModule\Disk\Adapter\Command
 */
class DeleteFolder implements SelfHandling
{

    /**
     * The directory instance.
     *
     * @var Directory
     */
    protected $directory;

    /**
     * Create a new DeleteFolder instance.
     *
     * @param Directory $directory
     */
    function __construct(Directory $directory)
    {
        $this->directory = $directory;
    }

    /**
     * Handle the command.
     *
     * @param FolderRepositoryInterface $folders
     * @return FolderInterface|bool
     */
    public function handle(FolderRepositoryInterface $folders)
    {
        $folder = $folders->findBySlug($this->directory->getPath(), $this->getFilesystemDisk());

        if ($folder && $folders->delete($folder)) {
            return $folder;
        }

        return true;
    }

    /**
     * Get the filesystem's disk.
     *
     * @return \Anomaly\FilesModule\Disk\Contract\DiskInterface|null
     */
    protected function getFilesystemDisk()
    {
        $filesystem = $this->directory->getFilesystem();

        if ($filesystem instanceof AdapterFilesystem) {
            return $filesystem->getDisk();
        }

        return null;
    }
}
