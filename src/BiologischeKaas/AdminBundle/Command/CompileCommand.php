<?php

namespace AddictedToVintage\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AddictedToVintage\AdminBundle\Compile\lessc;
use AddictedToVintage\AdminBundle\Compile\JavaScriptPacker;

class CompileCommand extends ContainerAwareCommand {

	private $input;
	private $output;
	private $em;

	protected function configure() {
		$this->setName('addictedtovintage:compile')->setDescription('Compile & minify less, css & JS');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

		$this->input = $input;
		$this->output = $output;

		/*
		* WEBSITE
		* Complile only app.less to app.css
		*/
		
		$this->output->write('Compiling app.less => app.css ');

		try {
			$less = new lessc(__DIR__.'/../../EcommerceBundle/Resources/public/less/app.less');
		} catch (exception $ex) {
			$this->output->writeln('<error>lessc fatal error: '.$ex->getMessage() . '</error>');
		}
		
		$this->output->write('<info>Ok</info>');
		
		$this->output->writeln('');
		
		$this->output->writeln('Writing file: EcommerceBundle/Resources/public/css/app-min.css');
	
		file_put_contents(__DIR__.'/../../EcommerceBundle/Resources/public/css/app-min.css', $this->css_cmpress($less->parse()) );
		
		$this->output->writeln('Packing Javascript');
		
		$files = array('app');
		
		$master = null;
		
		foreach($files as $file) { 
		
			$src = ''.__DIR__.'/../../EcommerceBundle/Resources/public/js/'. $file .'.js';
			$out = ''.__DIR__.'/../../EcommerceBundle/Resources/public/js/'. $file .'-min.js';

			$script = file_get_contents($src);

			$t1 = microtime(true);

			$packer = new JavaScriptPacker($script, 'Normal', true, false);
			$packed = $packer->pack();

			$t2 = microtime(true);
			$time = sprintf('%.4f', ($t2 - $t1) );
			
			$this->output->writeln( 'script <info>' . $file . '.js</info> packed in <info>' . $file . '-min.js</info><comment> in ' . $time . ' s</comment>');

			file_put_contents($out, $packed);
			
			$master = $master . $script;
		
		}
		
	}
	
	private function css_cmpress($css){
		$css = preg_replace('!//[^\n\r]+!', '', $css);#comments<br />
		$css = preg_replace('/[\r\n\t\s]+/s', ' ', $css);#new lines, multiple spaces/tabs/newlines<br />
		$css = preg_replace('#/\*.*?\*/#', '', $css);#comments<br />
		$css = preg_replace('/[\s]*([\{\},;:])[\s]*/', '\1', $css);#spaces before and after marks<br />
		$css = preg_replace('/^\s+/', '', $css);#spaces on the begining<br />
		return $css;
	}

}

