<?php
/**
 *	Page parser v0.01
 *
 *
 */

class Page extends Controller
{
	
	function Page()
	{
		parent::Controller();
		$this->load->helper('file');
	}
	
	function index($name='')
	{
		// TODO some database (model) actions to get the right page by the right name
		
		$template = 'test.tpl';
		
		$filename = 'templates/'.$template;
		// See if the template exists:
 		if(!file_exists($filename)) {
			show_error('Template not found: '.$template);
		} else {
			// Load the template:
			$content = read_file($filename);
			// First thing to do is replace the snippets, so we have a complete content page
			// Replace the snippets (recursive)
			while(preg_match('/{-(.*)-}/', $content) > 0) {
				$content = preg_replace('/{-(.*)-}/e', "read_file('templates/snippets/\\1.tpl')", $content);
			}
			// Secondly, parse the loops, so they also get put into the complete content page
			/*
			while(preg_match('/{+(.*)+}/', $content) > 0) {
				
			}
			*/
			// $content = preg_replace('/{\+(.*)\+}/', 'LOOP(\\1)', $content);
			// $content = preg_replace('/{\/\+(.*)\+}/', 'ENDLOOP(\\1)', $content);
			// $content = preg_replace('/{\+(.*)\+}{\/\+(.*)\+}/m', 'LOOP(\\1)ENDLOOP(\\2)', $content);
			
			// Finaly, replace the variables, so all content gets showed:
			$content = preg_replace('/{{(.*)}}/Ue', "Page::getVar('\\1')", $content);
			// Add the parse time for fancy statistics:
			$content.= "\n".'<!-- Parse time: '.$this->benchmark->elapsed_time().' seconds -->';
			// Show the page on the screen:
			$this->output->set_output($content);			
		}
	}
	
	function getVar($key)
	{
		// TODO get the right var from the database
		$vars = array(
			'title'=>'Hello world',
			'header'=>'Heading',
			'content'=>'Content'
		);		
		if(isset($vars[$key])) {
			return($vars[$key]);
		} else {
			return false;
		}
	}
	
	function getLoop($key)
	{
		// TODO get the loop from the database according to the key.
		$vars = array(
			
		);
	}
	
}

?>