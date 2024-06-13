<?php
namespace Grav\Plugin\Console;

use Grav\Plugin\Babel\Babel;
use Grav\Common\Grav;
use Grav\Common\Data\Data;
use Grav\Console\ConsoleCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ReindexCommand
 * @package Grav\Console\Cli\
 */
class ReindexCommand extends ConsoleCommand
{
    /** @var array */
    protected $options = [];

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('reindex')
            ->setAliases(['re-index'])
            ->setDescription('Reindex translations')
            ->setHelp('You may want to reindex after installing new Grav plugins or themes');
    }

    /**
     * @return int
     */
    protected function serve()
    {
        $babel = new Babel();

        $this->output->writeln('');
        $this->output->writeln('<yellow>Current Configuration:</yellow>');
        $this->output->writeln('');

        $grav = Grav::instance();
        $babel_config = new Data($grav['config']->get('plugins.babel'));
        dump($babel_config);

        $this->output->writeln('');

        // capture content
        $babel->createIndex();

        list($status, $msg, $size) = $babel->getIndexStatus();

        $json_response = [
            'status'  => $status ? 'success' : 'error',
            'message' => '<i class="fa fa-book"></i> ' . $msg
        ];
        dump($json_response);

        $this->output->writeln("<green>I'm a teapot!</green>");
        return 0;
    }
}