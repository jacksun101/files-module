<?php namespace Anomaly\FilesModule\Folder;

use Anomaly\FilesModule\Folder\Command\CreateStream;
use Anomaly\FilesModule\Folder\Command\DeleteDirectory;
use Anomaly\FilesModule\Folder\Command\DeleteFiles;
use Anomaly\FilesModule\Folder\Command\DeleteStream;
use Anomaly\FilesModule\Folder\Contract\FolderInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryObserver;

/**
 * Class FolderObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\FilesModule\Folder
 */
class FolderObserver extends EntryObserver
{

    /**
     * Fired just after creating an entry.
     *
     * @param EntryInterface $entry
     */
    public function created(EntryInterface $entry)
    {
        $this->dispatch(new CreateStream($entry));

        parent::created($entry);
    }

    /**
     * Fire just before deleting an entry.
     *
     * @param EntryInterface|FolderInterface $entry
     * @return bool
     */
    public function deleting(EntryInterface $entry)
    {
        $this->dispatch(new DeleteFiles($entry));
        $this->dispatch(new DeleteDirectory($entry));

        return parent::deleting($entry);
    }

    /**
     * Fired just after deleting an entry.
     *
     * @param EntryInterface $entry
     */
    public function deleted(EntryInterface $entry)
    {
        $this->dispatch(new DeleteStream($entry));

        parent::deleted($entry);
    }
}
